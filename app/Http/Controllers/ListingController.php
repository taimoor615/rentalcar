<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with('owner', 'media')->where('is_active', true);

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('daily_rate', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Make filter (exact)
        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }

        // Location filter
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where('location', 'like', "%{$location}%");
        }

        // Search (always applied, can overlap with make/location)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($c) use ($search) {
                $c->where('make', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $listings = $query->paginate(12)->appends($request->query());

        return view('listings.index', compact('listings'));
    }

    public function show(Car $listing)
    {
        $listing->load('owner', 'media', 'reviews.user');
        $averageRating = $listing->averageRating();

        return view('listings.show', compact('listing', 'averageRating'));
    }

    public function create()
    {
        $this->authorize('create', Car::class);
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Car::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'daily_rate' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'specs' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validate as actual images
        ]);

        $validated['owner_id'] = Auth::id();

        $images = $validated['images'] ?? [];
        unset($validated['images']);

        // Create car listing
        $listing = Car::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $listing->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Listing created successfully!');
    }


    public function edit(Car $listing)
    {
        $this->authorize('update', $listing);
        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, Car $listing)
    {
        $this->authorize('update', $listing);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'make' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'daily_rate' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'specs' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $images = $validated['images'] ?? [];
        unset($validated['images']);

        // Update the listing
        $listing->update($validated);

        // Handle image uploads with Media Library
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $listing->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Car listing updated successfully!');
    }

    public function destroy(Car $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Listing deleted successfully!');
    }

    public function deleteMedia($mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $media->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isOwner()) {
            $totalListingsCount = $user->listings()->count();
            // $listings = $user->listings()->with('media')->latest()->get();
            $listings = $user->listings()
            ->with('media')
            ->latest()
            ->paginate(5);
            $bookings = collect();
            foreach ($listings as $listing) {
                $bookings = $bookings->merge($listing->bookings()->with('user')->latest()->get());
            }

            return view('dashboard.host', compact('listings', 'bookings','totalListingsCount'));
        } else {
            $bookings = $user->bookings()->with('car.media')->latest()->get();
            return view('dashboard.guest', compact('bookings'));
        }
    }
}

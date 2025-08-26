<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request, Car $listing)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check availability
        if (!$listing->isAvailable($validated['start_date'], $validated['end_date'])) {
            return back()->withErrors(['dates' => 'The selected dates are not available.']);
        }

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate);
        $totalPrice = $days * $listing->daily_rate;

        $booking = Booking::create([
            'car_id' => $listing->id,
            'renter_id' => Auth::id(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        return redirect()->route('payment.create', $booking)
            ->with('success', 'Booking created! Please complete payment.');
    }

    public function checkAvailability(Request $request, Car $listing){
        // Check availability
        if (!$listing->isAvailable($validated['start_date'], $validated['end_date'])) {
            return back()->withErrors(['dates' => 'The selected dates are not available.']);
        }
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $booking->load('car.media', 'car.owner');

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if ($booking->isConfirmed() && $booking->start_date->isPast()) {
            return back()->withErrors(['error' => 'Cannot cancel a booking that has already started.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}

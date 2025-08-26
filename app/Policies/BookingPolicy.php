<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->renter_id ||
            $user->id === $booking->listing->owner_id;
    }

    public function pay(User $user, Booking $booking): bool
    {
        return $user->id === $booking->renter_id && $booking->isPending();
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $user->id === $booking->renter_id ||
            $user->id === $booking->listing->owner_id;
    }
}

<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CarPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Car $listing): bool
    {
        return $listing->is_active;
    }

    public function create(User $user): bool
    {
        return $user->isOwner();
    }

    public function update(User $user, Car $listing): bool
    {
        return $user->isOwner() && $user->id === $listing->owner_id;
    }

    public function delete(User $user, Car $listing): bool
    {
        return $user->isOwner() && $user->id === $listing->owner_id;
    }
}

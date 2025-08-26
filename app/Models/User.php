<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, Billable, InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'bio'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isOwner()
    {
        return strtolower($this->role) === 'owner';
    }

    public function isRenter()
    {
        return $this->role === 'renter';
    }

    public function listings()
    {
        return $this->hasMany(Car::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'renter_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

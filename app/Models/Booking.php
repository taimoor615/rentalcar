<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'renter_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'stripe_payment_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }

    public function getDaysAttribute()
    {
        return Carbon::parse($this->start_date)->diffInDays(Carbon::parse($this->end_date));
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isUpcoming()
    {
        return $this->start_date > now();
    }

    public function isPast()
    {
        return $this->end_date < now();
    }

    public function isActive()
    {
        return $this->start_date <= now() && $this->end_date >= now();
    }
}

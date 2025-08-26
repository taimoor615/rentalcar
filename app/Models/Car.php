<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;

class Car extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'owner_id',
        'title',
        'make',
        'model',
        'year',
        'daily_rate',
        'location',
        'specs',
        'images',
    ];

    protected $casts = [
        'specs' => 'array',
        'images' => 'array',
        'daily_rate' => 'decimal:2',
        'year' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function confirmedBookings()
    {
        return $this->hasMany(Booking::class)->where('status', 'confirmed');
    }

    public function isAvailable($startDate, $endDate, $excludeBookingId = null)
    {
        $query = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('start_date', '<=', $startDate)
                         ->where('end_date', '>=', $endDate);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    public function calculateTotalPrice($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $days = $start->diffInDays($end);

        return $this->daily_rate * $days;
    }

    public function getFullNameAttribute()
    {
        return $this->year . ' ' . $this->make . ' ' . $this->model;
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('large')
            ->width(800)
            ->height(600)
            ->sharpen(10);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}

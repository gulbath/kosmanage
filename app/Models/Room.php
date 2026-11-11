<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'room_number',
        'type',
        'price',
        'description',
        'facilities',
        'status',
    ];

    public function occupancies(): HasMany
    {
        return $this->hasMany(Occupancy::class);
    }

    public function currentOccupancy(): HasOne
    {
        return $this->hasOne(Occupancy::class)->where('status', 'active');
    }
}
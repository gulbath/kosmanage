<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_number',
        'occupancy_id',
        'user_id',
        'period_month',
        'period_year',
        'amount',
        'due_date',
        'status',
    ];

    /**
     * Accessor untuk menghasilkan teks periode (contoh: "Desember 2026")
     */
    public function getPeriodAttribute()
    {
        if ($this->period_month && $this->period_year) {
            return Carbon::createFromDate($this->period_year, $this->period_month, 1)->translatedFormat('F Y');
        }
        return '-';
    }

    /**
     * Relasi ke model Occupancy (Hunian)
     */
    public function occupancy()
    {
        return $this->belongsTo(Occupancy::class);
    }

    /**
     * Relasi ke model User (Penyewa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Payment (Pembayaran)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'tenants';

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'emergency_contact',
        'identity_card',
    ];

    /**
     * Relasi ke model User (jika penyewa terhubung dengan akun login portal).
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke semua riwayat persewaan / okupansi kamar.
     *
     * @return HasMany
     */
    public function occupancies(): HasMany
    {
        return $this->hasMany(Occupancy::class);
    }

    /**
     * Helper relasi untuk mengambil data sewa kamar yang sedang aktif saat ini.
     *
     * @return HasOne
     */
    public function activeOccupancy(): HasOne
    {
        return $this->hasOne(Occupancy::class)->where('is_active', true);
    }
}
<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Occupancy;
use Illuminate\Http\Request;

class BookingApprovalController extends Controller
{
    /**
     * Menampilkan daftar pengajuan booking yang membutuhkan konfirmasi.
     */
    public function index()
    {
        $pendingBookings = Occupancy::with(['user', 'room'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('owner.bookings.index', compact('pendingBookings'));
    }

    /**
     * Menyetujui booking kamar dan mengubah status kamar menjadi occupied.
     */
    public function approve(Occupancy $occupancy)
    {
        // 1. Ubah status hunian tenant menjadi 'active'
        $occupancy->update(['status' => 'active']);

        // 2. Ubah status kamar menjadi 'occupied' (Terisi)
        if ($occupancy->room) {
            $occupancy->room->update(['status' => 'occupied']);
        }

        return back()->with('success', 'Pengajuan booking disetujui! Kamar resmi bertanda Terisi.');
    }

    /**
     * Menolak booking kamar.
     */
    public function reject(Occupancy $occupancy)
    {
        $occupancy->update(['status' => 'rejected']);
        
        return back()->with('success', 'Pengajuan booking telah ditolak.');
    }
}
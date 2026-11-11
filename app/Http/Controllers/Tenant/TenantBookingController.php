<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Occupancy;
use App\Models\Room;
use Illuminate\Http\Request;

class TenantBookingController extends Controller
{
    /**
     * Menampilkan daftar kamar yang tersedia untuk dipesan tenant.
     */
    public function index()
    {
        $rooms = Room::where('status', 'available')->get();
        return view('tenant.rooms.index', compact('rooms'));
    }

    /**
     * Mengajukan booking kamar oleh tenant.
     */
    public function store(Request $request, Room $room)
    {
        $user = $request->user();

        // Cek apakah tenant sudah punya hunian aktif atau pending
        $existingOccupancy = Occupancy::where('user_id', $user->id)
            ->whereIn('status', ['active', 'pending'])
            ->first();

        if ($existingOccupancy) {
            return back()->with('error', 'Anda masih memiliki hunian aktif atau pengajuan booking yang sedang diproses.');
        }

        if ($room->status !== 'available') {
            return back()->with('error', 'Maaf, kamar ini baru saja dipesan oleh orang lain.');
        }

        // Buat pengajuan booking (status pending)
        Occupancy::create([
            'user_id'      => $user->id,
            'room_id'      => $room->id,
            'agreed_price' => $room->price,
            'start_date'   => now(),
            'status'       => 'pending',
        ]);

        return redirect()->route('tenant.dashboard')
            ->with('success', 'Pengajuan booking kamar berhasil dikirim! Menunggu konfirmasi dari Pemilik Kos.');
    }
}
<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreRoomRequest;
use App\Models\Occupancy;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function checkout(Occupancy $occupancy)
{
    // Ubah status hunian jadi completed/cancelled
    $occupancy->update([
        'status' => 'completed',
        'end_date' => now(),
    ]);

    // Kembalikan status kamar jadi available
    if ($occupancy->room) {
        $occupancy->room->update(['status' => 'available']);
    }

    return back()->with('success', 'Tenant telah checkout dan kamar kembali tersedia.');
}

    public function index(Request $request)
    {
        $query = Room::with('currentOccupancy.tenant');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->latest()->paginate(10);

        return view('owner.rooms.index', compact('rooms'));
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        Room::create($request->validated());

        return redirect()->route('owner.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        if ($room->status === 'occupied' || $room->currentOccupancy()->exists()) {
            return back()->withErrors(['error' => 'Kamar tidak dapat dihapus karena sedang terisi oleh penyewa aktif.']);
        }

        $room->delete();

        return redirect()->route('owner.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
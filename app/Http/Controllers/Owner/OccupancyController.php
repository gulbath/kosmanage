<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreOccupancyRequest;
use App\Models\Occupancy;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class OccupancyController extends Controller
{
   public function index()
    {
        $occupancies = Occupancy::with(['room', 'user'])->latest()->get();
        $rooms = Room::where('status', 'available')->get();
        $tenants = User::where('role', 'tenant')->where('status', 'active')->get();

        return view('owner.tenants.index', compact('occupancies', 'rooms', 'tenants'));
    }

    public function store(StoreOccupancyRequest $request): RedirectResponse
    {
        return DB::transaction(function () use ($request) {
            $room = Room::findOrFail($request->room_id);

            if ($room->status !== 'available') {
                return back()->withErrors(['room_id' => 'Kamar ini sedang tidak tersedia untuk disewa.']);
            }

            // Buat catatan Okupansi
            Occupancy::create([
                'room_id' => $room->id,
                'user_id' => $request->user_id,
                'agreed_price' => $request->agreed_price,
                'start_date' => $request->start_date,
                'status' => 'active',
            ]);

            // Update status kamar menjadi terisi
            $room->update(['status' => 'occupied']);

            return redirect()->route('owner.rooms.index')->with('success', 'Penyewa berhasil ditempatkan di kamar.');
        });
    }

    public function checkout(Occupancy $occupancy): RedirectResponse
    {
        return DB::transaction(function () use ($occupancy) {
            $occupancy->update([
                'status' => 'finished',
                'end_date' => now()->toDateString(),
            ]);

            $occupancy->room->update(['status' => 'available']);

            return back()->with('success', 'Masa sewa telah diakhiri dan kamar kembali kosong.');
        });
    }
}
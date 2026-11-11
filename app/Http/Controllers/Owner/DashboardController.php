<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Occupancy;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama portal owner.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Ambil data statistik untuk dashboard owner
        $totalRooms = Room::count();
        $occupiedRooms = Occupancy::where('status', 'active')->count();
        $unpaidBillsCount = Bill::where('status', 'unpaid')->count();
        $pendingPaymentsCount = Bill::where('status', 'pending')->count();

        $recentBills = Bill::with(['occupancy.room', 'user'])->latest()->take(5)->get();

        return view('owner.dashboard', compact(
            'user',
            'totalRooms',
            'occupiedRooms',
            'unpaidBillsCount',
            'pendingPaymentsCount',
            'recentBills'
        ));
    }
}
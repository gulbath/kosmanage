<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Occupancy;
use Illuminate\Http\Request;

class TenantDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama portal penyewa.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Ambil data hunian aktif penyewa beserta informasi kamar
        $occupancy = Occupancy::with('room')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        // Ambil seluruh tagihan milik penyewa
        $bills = Bill::where('user_id', $user->id)
            ->latest()
            ->get();

        // Tagihan aktif (belum lunas / sedang diverifikasi)
        $activeBill = $bills->whereIn('status', ['unpaid', 'pending'])->first();

        $unpaidBillsCount = $bills->where('status', 'unpaid')->count();
        $pendingBillsCount = $bills->where('status', 'pending')->count();

        return view('tenant.dashboard', compact(
            'user',
            'occupancy',
            'bills',
            'activeBill',
            'unpaidBillsCount',
            'pendingBillsCount'
        ));
    }
}
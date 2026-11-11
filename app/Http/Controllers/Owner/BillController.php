<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Occupancy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Menampilkan daftar tagihan di portal owner.
     */
    public function index()
    {
        $bills = Bill::with(['occupancy.room', 'user'])
            ->latest()
            ->get();

        $occupancies = Occupancy::with(['user', 'room'])
            ->where('status', 'active')
            ->get();

        return view('owner.bills.index', compact('bills', 'occupancies'));
    }

    /**
     * Menyimpan tagihan sewa baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'occupancy_id' => ['required', 'exists:occupancies,id'],
            'amount'       => ['required', 'numeric', 'min:0'],
            'due_date'     => ['required', 'date'],
        ]);

        $occupancy = Occupancy::findOrFail($validated['occupancy_id']);

        // Generate nomor tagihan otomatis unik: INV-20261110-XXXX
        $billNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Ambil nilai bulan & tahun dari tanggal jatuh tempo (due_date)
        $dueDate = Carbon::parse($validated['due_date']);
        $periodMonth = $dueDate->month; // 1 - 12
        $periodYear  = $dueDate->year;  // Contoh: 2026

        Bill::create([
            'bill_number'  => $billNumber,
            'occupancy_id' => $validated['occupancy_id'],
            'user_id'      => $occupancy->user_id,
            'period_month' => $periodMonth,
            'period_year'  => $periodYear,
            'amount'       => $validated['amount'],
            'due_date'     => $validated['due_date'],
            'status'       => 'unpaid',
        ]);

        return redirect()->route('owner.bills.index')
            ->with('success', 'Tagihan sewa baru berhasil diterbitkan!');
    }

    /**
     * Menghapus tagihan sewa.
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();

        return redirect()->route('owner.bills.index')
            ->with('success', 'Tagihan berhasil dihapus!');
    }
}
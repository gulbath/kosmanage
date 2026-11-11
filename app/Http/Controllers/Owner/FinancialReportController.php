<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinancialReportController extends Controller
{
    /**
     * Menampilkan laporan keuangan (pemasukan, pengeluaran, dan laba bersih).
     */
    public function index(Request $request)
    {
        // Rentang tanggal filter (default: awal bulan sampai akhir bulan ini)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Hitung total pemasukan dari pembayaran yang disetujui (approved)
        $totalRevenue = Payment::where('status', 'approved')
            ->whereBetween('payment_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');

        // Hitung total pengeluaran operasional
        $totalExpense = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');

        // Keuntungan bersih
        $netProfit = $totalRevenue - $totalExpense;

        // Detail Rincian Transaksi Pemasukan (Menggunakan relasi 'user' & 'bill.occupancy.room')
        $payments = Payment::with(['user', 'bill.occupancy.room'])
            ->where('status', 'approved')
            ->whereBetween('payment_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->get();

        // Detail Rincian Pengeluaran
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('owner.reports.index', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'totalExpense',
            'netProfit',
            'payments',
            'expenses'
        ));
    }
}
<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentVerificationController extends Controller
{
    /**
     * Menampilkan daftar pembayaran yang membutuhkan verifikasi owner.
     */
    public function index()
    {
        $payments = Payment::with(['bill.occupancy.room', 'user'])
            ->latest()
            ->get();

        return view('owner.payments.index', compact('payments'));
    }

    /**
     * Menyetujui pembayaran (Verifikasi Lunas).
     */
    public function approve(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            // Update status pembayaran
            $payment->update([
                'status' => 'approved',
            ]);

            // Update status tagihan terkait menjadi paid (Lunas)
            if ($payment->bill) {
                $payment->bill->update([
                    'status' => 'paid',
                ]);
            }
        });

        return back()->with('success', 'Pembayaran berhasil diverifikasi! Status tagihan kini Lunas.');
    }

    /**
     * Menolak pembayaran.
     */
    public function reject(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            // Update status pembayaran
            $payment->update([
                'status' => 'rejected',
            ]);

            // Kembalikan status tagihan menjadi unpaid agar tenant bisa upload ulang
            if ($payment->bill) {
                $payment->bill->update([
                    'status' => 'unpaid',
                ]);
            }
        });

        return back()->with('success', 'Pembayaran telah ditolak. Status tagihan dikembalikan menjadi Belum Dibayar.');
    }
}
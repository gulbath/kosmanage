<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TenantBillController extends Controller
{
    /**
     * Menampilkan daftar tagihan tenant.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        $bills = Bill::where('user_id', $userId)
            ->latest()
            ->get();

        return view('tenant.bills.index', compact('bills'));
    }

    /**
     * Menampilkan detail tagihan dan form pembayaran.
     */
    public function show(Bill $bill)
    {
        // Pastikan tenant hanya bisa mengakses tagihan miliknya sendiri
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $bill->load(['payments', 'occupancy.room']);

        return view('tenant.bills.show', compact('bill'));
    }

    /**
     * Memproses upload bukti transfer pembayaran tagihan.
     */
    public function confirmPayment(Request $request, Bill $bill)
    {
        if ($bill->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'proof_file' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'amount'     => ['nullable', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request, $bill, $validated) {
            // Simpan berkas bukti transfer ke folder storage/app/public/proofs
            $proofPath = $request->file('proof_file')->store('proofs', 'public');

            // Catat pengajuan pembayaran baru dengan menyertakan payment_date
            Payment::create([
                'bill_id'      => $bill->id,
                'user_id'      => Auth::id(),
                'payment_date' => now(), // <-- Mengisi tanggal pembayaran otomatis
                'amount'       => $validated['amount'] ?? $bill->amount,
                'proof_file'   => $proofPath,
                'status'       => 'pending',
            ]);

            // Ubah status tagihan menjadi pending (menunggu verifikasi owner)
            $bill->update([
                'status' => 'pending',
            ]);
        });

        return redirect()->route('tenant.bills.show', $bill->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi dari pemilik kos.');
    }
}
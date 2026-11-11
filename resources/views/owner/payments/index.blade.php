@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h1>
            <p class="text-slate-500 text-sm">Periksa bukti transfer dan konfirmasi pembayaran dari penyewa.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4">Penyewa & Kamar</th>
                    <th class="px-6 py-4">Nominal</th>
                    <th class="px-6 py-4">Tanggal Transfer</th>
                    <th class="px-6 py-4">Bukti Transfer</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800">{{ $payment->user->name ?? 'Penyewa' }}</div>
                            <div class="text-xs text-slate-400">Kamar: {{ $payment->bill->occupancy->room->room_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($payment->proof_file)
                                <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" 
                                   class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline gap-1">
                                    <span class="material-symbols-outlined text-[16px]">image</span>
                                    Lihat Foto
                                </a>
                            @else
                                <span class="text-xs text-slate-400">Tidak ada berkas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($payment->status === 'pending')
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200/60">
                                    Menunggu Verifikasi
                                </span>
                            @elseif($payment->status === 'approved')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200/60">
                                    Disetujui
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-xs font-semibold rounded-full border border-rose-200/60">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($payment->status === 'pending')
                                <form action="{{ route('owner.payments.approve', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                        Setujui (Lunas)
                                    </button>
                                </form>
                                <form action="{{ route('owner.payments.reject', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                        Tolak
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                            Belum ada riwayat pengajuan pembayaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
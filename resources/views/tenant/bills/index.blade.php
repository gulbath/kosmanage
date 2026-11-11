<x-layouts.tenant>
    <div class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tagihan & Pembayaran Saya</h1>
                <p class="text-sm text-slate-500">Lihat riwayat tagihan sewa kamar dan unggah bukti transfer pembayaran Anda.</p>
            </div>
        </div>

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Tabel Tagihan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Riwayat Seluruh Tagihan</h2>
                <span class="text-xs text-slate-500">Total: {{ count($bills) }} Data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Periode / Bulan</th>
                            <th class="px-6 py-3.5">Nominal Tagihan</th>
                            <th class="px-6 py-3.5">Jatuh Tempo</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($bills as $bill)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    {{ $bill->period }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($bill->status === 'paid')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">• Lunas</span>
                                    @elseif ($bill->status === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">• Menunggu Verifikasi</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">• Belum Dibayar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('tenant.bills.show', $bill->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                        <span class="material-symbols-outlined text-[16px] mr-1">payments</span>
                                        Bayar / Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-xs">
                                    Belum ada tagihan sewa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.tenant>
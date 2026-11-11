<x-layouts.owner>
    <div class="p-6 space-y-6">
        <!-- Header & Filter Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Laporan Keuangan Kos</h1>
                <p class="text-sm text-slate-500">Rekapitulasi pemasukan sewa, pengeluaran operasional, dan laba bersih.</p>
            </div>

            <!-- Form Filter Tanggal -->
            <form action="{{ route('owner.reports.index') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
                <input type="date" name="start_date" value="{{ $startDate }}" class="px-3 py-1.5 text-xs font-medium border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500">
                <span class="text-xs text-slate-400">s/d</span>
                <input type="date" name="end_date" value="{{ $endDate }}" class="px-3 py-1.5 text-xs font-medium border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500">
                <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors">
                    Filter
                </button>
            </form>
        </div>

        <!-- Ringkasan Kinerja Keuangan (Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Total Pemasukan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pemasukan</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pengeluaran</p>
                    <h3 class="text-2xl font-extrabold text-rose-600 mt-1">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <span class="material-symbols-outlined">shopping_cart</span>
                </div>
            </div>

            <!-- Keuntungan Bersih (Laba) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Laba Bersih</p>
                    <h3 class="text-2xl font-extrabold {{ $netProfit >= 0 ? 'text-indigo-600' : 'text-rose-600' }} mt-1">
                        Rp {{ number_format($netProfit, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
            </div>
        </div>

        <!-- Tabel Detail Pemasukan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-sm">Rincian Pemasukan Sewa (Lunas)</h2>
                <span class="text-xs text-slate-400">Total: {{ count($payments) }} Transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Tanggal Verifikasi</th>
                            <th class="px-6 py-3.5">Penyewa & Kamar</th>
                            <th class="px-6 py-3.5">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-800">{{ $payment->user->name ?? 'Penyewa' }}</div>
                                    <div class="text-xs text-slate-400">Kamar: {{ $payment->bill->occupancy->room->room_number ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-emerald-600">
                                    + Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-400 text-xs">
                                    Tidak ada data pemasukan pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Detail Pengeluaran -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-sm">Rincian Pengeluaran Operasional</h2>
                <span class="text-xs text-slate-400">Total: {{ count($expenses) }} Catatan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5">Kategori / Nama</th>
                            <th class="px-6 py-3.5">Keterangan</th>
                            <th class="px-6 py-3.5">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($expenses as $expense)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ \Carbon\Carbon::parse($expense->expense_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $expense->category }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $expense->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-rose-600">
                                    - Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs">
                                    Tidak ada data pengeluaran pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.owner>
<x-layouts.owner>
    <div class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Selamat Datang, {{ $user->name ?? Auth::user()->name ?? 'Pemilik' }} 👋
                </h1>
                <p class="text-sm text-slate-500">Ringkasan operasional, hunian kamar, dan tagihan kos Anda.</p>
            </div>
            <div>
                <a href="{{ route('owner.bills.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    Buat Tagihan Baru
                </a>
            </div>
        </div>

        <!-- Flash Alert -->
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Card Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Kamar -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500">Total Unit Kamar</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalRooms ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <span class="material-symbols-outlined">meeting_room</span>
                </div>
            </div>

            <!-- Kamar Terisi -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500">Kamar Terisi</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $occupiedRooms ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <span class="material-symbols-outlined">person_pin</span>
                </div>
            </div>

            <!-- Menunggu Verifikasi -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500">Menunggu Verifikasi</p>
                    <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ $pendingPaymentsCount ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <span class="material-symbols-outlined">pending</span>
                </div>
            </div>

            <!-- Tagihan Belum Dibayar -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500">Belum Dibayar</p>
                    <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ $unpaidBillsCount ?? 0 }}</h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <span class="material-symbols-outlined">warning</span>
                </div>
            </div>
        </div>

        <!-- Tabel Tagihan Terbaru -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Tagihan Terbaru</h2>
                <a href="{{ route('owner.bills.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Penyewa & Kamar</th>
                            <th class="px-6 py-3.5">Periode</th>
                            <th class="px-6 py-3.5">Nominal</th>
                            <th class="px-6 py-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse (($recentBills ?? []) as $bill)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $bill->user->name ?? $bill->occupancy->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-500">Kamar: {{ $bill->occupancy->room->room_number ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium">{{ $bill->period }}</td>
                                <td class="px-6 py-4 font-semibold">Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if ($bill->status === 'paid')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Lunas</span>
                                    @elseif ($bill->status === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">Verifikasi</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">Belum Bayar</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-xs">
                                    Belum ada data tagihan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.owner>
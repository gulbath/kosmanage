<x-layouts.tenant>
    <div class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang, {{ $user->name ?? 'Penyewa' }} 👋</h1>
                <p class="text-sm font-medium text-slate-500">Pantau status kamar, informasi hunian, dan riwayat tagihan sewa Anda di sini.</p>
            </div>
            <div>
                <a href="{{ route('tenant.bills.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    Lihat Semua Tagihan
                </a>
            </div>
        </div>

        <!-- Flash Alert -->
        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm flex items-center justify-between font-medium">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm flex items-center justify-between font-medium">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-600">error</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Card Informasi Hunian & Ringkasan Tagihan -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Kamar Saya (Latar Belakang Gelap Kustom & Teks Kontras Terang) -->
            <div class="lg:col-span-1 bg-slate-900 text-white rounded-2xl p-6 shadow-xl border border-slate-800 relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full tracking-wide">
                            Info Kamar Saya
                        </span>
                        <span class="material-symbols-outlined text-indigo-400 text-[26px]">king_bed</span>
                    </div>

                    @if (isset($occupancy) && $occupancy && $occupancy->room)
                        <div class="space-y-1 mt-2">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">NOMOR KAMAR</p>
                            <h2 class="text-4xl font-black text-white tracking-tight">Kamar {{ $occupancy->room->room_number }}</h2>
                            <p class="text-xs text-indigo-400 font-bold pt-1">
                                {{ $occupancy->room->name ?? 'Tipe Standar' }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-800 grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <p class="text-slate-400 font-semibold">Tanggal Masuk</p>
                                <p class="font-extrabold text-white text-sm mt-0.5">
                                    {{ $occupancy->start_date ? \Carbon\Carbon::parse($occupancy->start_date)->translatedFormat('d M Y') : '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-slate-400 font-semibold">Harga Sewa</p>
                                <p class="font-extrabold text-emerald-400 text-sm mt-0.5">
                                    Rp {{ number_format($occupancy->agreed_price ?? $occupancy->room->price ?? 0, 0, ',', '.') }}<span class="text-[10px] text-slate-400 font-normal">/bln</span>
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="py-8 text-center space-y-2">
                            <span class="material-symbols-outlined text-[40px] text-slate-500">meeting_room</span>
                            <p class="text-sm font-semibold text-white">Belum terdaftar di kamar manapun.</p>
                            <p class="text-xs text-slate-400">Hubungi pemilik kos untuk menetapkan kamar Anda.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-slate-800 flex items-center justify-between text-xs font-medium">
                    <span class="flex items-center gap-2 text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full {{ isset($occupancy) && $occupancy ? 'bg-emerald-400 animate-pulse' : 'bg-slate-500' }}"></span>
                        Status Hunian: <strong class="text-white">{{ isset($occupancy) && $occupancy ? 'Aktif' : 'Belum Aktif' }}</strong>
                    </span>
                </div>
            </div>

            <!-- Ringkasan Status Tagihan -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Tagihan Belum Dibayar -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Tagihan Belum Dibayar</p>
                        <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl">
                            <span class="material-symbols-outlined text-[22px]">error</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-3xl font-black text-slate-900">{{ $unpaidBillsCount ?? 0 }}</h3>
                        <p class="text-xs text-rose-600 font-semibold mt-1">
                            {{ ($unpaidBillsCount ?? 0) > 0 ? 'Segera lakukan pembayaran sebelum jatuh tempo' : 'Tidak ada tagihan tertunggak' }}
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100">
                        <a href="{{ route('tenant.bills.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                            Bayar Sekarang <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- Menunggu Verifikasi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Menunggu Verifikasi</p>
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                            <span class="material-symbols-outlined text-[22px]">pending</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-3xl font-black text-slate-900">{{ $pendingBillsCount ?? 0 }}</h3>
                        <p class="text-xs text-amber-600 font-semibold mt-1">
                            {{ ($pendingBillsCount ?? 0) > 0 ? 'Bukti transfer sedang diproses oleh pemilik' : 'Tidak ada pembayaran diproses' }}
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-100">
                        <a href="{{ route('tenant.bills.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                            Cek Detail Status <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Tagihan Terbaru -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-900 text-base">Daftar Tagihan Terbaru</h2>
                <a href="{{ route('tenant.bills.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Periode / Bulan</th>
                            <th class="px-6 py-3.5">Nominal Tagihan</th>
                            <th class="px-6 py-3.5">Jatuh Tempo</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse (($bills ?? []) as $bill)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $bill->period ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 font-medium">{{ $bill->description ?? 'Tagihan Sewa Kamar' }}</div>
                                </td>
                                <td class="px-6 py-4 font-extrabold text-slate-900">
                                    Rp {{ number_format($bill->amount ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                                    {{ $bill->due_date ? \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if (($bill->status ?? '') === 'paid')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>
                                    @elseif (($bill->status ?? '') === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('tenant.bills.show', $bill->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        Detail / Bayar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[48px] text-slate-300">receipt_long</span>
                                        <p class="text-sm font-semibold text-slate-600">Belum ada tagihan sewa diterbitkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.tenant>
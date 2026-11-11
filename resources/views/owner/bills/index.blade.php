<x-layouts.owner>
    <div class="p-6">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Tagihan</h1>
                <p class="text-slate-500 text-sm">Kelola dan terbitkan tagihan sewa kamar untuk penyewa kos.</p>
            </div>
            
            <!-- Tombol Modal / Buat Tagihan Baru -->
            <button type="button" 
                    onclick="document.getElementById('modalCreateBill').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-all duration-150">
                <span class="material-symbols-outlined text-[20px] mr-1.5">add</span>
                Buat Tagihan Baru
            </button>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h2 class="font-bold text-slate-800 text-sm">Daftar Seluruh Tagihan</h2>
                <span class="text-xs text-slate-400">Total: {{ count($bills) }} Tagihan</span>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-4">Penyewa & Kamar</th>
                        <th class="px-6 py-4">Periode / Bulan</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Jatuh Tempo</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($bills as $bill)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $bill->user->name ?? 'Penyewa' }}</div>
                                <div class="text-xs text-slate-400">Kamar: {{ $bill->occupancy->room->room_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-md">
                                    {{ $bill->period }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($bill->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($bill->status === 'paid')
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200/60">
                                        • Lunas
                                    </span>
                                @elseif($bill->status === 'pending')
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-semibold rounded-full border border-amber-200/60">
                                        • Menunggu Verifikasi
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-xs font-semibold rounded-full border border-rose-200/60">
                                        • Belum Dibayar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($bill->status === 'pending')
                                    <a href="{{ route('owner.payments.index') }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                                        <span class="material-symbols-outlined text-[16px] mr-1">visibility</span>
                                        Verifikasi Bukti
                                    </a>
                                @elseif($bill->status === 'unpaid')
                                    <span class="text-xs text-slate-400">Menunggu Pembayaran</span>
                                @else
                                    <span class="text-xs font-semibold text-emerald-600">Terverifikasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                Belum ada data tagihan yang diterbitkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form Buat Tagihan Baru -->
    <div id="modalCreateBill" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Buat Tagihan Baru</h3>
                <button type="button" onclick="document.getElementById('modalCreateBill').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('owner.bills.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pilih Hunian / Penyewa</label>
                    <select name="occupancy_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                        <option value="">-- Pilih Penyewa --</option>
                        @foreach($occupancies as $occ)
                            <option value="{{ $occ->id }}">
                                {{ $occ->user->name ?? 'Penyewa' }} - Kamar {{ $occ->room->room_number ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nominal Tagihan (Rp)</label>
                    <input type="number" name="amount" required min="0" placeholder="Contoh: 450000" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Tanggal Jatuh Tempo</label>
                    <input type="date" name="due_date" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('modalCreateBill').classList.add('hidden')" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.owner>
<x-layouts.tenant>
    <div class="p-6 space-y-6 max-w-4xl mx-auto">
        <!-- Back Link & Header -->
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.bills.index') }}" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail Tagihan #{{ $bill->id }}</h1>
                <p class="text-sm text-slate-500">Periode {{ $bill->period }}</p>
            </div>
        </div>

        <!-- Flash Alert -->
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Information Card Tagihan -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <h2 class="font-bold text-slate-800 text-lg border-b border-slate-100 pb-3">Informasi Pembayaran</h2>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Bulan / Periode</span>
                        <span class="font-semibold text-slate-800">{{ $bill->period }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Jatuh Tempo</span>
                        <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($bill->due_date)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kamar</span>
                        <span class="font-semibold text-slate-800">Kamar {{ $bill->occupancy->room->room_number ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-slate-100">
                        <span class="text-slate-500 font-semibold">Total Tagihan</span>
                        <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-slate-500">Status</span>
                        @if ($bill->status === 'paid')
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Lunas</span>
                        @elseif ($bill->status === 'pending')
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">Menunggu Verifikasi</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">Belum Dibayar</span>
                        @endif
                    </div>
                </div>

                @if($bill->description)
                    <div class="pt-3 border-t border-slate-100 text-xs text-slate-500">
                        <span class="font-semibold text-slate-700 block mb-1">Catatan Tagihan:</span>
                        {{ $bill->description }}
                    </div>
                @endif
            </div>

            <!-- Upload Bukti Transfer Form / Status Payment -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <h2 class="font-bold text-slate-800 text-lg border-b border-slate-100 pb-3">Konfirmasi Transfer</h2>

                @if ($bill->status === 'unpaid')
                    <form action="{{ route('tenant.bills.confirm', $bill->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Unggah Bukti Transfer (JPG/PNG, Max 2MB)</label>
                            <input type="file" name="proof_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors" required>
                            @error('proof_file') <span class="text-xs text-rose-500 block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Pembayaran (Opsional)</label>
                            <textarea name="note" rows="2" placeholder="Transfer via BCA a.n..." class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">upload</span>
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                @elseif ($bill->status === 'pending')
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 space-y-2">
                        <div class="flex items-center gap-2 font-semibold text-amber-900">
                            <span class="material-symbols-outlined text-amber-600">pending</span>
                            <span>Bukti Pembayaran Terkirim</span>
                        </div>
                        <p>Bukti transfer Anda telah dikirim dan sedang dalam proses verifikasi oleh pemilik kos.</p>
                    </div>
                @else
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 space-y-2">
                        <div class="flex items-center gap-2 font-semibold text-emerald-900">
                            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                            <span>Pembayaran Lunas</span>
                        </div>
                        <p>Tagihan ini telah diverifikasi dan dinyatakan lunas oleh pemilik kos.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.tenant>
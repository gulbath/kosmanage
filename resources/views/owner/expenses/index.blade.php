<x-layouts.owner>
    <div class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengeluaran</h1>
                <p class="text-sm text-slate-500">Catat dan pantau seluruh pengeluaran operasional kos.</p>
            </div>
            <button onclick="document.getElementById('createExpenseModal').classList.remove('hidden')" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Pengeluaran Baru
            </button>
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

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm space-y-1">
                <div class="flex items-center gap-2 font-semibold">
                    <span class="material-symbols-outlined text-rose-600">error</span>
                    <span>Terjadi kesalahan pada pengisian form:</span>
                </div>
                <ul class="list-disc list-inside pl-6 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Ringkasan Pengeluaran -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">
                        Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}
                    </h3>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500">Jumlah Catatan</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1">
                        {{ count($expenses) }} Transaksi
                    </h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <span class="material-symbols-outlined">receipt_long</span>
                </div>
            </div>
        </div>

        <!-- Tabel Data Pengeluaran -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Daftar Pengeluaran Operasional</h2>
                <span class="text-xs text-slate-500">Total: {{ count($expenses) }} Data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5">Kategori / Nama Pengeluaran</th>
                            <th class="px-6 py-3.5">Keterangan</th>
                            <th class="px-6 py-3.5">Nominal</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($expenses as $expense)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Tanggal -->
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ \Carbon\Carbon::parse($expense->expense_date ?? $expense->date ?? $expense->created_at)->translatedFormat('d M Y') }}
                                </td>

                                <!-- Nama / Kategori -->
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $expense->name ?? $expense->title ?? $expense->category ?? 'Pengeluaran Kos' }}</div>
                                    @if(isset($expense->category) && ($expense->name || $expense->title))
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 mt-1">
                                            {{ $expense->category }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Keterangan -->
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">
                                    {{ $expense->description ?? $expense->note ?? '-' }}
                                </td>

                                <!-- Nominal -->
                                <td class="px-6 py-4 font-semibold text-rose-600">
                                    Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('owner.expenses.destroy', $expense->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors" title="Hapus Pengeluaran">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[48px] text-slate-300">request_quote</span>
                                        <p class="text-sm font-medium">Belum ada catatan pengeluaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengeluaran Baru -->
    <div id="createExpenseModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-lg">Tambah Pengeluaran Baru</h3>
                <button onclick="document.getElementById('createExpenseModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('owner.expenses.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama / Keperluan Pengeluaran</label>
                    <input type="text" name="name" placeholder="Contoh: Perbaikan Pompa Air / Bayar Listrik" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori (Opsional)</label>
                    <select name="category" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Operasional">Operasional (Listrik/Air/WiFi)</option>
                        <option value="Pemeliharaan">Pemeliharaan & Perbaikan</option>
                        <option value="Kebersihan">Kebersihan & Keamanan</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nominal (Rp)</label>
                    <input type="number" name="amount" placeholder="250000" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Pengeluaran</label>
                    <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Keterangan Tambahan (Opsional)</label>
                    <textarea name="description" rows="2" placeholder="Catatan teknis atau tempat pembelian..." class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('createExpenseModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 rounded-xl">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm">
                        Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.owner>
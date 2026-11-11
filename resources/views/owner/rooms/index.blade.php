<x-layouts.owner>
    <div class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Kamar</h1>
                <p class="text-sm text-slate-500">Kelola unit kamar, tipe fasilitas, harga sewa, dan status ketersediaan.</p>
            </div>
            <button onclick="document.getElementById('createRoomModal').classList.remove('hidden')" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-150">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Kamar Baru
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

        <!-- Tabel Data Kamar -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Daftar Unit Kamar</h2>
                <span class="text-xs text-slate-500">Total: {{ count($rooms) }} Unit</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Nomor & Name Kamar</th>
                            <th class="px-6 py-3.5">Harga Sewa / Bulan</th>
                            <th class="px-6 py-3.5">Fasilitas / Deskripsi</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($rooms as $room)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- Nomor Kamar -->
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">Kamar {{ $room->room_number }}</div>
                                    <div class="text-xs text-slate-500">{{ $room->name ?? 'Tipe Standar' }}</div>
                                </td>

                                <!-- Harga Sewa -->
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                </td>

                                <!-- Fasilitas -->
                                <td class="px-6 py-4 text-xs text-slate-600 max-w-xs truncate">
                                    {{ $room->description ?? 'AC, Kamar Mandi Dalam, Kasur Springbed, WiFi' }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @if ($room->status === 'occupied' || (isset($room->is_occupied) && $room->is_occupied))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Terisi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Tersedia
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-6 py-4 text-right space-x-2">
                                    @if (isset($room->currentOccupancy) && $room->currentOccupancy)
                                        <form action="{{ route('owner.occupancies.checkout', $room->currentOccupancy->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi checkout untuk kamar ini?')">
                                            @csrf
                                            <button type="submit" class="text-xs font-medium text-amber-600 hover:text-amber-800 transition-colors">
                                                Checkout
                                            </button>
                                        </form>
                                    @elseif ($room->status === 'available' || !isset($room->is_occupied) || !$room->is_occupied)
                                        <!-- Perbaikan nama rute di baris ini -->
                                        <form action="{{ route('owner.rooms.destroy', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-rose-600 hover:text-rose-800 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-[48px] text-slate-300">meeting_room</span>
                                        <p class="text-sm font-medium">Belum ada unit kamar yang didaftarkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kamar Baru -->
    <div id="createRoomModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-lg">Tambah Kamar Baru</h3>
                <button onclick="document.getElementById('createRoomModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('owner.rooms.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Kamar</label>
                    <input type="text" name="room_number" placeholder="Contoh: 101, A-02" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Tipe Kamar (Opsional)</label>
                    <input type="text" name="name" placeholder="Contoh: Deluxe AC / VIP Balkon" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga Sewa Bulanan (Rp)</label>
                    <input type="number" name="price" placeholder="1500000" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Fasilitas / Deskripsi Kamar</label>
                    <textarea name="description" rows="3" placeholder="AC 1 PK, Kasur Springbed 160x200, KM Dalam, Water Heater, Meja Belajar..." class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <!-- Modal Actions -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('createRoomModal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800 rounded-xl">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm">
                        Simpan Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.owner>
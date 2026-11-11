<x-layouts.owner>
    <div class="p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Persetujuan Booking Kamar</h1>
            <p class="text-sm text-slate-500">Konfirmasi pengajuan booking dari calon penyewa kos.</p>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 border-b border-slate-100 font-semibold text-slate-800 text-sm">
                Daftar Pengajuan Menunggu Konfirmasi
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-100">
                            <th class="px-6 py-3.5">Penyewa</th>
                            <th class="px-6 py-3.5">Kamar</th>
                            <th class="px-6 py-3.5">Tanggal Pengajuan</th>
                            <th class="px-6 py-3.5 text-right">Aksi Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($pendingBookings as $booking)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900">{{ $booking->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-500">{{ $booking->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-indigo-600">
                                    Kamar {{ $booking->room->room_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <form action="{{ route('owner.bookings.approve', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Setujui booking ini?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-all">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('owner.bookings.reject', $booking->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tolak booking ini?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg transition-all">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-xs">
                                    Belum ada pengajuan booking kamar baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.owner>
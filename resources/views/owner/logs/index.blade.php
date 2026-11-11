<x-layouts.owner>
    <div class="p-6 space-y-6">
        <!-- Header & Filter Section -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Audit Trail Log</h1>
                <p class="text-sm text-slate-500">Catatan riwayat aktivitas dan jejak audit pengguna di sistem.</p>
            </div>

            <!-- Form Filter Pencarian & Tanggal -->
            <form action="{{ route('owner.logs.index') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas / nama..." class="px-3 py-1.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500">
                <input type="date" name="date" value="{{ request('date') }}" class="px-3 py-1.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500">
                <button type="submit" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-colors">
                    Cari
                </button>
                @if(request('search') || request('date'))
                    <a href="{{ route('owner.logs.index') }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Logs -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-sm">Riwayat Aktivitas Sistem</h2>
                <span class="text-xs text-slate-400">Total: {{ $logs->total() }} Log</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[11px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-3.5">Waktu</th>
                            <th class="px-6 py-3.5">Pengguna</th>
                            <th class="px-6 py-3.5">Aktivitas / Aksi</th>
                            <th class="px-6 py-3.5">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($logs as $log)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-semibold text-slate-800">{{ $log->user->name ?? 'Sistem' }}</div>
                                    <div class="text-xs text-slate-400">{{ $log->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-lg border border-indigo-100">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $log->ip_address ?? '127.0.0.1' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs">
                                    Belum ada catatan log aktivitas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.owner>
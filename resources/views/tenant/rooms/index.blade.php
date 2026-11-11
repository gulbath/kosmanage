<x-layouts.tenant>
    <div class="p-6 space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Pilih & Pesan Kamar Kos</h1>
            <p class="text-sm text-slate-500">Pilih unit kamar yang sesuai dengan kebutuhan Anda.</p>
        </div>

        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($rooms as $room)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-xl font-bold text-slate-900">Kamar {{ $room->room_number }}</h3>
                            <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">Tersedia</span>
                        </div>
                        <p class="text-xs text-indigo-600 font-semibold mb-3">{{ $room->name ?? 'Tipe Standar' }}</p>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $room->description ?? 'AC, KM Dalam, Kasur Springbed' }}</p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 block uppercase font-bold">Harga Sewa</span>
                            <span class="text-lg font-bold text-slate-900">Rp {{ number_format($room->price, 0, ',', '.') }}</span><span class="text-xs text-slate-500">/bln</span>
                        </div>
                        <form action="{{ route('tenant.rooms.book', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memesan Kamar {{ $room->room_number }}?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition-all shadow-sm">
                                Pesan Kamar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200 text-slate-400">
                    <span class="material-symbols-outlined text-[48px] mb-2">meeting_room</span>
                    <p class="text-sm font-medium">Saat ini belum ada kamar yang tersedia untuk dipesan.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.tenant>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KosManage - Manajemen Penghuni Kos</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                "primary": "#005c55",
                "primary-container": "#0f766e",
                "on-primary": "#ffffff",
                "secondary": "#006399",
                "surface": "#f8f9ff",
                "surface-container-low": "#eff4ff",
                "surface-container-lowest": "#ffffff",
                "on-surface": "#0b1c30",
                "on-surface-variant": "#3e4947",
                "outline": "#6e7977",
                "outline-variant": "#bdc9c6",
                "background": "#f8f9ff",
                "tertiary": "#005c54",
                "error": "#ba1a1a"
              },
              "borderRadius": {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
              },
              "spacing": {
                "margin-sm": "1rem",
                "gutter-sm": "1rem",
                "space-lg": "1.5rem",
                "space-md": "1rem",
                "space-xl": "2rem",
                "space-xs": "0.25rem",
                "space-sm": "0.5rem",
                "margin": "2rem",
                "gutter": "1.5rem"
              },
              "fontFamily": {
                "headline-lg-mobile": ["Plus Jakarta Sans"],
                "body-lg": ["Inter"],
                "headline-xl": ["Plus Jakarta Sans"],
                "label-sm": ["Inter"],
                "body-sm": ["Inter"],
                "title-md": ["Plus Jakarta Sans"],
                "body-md": ["Inter"],
                "headline-xl-mobile": ["Plus Jakarta Sans"],
                "label-lg": ["Inter"],
                "headline-md": ["Plus Jakarta Sans"],
                "label-md": ["Inter"],
                "headline-lg": ["Plus Jakarta Sans"]
              },
              "fontSize": {
                "body-md": ["0.875rem", { "lineHeight": "1.25rem", "fontWeight": "400" }],
                "headline-lg-mobile": ["1.5rem", { "lineHeight": "2rem", "letterSpacing": "-0.015em", "fontWeight": "700" }],
                "label-lg": ["0.875rem", { "lineHeight": "1.25rem", "letterSpacing": "0.01em", "fontWeight": "600" }],
                "body-lg": ["1.125rem", { "lineHeight": "1.75rem", "fontWeight": "400" }],
                "headline-lg": ["1.875rem", { "lineHeight": "2.25rem", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                "headline-md": ["1.25rem", { "lineHeight": "1.75rem", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                "label-md": ["0.75rem", { "lineHeight": "1rem", "letterSpacing": "0.025em", "fontWeight": "600" }],
                "label-sm": ["0.6875rem", { "lineHeight": "0.875rem", "letterSpacing": "0.05em", "fontWeight": "500" }],
                "headline-xl": ["2.25rem", { "lineHeight": "2.75rem", "letterSpacing": "-0.025em", "fontWeight": "700" }],
                "body-sm": ["0.75rem", { "lineHeight": "1rem", "fontWeight": "400" }],
                "headline-xl-mobile": ["1.75rem", { "lineHeight": "2.25rem", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                "title-md": ["1rem", { "lineHeight": "1.5rem", "letterSpacing": "0em", "fontWeight": "600" }]
              }
            }
          }
        }
    </script>
    <style>
        .material-symbols-outlined {
          font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
          display: inline-block;
          vertical-align: middle;
          line-height: 1;
        }
        .custom-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md antialiased min-h-screen flex flex-col">

<!-- Flash Alert Notification -->
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="flashAlert">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="font-label-md text-label-md">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="fixed top-4 right-4 z-50 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="flashAlert">
        <span class="material-symbols-outlined">error</span>
        <span class="font-label-md text-label-md">{{ $errors->first() }}</span>
    </div>
@endif

<div class="flex min-h-screen w-full">
    
    <!-- 1. SIDEBAR KONSISTEN VIA INCLUDE -->
    @include('includes.sidebar-owner')

    <!-- 2. MAIN VIEWPORT -->
    <div class="flex-1 flex flex-col overflow-hidden bg-background">
        
        <!-- Header TopBar -->
        <header class="bg-surface-container-lowest border-b border-outline-variant px-6 py-3 flex items-center justify-between z-10 sticky top-0">
            <div class="flex items-center gap-2">
                <span class="text-label-lg text-on-surface-variant">Beranda</span>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                <span class="text-label-lg font-semibold text-primary">Manajemen Penghuni</span>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="openAddModal()" class="bg-primary hover:bg-tertiary text-on-primary font-label-md py-1.5 px-3 rounded-xl flex items-center gap-1.5 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">person_add</span>
                    <span>+ Penyewa Baru</span>
                </button>
                <div class="h-6 w-[1px] bg-outline-variant"></div>
                <div class="flex items-center gap-2 pl-2">
                    <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <span class="text-label-md font-semibold text-on-surface hidden md:block">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 custom-scroll space-y-6">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-headline-lg font-bold text-on-surface tracking-tight">Daftar Penghuni Kos</h1>
                    <p class="text-body-md text-on-surface-variant mt-1">Kelola data penyewa, kontak darurat, serta alokasi kamar kos aktif.</p>
                </div>
                <button onclick="openAddModal()" class="bg-primary hover:bg-tertiary text-on-primary font-label-lg py-2.5 px-4 rounded-xl flex items-center gap-2 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    <span>+ Tambah Penghuni Baru</span>
                </button>
            </div>

            <!-- Toolbar & Search -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
                <form action="{{ route('owner.tenants.index') }}" method="GET" class="relative w-full sm:w-80">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                    <input name="search" value="{{ request('search') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl pl-9 pr-3 py-2 text-body-md text-on-surface placeholder:text-outline focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" placeholder="Cari nama, No. HP, atau KTP..." type="text"/>
                </form>

                <div class="text-body-sm text-on-surface-variant">
                    Total Penghuni: <span class="font-bold text-on-surface">{{ $tenants->total() }} Orang</span>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto custom-scroll">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant/70 text-on-surface-variant text-label-md tracking-wider">
                                <th class="py-3.5 px-4 font-semibold">NAMA PENGHUNI</th>
                                <th class="py-3.5 px-4 font-semibold">KAMAR & PERIODE</th>
                                <th class="py-3.5 px-4 font-semibold">NO. WHATSAPP</th>
                                <th class="py-3.5 px-4 font-semibold">KONTAK DARURAT</th>
                                <th class="py-3.5 px-4 font-semibold text-center">STATUS SEWA</th>
                                <th class="py-3.5 px-4 font-semibold text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/40 text-body-md">
                            @forelse($tenants as $tenant)
                                @php
                                    $activeOcc = $tenant->occupancies->where('is_active', true)->first();
                                @endphp
                                <tr class="hover:bg-surface-container-low/40 transition-colors">
                                    <!-- Nama Penghuni -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-primary-container text-on-primary flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($tenant->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="font-bold text-on-surface block leading-tight">{{ $tenant->name }}</span>
                                                <span class="text-body-sm text-outline">NIK: {{ $tenant->identity_card ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kamar & Periode -->
                                    <td class="py-3.5 px-4">
                                        @if($activeOcc && $activeOcc->room)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded font-mono text-label-sm bg-surface-container text-primary font-bold border border-outline-variant/60">
                                                Kamar {{ $activeOcc->room->room_number }}
                                            </span>
                                            <p class="text-body-sm text-outline mt-0.5">Tgl Jatuh Tempo: Setiap Tgl {{ $activeOcc->due_date_day }}</p>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-label-sm bg-slate-100 text-slate-600 font-medium">
                                                Tidak Ada Kamar
                                            </span>
                                        @endif
                                    </td>

                                    <!-- No WhatsApp -->
                                    <td class="py-3.5 px-4 font-medium">
                                        <div class="flex items-center gap-2">
                                            <span>{{ $tenant->phone }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tenant->phone) }}" target="_blank" class="p-1 rounded text-emerald-600 hover:bg-emerald-50 transition-colors" title="Kirim WhatsApp">
                                                <span class="material-symbols-outlined text-[18px]">chat</span>
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Kontak Darurat -->
                                    <td class="py-3.5 px-4 text-on-surface-variant">
                                        {{ $tenant->emergency_contact ?? '-' }}
                                    </td>

                                    <!-- Status Sewa -->
                                    <td class="py-3.5 px-4 text-center">
                                        @if($activeOcc)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-label-sm bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-label-sm bg-slate-100 text-slate-700 border border-slate-300 font-semibold">
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Buttons -->
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- Tombol Edit -->
                                            <button onclick="openEditModal({{ json_encode($tenant) }})" class="p-1.5 rounded-lg text-secondary hover:bg-surface-container transition-colors" title="Edit Data">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </button>

                                            <!-- Tombol Check-Out (jika ada kamar aktif) -->
                                            @if($activeOcc)
                                                <form action="{{ route('owner.tenants.checkout', $activeOcc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melakukan check-out penghuni ini? Kamar akan otomatis menjadi kosong.')">
                                                    @csrf
                                                    <button type="submit" class="p-1.5 rounded-lg text-amber-700 hover:bg-amber-50 transition-colors" title="Check-Out Kamar">
                                                        <span class="material-symbols-outlined text-[18px]">logout</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('owner.tenants.destroy', $tenant->id) }}" method="POST" onsubmit="return confirm('Hapus data penyewa ini dari sistem?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg text-error hover:bg-red-50 transition-colors" title="Hapus Penyewa">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-outline text-body-sm">
                                        Belum ada data penyewa terdaftar. Klik "+ Tambah Penghuni Baru" untuk menambah data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Bottom Bar -->
                <div class="px-6 py-4 bg-surface-container-lowest border-t border-outline-variant/60">
                    {{ $tenants->links() }}
                </div>
            </div>

        </main>
    </div>
</div>

<!-- MODAL TAMBAH PENYEWA BARU + ASSIGN KAMAR -->
<div class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm flex items-center justify-center p-4 hidden" id="addTenantModal">
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant w-full max-w-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-low">
            <h3 class="text-headline-md font-bold text-on-surface">Tambah Penghuni & Masuk Kamar</h3>
            <button onclick="closeAddModal()" class="text-outline hover:text-on-surface p-1 rounded-lg">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form action="{{ route('owner.tenants.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-label-md font-semibold text-on-surface mb-1">Nama Lengkap Penghuni <span class="text-error">*</span></label>
                <input name="name" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" placeholder="Contoh: Budi Pratama" required type="text"/>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">No. WhatsApp <span class="text-error">*</span></label>
                    <input name="phone" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" placeholder="081234567890" required type="tel"/>
                </div>

                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Kontak Darurat</label>
                    <input name="emergency_contact" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" placeholder="08987654321 (Orang Tua)" type="tel"/>
                </div>
            </div>

            <div>
                <label class="block text-label-md font-semibold text-on-surface mb-1">Nomor Identitas (KTP/SIM)</label>
                <input name="identity_card" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" placeholder="3171234567890001" type="text"/>
            </div>

            <div class="border-t border-outline-variant/60 pt-3">
                <label class="block text-label-md font-semibold text-primary mb-1">Pilih Kamar Kosong <span class="text-error">*</span></label>
                <select name="room_id" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required>
                    <option value="">-- Pilih Kamar Kosong --</option>
                    @foreach($availableRooms as $room)
                        <option value="{{ $room->id }}">
                            Kamar {{ $room->room_number }} - {{ $room->room_type }} (Rp {{ number_format($room->price, 0, ',', '.') }}/bln)
                        </option>
                    @endforeach
                </select>
                @if($availableRooms->isEmpty())
                    <p class="text-xs text-error mt-1">* Tidak ada kamar kosong saat ini. Tambahkan kamar baru terlebih dahulu.</p>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Tanggal Mulai Masuk <span class="text-error">*</span></label>
                    <input name="start_date" value="{{ date('Y-m-d') }}" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required type="date"/>
                </div>

                <div>
                    <label class="block text-label-md font-semibold text-on-surface mb-1">Tanggal Jatuh Tempo Bulanan <span class="text-error">*</span></label>
                    <input name="due_date_day" value="5" min="1" max="31" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" placeholder="Contoh: 5 (Tgl 5 tiap bulan)" required type="number"/>
                </div>
            </div>

            <div class="pt-4 border-t border-outline-variant flex items-center justify-end gap-3">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-xl border border-outline-variant text-on-surface hover:bg-surface-container-low transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-tertiary text-on-primary font-bold shadow-sm transition-colors">Simpan & Check-In</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PENYEWA -->
<div class="fixed inset-0 z-50 bg-inverse-surface/40 backdrop-blur-sm flex items-center justify-center p-4 hidden" id="editTenantModal">
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant w-full max-w-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-low">
            <h3 class="text-headline-md font-bold text-on-surface">Edit Data Penghuni</h3>
            <button onclick="closeEditModal()" class="text-outline hover:text-on-surface p-1 rounded-lg">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form id="editTenantForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-label-md font-semibold text-on-surface mb-1">Nama Lengkap <span class="text-error">*</span></label>
                <input name="name" id="edit_name" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required type="text"/>
            </div>

            <div>
                <label class="block text-label-md font-semibold text-on-surface mb-1">No. WhatsApp <span class="text-error">*</span></label>
                <input name="phone" id="edit_phone" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required type="tel"/>
            </div>

            <div>
                <label class="block text-label-md font-semibold text-on-surface mb-1">Kontak Darurat</label>
                <input name="emergency_contact" id="edit_emergency_contact" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="tel"/>
            </div>

            <div>
                <label class="block text-label-md font-semibold text-on-surface mb-1">Nomor Identitas (NIK)</label>
                <input name="identity_card" id="edit_identity_card" class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl px-3.5 py-2 text-body-md text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" type="text"/>
            </div>

            <div class="pt-4 border-t border-outline-variant flex items-center justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl border border-outline-variant text-on-surface hover:bg-surface-container-low transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-primary hover:bg-tertiary text-on-primary font-bold shadow-sm transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addTenantModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addTenantModal').classList.add('hidden');
    }

    function openEditModal(tenant) {
        document.getElementById('editTenantForm').action = '/owner/tenants/' + tenant.id;
        document.getElementById('edit_name').value = tenant.name;
        document.getElementById('edit_phone').value = tenant.phone;
        document.getElementById('edit_emergency_contact').value = tenant.emergency_contact || '';
        document.getElementById('edit_identity_card').value = tenant.identity_card || '';
        document.getElementById('editTenantModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editTenantModal').classList.add('hidden');
    }

    setTimeout(() => {
        const alert = document.getElementById('flashAlert');
        if (alert) alert.remove();
    }, 4000);
</script>
</body>
</html>
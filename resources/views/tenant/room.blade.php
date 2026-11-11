<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kamar Saya - KosManage</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
          theme: {
            extend: {
              colors: { primary: "#005c55", "primary-container": "#0f766e", "on-primary": "#ffffff", secondary: "#006399", background: "#f8f9ff", surface: "#ffffff", "surface-container-low": "#eff4ff", "surface-container-lowest": "#ffffff", outline: "#6e7977", "outline-variant": "#bdc9c6", error: "#ba1a1a", "on-surface": "#0b1c30", "on-surface-variant": "#3e4947" },
              fontFamily: { "body-md": ["Inter"], "headline-md": ["Plus Jakarta Sans"] }
            }
          }
        }
    </script>
</head>
<body class="bg-background text-on-surface font-body-md antialiased flex min-h-screen">

    <!-- Sidebar Include -->
    @include('includes.sidebar-tenant')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-h-screen md:ml-64 w-full">
        <!-- Topbar -->
        <header class="bg-surface border-b border-outline-variant px-8 h-16 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-2 text-sm text-outline">
                <span>Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="font-semibold text-primary">Detail Kamar</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-primary-container text-white flex items-center justify-center font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Canvas -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-on-surface mb-6">Informasi Kamar Saya</h1>
            
            @if($occupancy && $occupancy->room)
                <div class="bg-surface border border-outline-variant rounded-xl p-6 shadow-sm max-w-3xl">
                    <div class="flex justify-between items-start border-b border-outline-variant pb-4 mb-4">
                        <div>
                            <h2 class="text-3xl font-bold text-primary mb-1">Kamar {{ $occupancy->room->room_number }}</h2>
                            <p class="text-on-surface-variant">{{ $occupancy->room->room_type }}</p>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold rounded-lg uppercase tracking-wider">Active</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                            <span class="text-xs text-outline block mb-1">Mulai Sewa</span>
                            <span class="font-semibold text-on-surface">{{ \Carbon\Carbon::parse($occupancy->start_date)->format('d F Y') }}</span>
                        </div>
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                            <span class="text-xs text-outline block mb-1">Tarif Bulanan</span>
                            <span class="font-bold text-primary text-lg">Rp {{ number_format($occupancy->room->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                            <span class="text-xs text-outline block mb-1">Tanggal Tagihan</span>
                            <span class="font-semibold text-on-surface">Setiap tanggal {{ $occupancy->due_date_day }}</span>
                        </div>
                        <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/50">
                            <span class="text-xs text-outline block mb-1">Status Penempatan</span>
                            <span class="font-semibold text-emerald-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span> Aktif
                            </span>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-on-surface mb-2">Fasilitas & Catatan Kamar:</h3>
                        <p class="text-on-surface-variant p-4 bg-gray-50 rounded-xl border border-gray-100 italic">
                            "{{ $occupancy->room->description ?? 'Tidak ada deskripsi tambahan untuk kamar ini.' }}"
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-surface p-8 rounded-xl border border-outline-variant shadow-sm text-center max-w-3xl">
                    <span class="material-symbols-outlined text-4xl text-outline mb-2">bed</span>
                    <h3 class="text-lg font-semibold">Belum Memiliki Kamar</h3>
                    <p class="text-on-surface-variant">Anda saat ini belum dialokasikan ke kamar manapun oleh Pemilik Kos.</p>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
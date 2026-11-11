<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tagihan Saya - KosManage</title>
    <!-- Masukkan style fonts & tailwind script seperti di file room.blade.php di atas -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = { theme: { extend: { colors: { primary: "#005c55", "primary-container": "#0f766e", background: "#f8f9ff", surface: "#ffffff", "surface-container-low": "#eff4ff", outline: "#6e7977", "outline-variant": "#bdc9c6", error: "#ba1a1a", "on-surface": "#0b1c30", "on-surface-variant": "#3e4947" } } } }
    </script>
</head>
<body class="bg-background text-on-surface font-sans antialiased flex min-h-screen">
    @include('includes.sidebar-tenant')

    <div class="flex-1 flex flex-col min-h-screen md:ml-64 w-full">
        <header class="bg-surface border-b border-outline-variant px-8 h-16 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-2 text-sm text-outline">
                <span>Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="font-semibold text-primary">Tagihan Saya</span>
            </div>
        </header>

        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-on-surface mb-6">Daftar Tagihan Sewa</h1>
            
            <div class="grid grid-cols-1 gap-4 max-w-4xl">
                @forelse($bills as $bill)
                    <div class="bg-surface border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-primary/40 transition-colors">
                        <div>
                            <span class="text-xs font-mono px-2 py-1 bg-gray-100 rounded text-outline mb-2 inline-block">INV-{{ $bill->bill_number }}</span>
                            <h3 class="text-lg font-bold text-on-surface">Tagihan Sewa Kamar {{ $bill->occupancy->room->room_number ?? '' }}</h3>
                            <p class="text-sm text-on-surface-variant mt-1">Periode: <span class="font-semibold">{{ $bill->period }}</span></p>
                            <p class="text-sm text-error mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                Jatuh Tempo: {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}
                            </p>
                        </div>
                        
                        <div class="flex flex-col items-end gap-3 w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-outline-variant/30">
                            <div class="text-right">
                                <p class="text-xs text-outline mb-0.5">Total Tagihan</p>
                                <p class="text-2xl font-bold text-primary">Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                            </div>
                            
                            @if($bill->status === 'unpaid')
                                <button class="px-5 py-2 bg-primary hover:bg-primary-container text-white text-sm font-bold rounded-xl shadow-sm transition-all w-full md:w-auto">
                                    Konfirmasi Pembayaran
                                </button>
                            @elseif($bill->status === 'pending')
                                <span class="px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 text-sm font-bold rounded-xl flex items-center gap-1.5 w-full md:w-auto justify-center">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> Verifikasi Owner
                                </span>
                            @else
                                <span class="px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 text-sm font-bold rounded-xl flex items-center gap-1 w-full md:w-auto justify-center">
                                    <span class="material-symbols-outlined text-[18px]">check_circle</span> LUNAS
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 bg-surface border border-outline-variant rounded-xl text-center shadow-sm">
                        <span class="material-symbols-outlined text-4xl text-outline mb-2">receipt_long</span>
                        <p class="font-semibold">Hore! Belum ada tagihan.</p>
                        <p class="text-sm text-on-surface-variant">Anda tidak memiliki tagihan sewa yang belum dibayar.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>
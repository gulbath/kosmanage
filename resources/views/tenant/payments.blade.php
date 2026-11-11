<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Riwayat Transaksi - KosManage</title>
    <!-- Masukkan style fonts & tailwind config sama seperti di atas -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>
<body class="bg-[#f8f9ff] text-[#0b1c30] font-sans antialiased flex min-h-screen">
    @include('includes.sidebar-tenant')

    <div class="flex-1 flex flex-col min-h-screen md:ml-64 w-full">
        <header class="bg-white border-b border-[#bdc9c6] px-8 h-16 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-2 text-sm text-[#6e7977]">
                <span>Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="font-semibold text-[#005c55]">Riwayat Transaksi</span>
            </div>
        </header>

        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Riwayat Pembayaran Anda</h1>
            
            <div class="bg-white border border-[#bdc9c6] rounded-xl overflow-hidden shadow-sm max-w-5xl">
                <table class="w-full text-left">
                    <thead class="bg-[#eff4ff] border-b border-[#bdc9c6] text-sm text-[#3e4947]">
                        <tr>
                            <th class="py-3.5 px-5 font-semibold">TGL. PEMBAYARAN</th>
                            <th class="py-3.5 px-5 font-semibold">PERIODE TAGIHAN</th>
                            <th class="py-3.5 px-5 font-semibold">METODE</th>
                            <th class="py-3.5 px-5 font-semibold text-right">NOMINAL BAYAR</th>
                            <th class="py-3.5 px-5 font-semibold text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#bdc9c6]/50 text-sm">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-5 font-medium">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</td>
                                <td class="py-4 px-5 font-mono text-[#005c55] font-semibold">{{ $payment->bill->period ?? '-' }}</td>
                                <td class="py-4 px-5">{{ $payment->method }}</td>
                                <td class="py-4 px-5 text-right font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="py-4 px-5 text-center">
                                    @if($payment->status === 'approved')
                                        <span class="px-2.5 py-1 rounded bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">BERHASIL</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="px-2.5 py-1 rounded bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">PROSES</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded bg-red-100 text-red-800 text-xs font-bold border border-red-200">GAGAL</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-[#6e7977]">Belum ada riwayat transaksi pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - KosManage Owner</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar Owner -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex shrink-0">
            <div>
                <div class="h-16 flex items-center px-6 border-b border-slate-800">
                    <span class="text-xl font-bold text-white tracking-wide">Kos<span class="text-indigo-500">Manage</span></span>
                </div>
                <nav class="mt-6 px-4 space-y-1">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('owner.rooms.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.rooms.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Manajemen Kamar
                    </a>
                    <a href="{{ route('owner.bills.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.bills.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Tagihan
                    </a>
                    <a href="{{ route('owner.payments.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.payments.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Verifikasi Pembayaran
                    </a>
                    <a href="{{ route('owner.expenses.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.expenses.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Pengeluaran
                    </a>
                    <a href="{{ route('owner.reports.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.reports.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Laporan Keuangan
                    </a>
                    <a href="{{ route('owner.logs.index') }}" class="flex items-center px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('owner.logs.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white' }}">
                        Audit Trail Log
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-lg text-sm font-medium text-rose-400 hover:bg-rose-950/30 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6">
                <h1 class="text-lg font-semibold text-slate-800">{{ $header ?? 'Owner Portal' }}</h1>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-slate-600">{{ Auth::user()->name }}</span>
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 uppercase">Owner</span>
                </div>
            </header>
            <main class="flex-1 p-6 overflow-y-auto">
                @include('components.flash')
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
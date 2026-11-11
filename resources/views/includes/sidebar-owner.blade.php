<aside class="w-64 bg-slate-900 min-h-screen flex flex-col justify-between py-6 px-4 border-r border-slate-800 shrink-0">
    <!-- Top Section: Logo & Navigation -->
    <div class="space-y-6">
        <!-- Logo Brand KosManage -->
        <div class="px-3 py-2">
            <a href="{{ route('owner.dashboard') }}" class="text-xl font-bold tracking-tight text-white flex items-center gap-1">
                <span>Kos</span><span class="text-indigo-500">Manage</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1.5">
            <!-- Dashboard -->
            <a href="{{ route('owner.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Dashboard</span>
            </a>

            <!-- Manajemen Kamar -->
            <a href="{{ route('owner.rooms.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.rooms.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Manajemen Kamar</span>
            </a>

            <!-- Persetujuan Booking -->
            <a href="{{ route('owner.bookings.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.bookings.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Persetujuan Booking</span>
            </a>

            <!-- Tagihan -->
            <a href="{{ route('owner.bills.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.bills.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Tagihan</span>
            </a>

            <!-- Verifikasi Pembayaran -->
            <a href="{{ route('owner.payments.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.payments.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Verifikasi Pembayaran</span>
            </a>

            <!-- Pengeluaran -->
            <a href="{{ route('owner.expenses.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.expenses.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Pengeluaran</span>
            </a>

            <!-- Laporan Keuangan -->
            <a href="{{ route('owner.reports.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.reports.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Laporan Keuangan</span>
            </a>

            <!-- Audit Trail Log -->
            <a href="{{ route('owner.logs.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('owner.logs.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Audit Trail Log</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section: Keluar / Logout (Identik Persis Dengan Tenant) -->
    <div class="pt-4 border-t border-slate-800/80 px-1">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl font-semibold text-sm text-rose-400 bg-rose-500/10 hover:bg-rose-600 hover:text-white border border-rose-500/20 transition-all duration-150">
                <span>Keluar</span>
                <span class="material-symbols-outlined text-[18px]">logout</span>
            </button>
        </form>
    </div>
</aside>
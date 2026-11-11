<aside class="w-64 bg-slate-900 min-h-screen flex flex-col justify-between py-6 px-4 border-r border-slate-800 shrink-0">
    <!-- Top Section: Logo & Navigation -->
    <div class="space-y-6">
        <!-- Logo Brand KosManage -->
        <div class="px-3 py-2">
            <a href="{{ route('tenant.dashboard') }}" class="text-xl font-bold tracking-tight text-white flex items-center gap-1">
                <span>Kos</span><span class="text-indigo-500">Manage</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1.5">
            <!-- Dashboard -->
            <a href="{{ route('tenant.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('tenant.dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Dashboard</span>
            </a>

            <!-- Pesan Kamar -->
            <a href="{{ route('tenant.rooms.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('tenant.rooms.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Pesan Kamar</span>
            </a>

            <!-- Tagihan Saya -->
            <a href="{{ route('tenant.bills.index') }}" 
               class="flex items-center px-4 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('tenant.bills.*') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-300 hover:text-white hover:bg-slate-800/60' }}">
                <span>Tagihan Saya</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section: Keluar / Logout -->
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
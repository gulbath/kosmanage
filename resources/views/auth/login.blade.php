<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun - KosManage</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex flex-col min-h-screen">

    <!-- Top Navigation Header -->
    <header class="w-full bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2 font-bold text-xl text-slate-900 tracking-tight">
                <span class="p-2 bg-indigo-600 text-white rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]">apartment</span>
                </span>
                Kos<span class="text-indigo-600">Manage</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-slate-600">
                <a href="#" class="hover:text-indigo-600 transition-colors">Bantuan</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Tentang Sistem</a>
                <a href="#" class="hover:text-indigo-600 transition-colors">Hubungi Pengelola</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">Masuk</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">Daftar Akun</a>
            </div>
        </div>
    </header>

    <!-- Main Section -->
    <main class="flex-1 flex flex-col lg:flex-row max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8 gap-8 items-stretch">
        
        <!-- Left Panel: Login Form -->
        <div class="w-full lg:w-1/2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 flex flex-col justify-center">
            
            <div class="max-w-md w-full mx-auto space-y-6">
                <!-- Role Selector Tabs -->
                <div class="bg-slate-100 p-1 rounded-2xl flex items-center gap-1 border border-slate-200">
                    <button type="button" id="tab-owner" onclick="setRole('owner')" 
                            class="flex-1 py-2.5 px-4 text-xs font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 bg-white text-slate-800 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">real_estate_agent</span>
                        Pemilik Kos
                    </button>
                    <button type="button" id="tab-tenant" onclick="setRole('tenant')" 
                            class="flex-1 py-2.5 px-4 text-xs font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        Penyewa
                    </button>
                </div>

                <!-- Form Title -->
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Masuk ke Akun Anda</h1>
                    <p class="text-xs text-slate-500 mt-1">Kelola unit kos, tagihan sewa otomatis, dan pembayaran dengan lebih aman dan mudah.</p>
                </div>

                <!-- Error Flash Alert -->
                @if ($errors->any() || session('error'))
                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-700 space-y-1">
                        <div class="flex items-center gap-2 font-semibold">
                            <span class="material-symbols-outlined text-rose-600 text-[18px]">error</span>
                            <span>Gagal Masuk:</span>
                        </div>
                        <p class="pl-6">
                            {{ session('error') ?? $errors->first() ?? 'Kredensial yang dimasukkan tidak cocok dengan catatan kami.' }}
                        </p>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role_type" id="role_type" value="owner">

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                            <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Lupa Kata Sandi?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </span>
                            <input type="password" name="password" id="password" required
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-10 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <span class="material-symbols-outlined text-[20px]" id="eye-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="text-xs text-slate-600 font-medium">Ingat saya selama 30 hari</span>
                        </label>
                        <span class="text-[10px] text-slate-400 bg-slate-100 px-2 py-0.5 rounded font-mono">SSL SECURE</span>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-all duration-150 flex items-center justify-center gap-2 group">
                        Masuk
                        <span class="material-symbols-outlined text-[18px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                    </button>
                </form>

                <div class="text-center pt-2">
                    <p class="text-xs text-slate-500">
                        Belum punya akun pengelola? 
                        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Panel: Hero & Testimonial Card -->
        <div class="hidden lg:flex w-1/2 bg-slate-900 rounded-3xl relative overflow-hidden flex-col justify-between p-10 text-white border border-slate-800 shadow-xl">
            <!-- Background Image Overlay -->
            <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-luminosity" style="background-image: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1200&auto=format&fit=crop');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-transparent"></div>

            <!-- Top Badges -->
            <div class="relative z-10 flex items-center justify-between">
                <span class="px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-medium rounded-full">
                    Tipe Kamar Executive • Griya Asri
                </span>
                <span class="px-3 py-1 bg-emerald-500/20 backdrop-blur-md border border-emerald-500/30 text-emerald-300 text-xs font-medium rounded-full flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Enkripsi Bank Grade Security
                </span>
            </div>

            <!-- Bottom Testimonial Card -->
            <div class="relative z-10 space-y-4 max-w-lg">
                <div class="bg-white/95 backdrop-blur-md p-6 rounded-2xl text-slate-800 shadow-2xl border border-white">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-1 text-amber-500 text-xs font-bold">
                            ★★★★★ <span class="text-slate-600 font-semibold ml-1">5.0 / 5.0</span>
                        </div>
                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">Verified Owner</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        "KosManage menghemat 15+ jam setiap bulan dalam rekapitulasi pembayaran sewa 48 kamar kami. Tidak ada lagi bukti transfer palsu atau lupa menagih."
                    </p>
                    <div class="mt-4 flex items-center gap-3 pt-3 border-t border-slate-100">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-xs flex items-center justify-center">BS</div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">Budi Santoso</h4>
                            <p class="text-[10px] text-slate-500">Pemilik Griya Asri Kost • Jakarta Selatan</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="bg-slate-800/80 backdrop-blur-md border border-slate-700 p-3 rounded-xl">
                        <span class="text-indigo-400 font-bold block text-sm">~ 99.8%</span>
                        <span class="text-slate-400 text-[10px]">Pembayaran Tepat Waktu</span>
                    </div>
                    <div class="bg-slate-800/80 backdrop-blur-md border border-slate-700 p-3 rounded-xl">
                        <span class="text-emerald-400 font-bold block text-sm">Otomatisasi Tagihan</span>
                        <span class="text-slate-400 text-[10px]">WhatsApp & QRIS Instan</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-4 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} KosManage. Seluruh hak cipta dilindungi undang-undang.
    </footer>

    <!-- Interactive Scripts -->
    <script>
        function setRole(role) {
            document.getElementById('role_type').value = role;
            const ownerTab = document.getElementById('tab-owner');
            const tenantTab = document.getElementById('tab-tenant');

            if (role === 'owner') {
                ownerTab.className = 'flex-1 py-2.5 px-4 text-xs font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 bg-white text-slate-800 shadow-sm';
                tenantTab.className = 'flex-1 py-2.5 px-4 text-xs font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900';
            } else {
                tenantTab.className = 'flex-1 py-2.5 px-4 text-xs font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 bg-white text-slate-800 shadow-sm';
                ownerTab.className = 'flex-1 py-2.5 px-4 text-xs font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900';
            }
        }

        function togglePassword() {
            const passInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.textContent = 'visibility_off';
            } else {
                passInput.type = 'password';
                eyeIcon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
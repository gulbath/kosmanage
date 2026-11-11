<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>404 Halaman Tidak Ditemukan - KosManage</title>
    
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
                "secondary": "#006399",
                "on-primary": "#ffffff",
                "surface": "#f8f9ff",
                "surface-container-low": "#eff4ff",
                "surface-container-lowest": "#ffffff",
                "on-surface": "#0b1c30",
                "on-surface-variant": "#3e4947",
                "outline": "#6e7977",
                "outline-variant": "#bdc9c6",
                "background": "#f8f9ff"
              },
              "fontFamily": {
                "body-md": ["Inter"],
                "headline-md": ["Plus Jakarta Sans"]
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
    </style>
</head>
<body class="bg-background text-on-surface min-h-screen flex flex-col font-body-md antialiased justify-between">

    <!-- Top Navigation Header -->
    <header class="bg-surface border-b border-outline-variant shadow-sm z-50 sticky top-0">
        <div class="flex justify-between items-center w-full px-6 py-3 max-w-7xl mx-auto">
            <a class="text-headline-md font-headline-md font-bold text-primary tracking-tight flex items-center gap-2" href="{{ url('/') }}">
                <span class="w-8 h-8 rounded-xl bg-primary-container text-on-primary flex items-center justify-center font-bold shadow-sm">K</span>
                <span>KosManage</span>
            </a>
            @auth
                <a href="{{ Auth::user()->role === 'owner' ? route('owner.dashboard') : route('tenant.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-semibold transition-all text-sm">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    <span>Kembali ke Beranda</span>
                </a>
            @else
    <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-primary hover:bg-primary-container text-on-primary font-semibold transition-all text-sm">
        <span>Masuk ke Akun</span>
    </a>
@endauth
        </div>
    </header>

    <!-- Main Content Panel 404 -->
    <main class="flex-1 flex items-center justify-center p-6 my-8">
        <div class="bg-surface-container-lowest border-2 border-primary/30 rounded-2xl p-6 sm:p-8 max-w-lg w-full shadow-md text-center relative">
            
            <div class="flex items-center justify-between mb-6">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-container-low border border-secondary/30 text-secondary text-xs font-semibold">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                    HTTP 404 • Tidak Ditemukan
                </span>
                <span class="text-xs font-mono text-outline">ERR_ROUTE_MISSING</span>
            </div>

            <!-- Search Illustration Icon -->
            <div class="flex justify-center items-center py-4 mb-2">
                <div class="relative flex items-center justify-center">
                    <div class="w-24 h-24 rounded-full bg-teal-100/60 blur-xl absolute inset-0 m-auto"></div>
                    <div class="w-20 h-20 rounded-2xl bg-surface-container-low border border-primary/20 flex items-center justify-center relative shadow-inner">
                        <span class="material-symbols-outlined text-[40px] text-primary" style="font-variation-settings: 'FILL' 1;">search</span>
                        <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-lg bg-primary-container text-on-primary flex items-center justify-center shadow">
                            <span class="material-symbols-outlined text-[16px]">find_in_page</span>
                        </span>
                    </div>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-on-surface">404 - Halaman Tidak Ditemukan</h1>
            <p class="text-sm text-on-surface-variant mt-2.5 leading-relaxed">
                Halaman yang Anda cari mungkin telah dipindahkan, tautannya telah kedaluwarsa, atau alamat URL yang Anda masukkan tidak valid.
            </p>

            <div class="pt-6 border-t border-outline-variant/50 flex flex-col gap-3 mt-6">
                @auth
                    <a href="{{ Auth::user()->role === 'owner' ? route('owner.dashboard') : route('tenant.dashboard') }}" class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-sm font-semibold transition-all shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">home</span>
                        <span>Kembali ke Beranda Utama</span>
                    </a>
                @else
                    <a href="{{ url('/') }}" class="w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-sm font-semibold transition-all shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">home</span>
                        <span>Kembali ke Beranda</span>
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-low border-t border-outline-variant py-4 px-6 text-center text-xs text-on-surface-variant">
        © {{ date('Y') }} KosManage Platform. Hak Cipta Dilindungi Undang-Undang.
    </footer>
</body>
</html>
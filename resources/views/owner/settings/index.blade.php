<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KosManage - Pengaturan Akun & Profil</title>
    
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
                "tertiary-fixed-dim": "#6bd8cb",
                "on-tertiary-container": "#91fdef",
                "on-primary-fixed": "#00201d",
                "on-tertiary-fixed": "#00201d",
                "outline": "#6e7977",
                "outline-variant": "#bdc9c6",
                "tertiary-container": "#00776d",
                "on-tertiary": "#ffffff",
                "surface-container-high": "#dce9ff",
                "surface-dim": "#cbdbf5",
                "inverse-surface": "#213145",
                "on-secondary": "#ffffff",
                "background": "#f8f9ff",
                "on-secondary-container": "#004f7b",
                "on-secondary-fixed": "#001d32",
                "secondary-fixed-dim": "#94ccff",
                "surface-tint": "#006a63",
                "surface-container-low": "#eff4ff",
                "surface-bright": "#f8f9ff",
                "on-error": "#ffffff",
                "on-surface-variant": "#3e4947",
                "tertiary": "#005c54",
                "tertiary-fixed": "#89f5e7",
                "on-tertiary-fixed-variant": "#005049",
                "surface": "#f8f9ff",
                "error-container": "#ffdad6",
                "secondary": "#006399",
                "on-secondary-fixed-variant": "#004b74",
                "surface-variant": "#d3e4fe",
                "surface-container": "#e5eeff",
                "primary": "#005c55",
                "on-primary-fixed-variant": "#00504a",
                "primary-fixed": "#9cf2e8",
                "inverse-on-surface": "#eaf1ff",
                "error": "#ba1a1a",
                "on-primary-container": "#a3faef",
                "secondary-fixed": "#cde5ff",
                "on-surface": "#0b1c30",
                "secondary-container": "#7bc2ff",
                "surface-container-highest": "#d3e4fe",
                "inverse-primary": "#80d5cb",
                "on-error-container": "#93000a",
                "primary-container": "#0f766e",
                "primary-fixed-dim": "#80d5cb",
                "on-background": "#0b1c30",
                "on-primary": "#ffffff",
                "surface-container-lowest": "#ffffff"
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
        .custom-shadow-card {
          box-shadow: 0px 1px 3px rgba(15, 23, 42, 0.04), 0px 4px 12px rgba(15, 23, 42, 0.03);
        }
        .custom-scroll::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md text-body-md antialiased min-h-screen flex flex-col">

<!-- Flash Alert Notification -->
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="flashAlert">
        <span class="material-symbols-outlined">check_circle</span>
        <span class="font-label-md text-label-md">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="fixed top-4 right-4 z-50 bg-rose-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="flashAlert">
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
                <a class="text-label-lg font-label-lg text-on-surface-variant hover:text-primary transition-colors" href="{{ route('owner.dashboard') }}">Beranda</a>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                <span class="text-label-lg font-label-lg font-semibold text-primary">Pengaturan Akun</span>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 pl-2">
                    @if($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover"/>
                    @else
                        <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-bold flex items-center justify-center text-xs">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <span class="text-label-md font-label-md font-semibold text-on-surface hidden md:block">{{ $user->name }}</span>
                </div>
            </div>
        </header>

        <!-- Canvas Body -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 max-w-7xl w-full mx-auto space-y-6 custom-scroll">
            
            <!-- Page Title -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-headline-lg font-headline-lg text-on-surface tracking-tight font-bold">Pengaturan Akun</h1>
                    <p class="text-body-md font-body-md text-on-surface-variant mt-1">
                        Kelola preferensi akun pribadi, informasi kontak, dan keamanan kredensial login Anda.
                    </p>
                </div>
            </div>

            <!-- Profile Summary Card -->
            <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 custom-shadow-card">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
                        <div class="relative shrink-0">
                            @if($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profile" class="w-24 h-24 rounded-full object-cover border-4 border-surface shadow-sm"/>
                            @else
                                <div class="w-24 h-24 rounded-full bg-primary-container text-on-primary font-bold text-3xl flex items-center justify-center border-4 border-surface shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-emerald-500 ring-2 ring-white flex items-center justify-center text-white" title="Status Terverifikasi & Aktif">
                                <span class="material-symbols-outlined text-xs">check</span>
                            </div>
                        </div>
                        
                        <div class="space-y-1.5">
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                                <h2 class="text-headline-md font-headline-md text-on-surface font-bold">{{ $user->name }}</h2>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-label-sm font-label-sm font-semibold bg-tertiary-fixed text-on-tertiary-fixed-variant border border-outline-variant uppercase">
                                    <span class="material-symbols-outlined text-sm">key</span>
                                    {{ $user->role }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-1 gap-x-4 text-body-sm font-body-sm text-on-surface-variant">
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-primary">mail</span>
                                    {{ $user->email }}
                                </span>
                                <span class="hidden sm:inline text-outline-variant">•</span>
                                <span class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-primary">call</span>
                                    {{ $user->phone ?? 'Belum diisi' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Security Score Card Widget -->
                    <div class="w-full lg:w-72 p-4 rounded-xl bg-surface-container-low border border-outline-variant flex flex-col justify-between shrink-0">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-label-md font-label-md text-on-surface flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-primary text-base">shield</span>
                                Skor Keamanan Akun
                            </span>
                            <span class="text-label-lg font-label-lg font-bold text-primary">90% (Sangat Baik)</span>
                        </div>
                        <div class="w-full bg-outline-variant/60 rounded-full h-2 mb-2.5 overflow-hidden">
                            <div class="bg-primary h-full rounded-full w-[90%]"></div>
                        </div>
                        <div class="flex items-center justify-between text-body-sm font-body-sm">
                            <span class="text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-emerald-600 text-sm">check_circle</span>
                                Password Terenkripsi
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Navigasi Tab Bar -->
            <div class="border-b border-outline-variant">
                <nav class="flex space-x-8">
                    <button class="flex items-center gap-2 py-3 px-1 border-b-2 border-primary text-primary font-title-md focus:outline-none transition-colors" id="tabBtnProfil" onclick="switchTab('profil')">
                        <span class="material-symbols-outlined text-lg">person</span>
                        <span>Profil Saya</span>
                    </button>
                    <button class="flex items-center gap-2 py-3 px-1 border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-title-md focus:outline-none transition-colors" id="tabBtnKeamanan" onclick="switchTab('keamanan')">
                        <span class="material-symbols-outlined text-lg">lock</span>
                        <span>Keamanan & Password</span>
                    </button>
                </nav>
            </div>

            <!-- TAB 1: PROFIL SAYA -->
            <div class="space-y-6" id="contentProfil">
                
                <!-- Form Unggah Foto Profil -->
                <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 custom-shadow-card">
                    <h3 class="text-title-md font-title-md text-on-surface mb-1 font-bold">Foto Profil Pengelola</h3>
                    <p class="text-body-sm text-on-surface-variant mb-5">
                        Foto profil ini digunakan sebagai identitas pada sistem KosManage.
                    </p>
                    <form action="{{ route('owner.settings.updateProfile') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        @csrf
                        @if($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto Profile" class="w-20 h-20 rounded-full object-cover border-2 border-outline-variant shadow-sm"/>
                        @else
                            <div class="w-20 h-20 rounded-full bg-primary-container text-on-primary font-bold text-2xl flex items-center justify-center border-2 border-outline-variant shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif

                        <div class="flex-1 space-y-3 text-center sm:text-left">
                            <input type="hidden" name="name" value="{{ $user->name }}"/>
                            <input type="hidden" name="email" value="{{ $user->email }}"/>
                            <input type="hidden" name="phone" value="{{ $user->phone }}"/>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                                <label class="inline-flex items-center gap-2 px-4 py-2 border border-outline-variant bg-surface-container-lowest text-primary hover:bg-surface-container-low rounded-xl text-label-lg font-semibold transition-colors cursor-pointer">
                                    <span class="material-symbols-outlined text-lg">upload</span>
                                    <span>Pilih Foto Baru</span>
                                    <input type="file" name="avatar" class="hidden" onchange="this.form.submit()"/>
                                </label>
                            </div>
                            <p class="text-body-sm text-outline">JPG, PNG atau WebP. Maksimal 2MB.</p>
                        </div>
                    </form>
                </section>

                <!-- Form Data Diri -->
                <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 custom-shadow-card">
                    <div class="border-b border-outline-variant pb-4 mb-6">
                        <h3 class="text-title-md font-bold text-on-surface">Informasi Pribadi & Kontak</h3>
                    </div>
                    
                    <form action="{{ route('owner.settings.updateProfile') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="space-y-1.5">
                                <label class="block text-label-md font-semibold text-on-surface">Nama Lengkap <span class="text-error">*</span></label>
                                <div class="relative">
                                    <input name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 text-body-md py-2.5 px-3.5" required type="text"/>
                                    <span class="material-symbols-outlined absolute right-3 top-2.5 text-outline text-lg">badge</span>
                                </div>
                            </div>

                            <!-- Alamat Email -->
                            <div class="space-y-1.5">
                                <label class="block text-label-md font-semibold text-on-surface">Alamat Email <span class="text-error">*</span></label>
                                <div class="relative">
                                    <input name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 text-body-md py-2.5 px-3.5" required type="email"/>
                                    <span class="material-symbols-outlined absolute right-3 top-2.5 text-outline text-lg">mail</span>
                                </div>
                            </div>

                            <!-- Nomor Telepon / WhatsApp -->
                            <div class="space-y-1.5">
                                <label class="block text-label-md font-semibold text-on-surface">Nomor WhatsApp / HP</label>
                                <div class="relative">
                                    <input name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 text-body-md py-2.5 px-3.5" placeholder="081234567890" type="tel"/>
                                    <span class="material-symbols-outlined absolute right-3 top-2.5 text-outline text-lg">smartphone</span>
                                </div>
                            </div>

                            <!-- Role System -->
                            <div class="space-y-1.5">
                                <label class="block text-label-md font-semibold text-on-surface">Peran Akses</label>
                                <input value="{{ strtoupper($user->role) }}" class="w-full rounded-xl border-outline-variant bg-surface-container-low text-on-surface font-semibold text-body-md py-2.5 px-3.5 cursor-not-allowed" readonly type="text"/>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-outline-variant flex justify-end">
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-tertiary text-on-primary font-label-lg font-bold flex items-center gap-2 shadow-sm transition-colors">
                                <span class="material-symbols-outlined text-lg">check</span>
                                <span>Simpan Perubahan Profil</span>
                            </button>
                        </div>
                    </form>
                </section>

            </div>

            <!-- TAB 2: KEAMANAN & PASSWORD -->
            <div class="space-y-6 hidden" id="contentKeamanan">
                <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 custom-shadow-card space-y-6">
                    <div class="border-b border-outline-variant pb-4">
                        <h3 class="text-title-md font-bold text-on-surface">Perbarui Kata Sandi</h3>
                        <p class="text-body-sm text-on-surface-variant mt-0.5">Pastikan menggunakan kombinasi kata sandi yang aman.</p>
                    </div>

                    <form action="{{ route('owner.settings.updatePassword') }}" method="POST" class="space-y-5 max-w-xl">
                        @csrf
                        <!-- Password Saat Ini -->
                        <div class="space-y-1.5">
                            <label class="block text-label-md font-semibold text-on-surface">Kata Sandi Saat Ini <span class="text-error">*</span></label>
                            <div class="relative">
                                <input name="current_password" id="current_password" class="w-full rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 text-body-md py-2.5 px-3.5 pr-10" required type="password"/>
                                <button type="button" onclick="togglePass('current_password', this)" class="absolute right-3 top-2.5 text-outline hover:text-on-surface">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="space-y-1.5">
                            <label class="block text-label-md font-semibold text-on-surface">Kata Sandi Baru <span class="text-error">*</span></label>
                            <div class="relative">
                                <input name="new_password" id="new_password" class="w-full rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 text-body-md py-2.5 px-3.5 pr-10" required type="password"/>
                                <button type="button" onclick="togglePass('new_password', this)" class="absolute right-3 top-2.5 text-outline hover:text-on-surface">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="space-y-1.5">
                            <label class="block text-label-md font-semibold text-on-surface">Konfirmasi Kata Sandi Baru <span class="text-error">*</span></label>
                            <div class="relative">
                                <input name="new_password_confirmation" id="new_password_confirmation" class="w-full rounded-xl border-outline-variant bg-surface-container-lowest text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 text-body-md py-2.5 px-3.5 pr-10" required type="password"/>
                                <button type="button" onclick="togglePass('new_password_confirmation', this)" class="absolute right-3 top-2.5 text-outline hover:text-on-surface">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-tertiary text-on-primary font-label-lg font-bold flex items-center gap-2 shadow-sm transition-colors">
                                <span class="material-symbols-outlined text-lg">lock_reset</span>
                                <span>Perbarui Password</span>
                            </button>
                        </div>
                    </form>
                </section>
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-surface-container-low border-t border-outline-variant py-space-sm px-space-lg text-xs text-on-surface-variant shrink-0">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
                <div class="flex items-center gap-4">
                    <span class="font-bold text-primary">KosManage</span>
                    <span>© {{ date('Y') }} KosManage Platform. Hak Cipta Dilindungi Undang-Undang.</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
    function switchTab(tabName) {
      const contentProfil = document.getElementById('contentProfil');
      const contentKeamanan = document.getElementById('contentKeamanan');
      const tabBtnProfil = document.getElementById('tabBtnProfil');
      const tabBtnKeamanan = document.getElementById('tabBtnKeamanan');

      [tabBtnProfil, tabBtnKeamanan].forEach(btn => {
        btn.classList.remove('border-primary', 'text-primary');
        btn.classList.add('border-transparent', 'text-on-surface-variant');
      });

      contentProfil.classList.add('hidden');
      contentKeamanan.classList.add('hidden');

      if (tabName === 'profil') {
        contentProfil.classList.remove('hidden');
        tabBtnProfil.classList.add('border-primary', 'text-primary');
        tabBtnProfil.classList.remove('border-transparent', 'text-on-surface-variant');
      } else if (tabName === 'keamanan') {
        contentKeamanan.classList.remove('hidden');
        tabBtnKeamanan.classList.add('border-primary', 'text-primary');
        tabBtnKeamanan.classList.remove('border-transparent', 'text-on-surface-variant');
      }
    }

    function togglePass(inputId, btn) {
      const input = document.getElementById(inputId);
      const icon = btn.querySelector('.material-symbols-outlined');
      if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
      } else {
        input.type = 'password';
        icon.textContent = 'visibility';
      }
    }

    setTimeout(() => {
      const alert = document.getElementById('flashAlert');
      if (alert) alert.remove();
    }, 4000);
</script>
</body>
</html>
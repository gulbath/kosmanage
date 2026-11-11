<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pengaturan Akun - KosManage</title>

    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
          theme: {
            extend: {
              colors: { 
                  primary: "#005c55", "primary-container": "#0f766e", 
                  background: "#f8f9ff", surface: "#ffffff", 
                  "surface-container-low": "#eff4ff", outline: "#6e7977", 
                  "outline-variant": "#bdc9c6", error: "#ba1a1a", 
                  "on-surface": "#0b1c30", "on-surface-variant": "#3e4947" 
              }
            }
          }
        }
    </script>
</head>
<body class="bg-background text-on-surface font-sans antialiased flex min-h-screen">

    <!-- Flash Message Notification (Success & Error) -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="flashMessage">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="fixed top-4 right-4 z-50 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="flashAlert">
            <span class="material-symbols-outlined">error</span>
            <span class="text-sm font-bold">{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Include Sidebar Tenant -->
    @include('includes.sidebar-tenant')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-h-screen md:ml-64 w-full">
        <!-- Topbar -->
        <header class="bg-surface border-b border-outline-variant px-8 h-16 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-2 text-sm text-outline">
                <span>Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="font-semibold text-primary">Pengaturan Akun</span>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- Content Canvas -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold text-on-surface mb-6">Pengaturan Profil & Keamanan</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl">
                
                <!-- KARTU 1: UPDATE PROFIL -->
                <div class="bg-surface border border-outline-variant rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2 pb-2 border-b border-outline-variant/40">
                        <span class="material-symbols-outlined text-primary">person</span>
                        Informasi Profil
                    </h2>

                    <form action="{{ route('tenant.settings.updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Nama Lengkap <span class="text-error">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-surface-container-low/50 border border-outline-variant rounded-xl px-4 py-2 text-sm outline-none focus:border-primary" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Email <span class="text-error">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-surface-container-low/50 border border-outline-variant rounded-xl px-4 py-2 text-sm outline-none focus:border-primary" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Nomor Telepon (WhatsApp)</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-surface-container-low/50 border border-outline-variant rounded-xl px-4 py-2 text-sm outline-none focus:border-primary">
                        </div>

                        <div class="pt-4 text-right">
                            <button type="submit" class="bg-primary hover:bg-primary-container text-white font-bold py-2 px-6 rounded-xl text-sm transition-colors shadow-sm">Simpan Profil</button>
                        </div>
                    </form>
                </div>

                <!-- KARTU 2: UPDATE KATA SANDI -->
                <div class="bg-surface border border-outline-variant rounded-xl p-6 shadow-sm h-fit">
                    <h2 class="text-lg font-bold text-on-surface mb-4 flex items-center gap-2 pb-2 border-b border-outline-variant/40">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        Ubah Kata Sandi
                    </h2>

                    <form action="{{ route('tenant.settings.updatePassword') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Kata Sandi Saat Ini <span class="text-error">*</span></label>
                            <input type="password" name="current_password" class="w-full bg-surface-container-low/50 border border-outline-variant rounded-xl px-4 py-2 text-sm outline-none focus:border-primary" required>
                        </div>
                        
                        <div class="border-t border-outline-variant/40 my-4 pt-4">
                            <label class="block text-sm font-semibold text-on-surface mb-1">Kata Sandi Baru <span class="text-error">*</span></label>
                            <input type="password" name="new_password" class="w-full bg-surface-container-low/50 border border-outline-variant rounded-xl px-4 py-2 text-sm outline-none focus:border-primary" required>
                            <p class="text-xs text-outline mt-1">Minimal 8 karakter</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-on-surface mb-1">Konfirmasi Kata Sandi Baru <span class="text-error">*</span></label>
                            <input type="password" name="new_password_confirmation" class="w-full bg-surface-container-low/50 border border-outline-variant rounded-xl px-4 py-2 text-sm outline-none focus:border-primary" required>
                        </div>

                        <div class="pt-4 text-right">
                            <button type="submit" class="bg-primary hover:bg-primary-container text-white font-bold py-2 px-6 rounded-xl text-sm transition-colors shadow-sm">Perbarui Kata Sandi</button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <!-- Script to Auto-hide Alerts -->
    <script>
        setTimeout(() => {
            const msg = document.getElementById('flashMessage');
            const alert = document.getElementById('flashAlert');
            if (msg) msg.remove();
            if (alert) alert.remove();
        }, 4000);
    </script>
</body>
</html>
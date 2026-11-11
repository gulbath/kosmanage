<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KosManage</title>
    
    <!-- Memanggil Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Memanggil Material Symbols untuk Ikon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900 flex h-screen overflow-hidden">

    <!-- Memanggil Sidebar Secara Dinamis Berdasarkan URL -->
    @if(request()->is('owner*'))
        @include('includes.sidebar-owner')
    @elseif(request()->is('tenant*'))
        @include('includes.sidebar-tenant')
    @endif

    <!-- Area Konten Utama -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header Top Bar (Opsional jika diperlukan) -->
        <header class="bg-white border-b border-slate-100 px-6 py-4 flex justify-between items-center sticky top-0 z-10">
            <div class="font-semibold text-slate-800">
                @if(request()->is('owner*'))
                    Owner Portal
                @else
                    Tenant Portal
                @endif
            </div>
            <div class="text-sm font-medium text-slate-500 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">account_circle</span>
                {{ auth()->user()->name ?? 'Pengguna' }}
            </div>
        </header>

        <!-- Tempat konten spesifik halaman akan dirender -->
        <div>
            @yield('content')
        </div>
    </main>

</body>
</html>
@if (session('success'))
    <div class="mb-6 flex items-center justify-between rounded-lg bg-emerald-50 p-4 text-emerald-800 border border-emerald-200 shadow-sm">
        <div class="flex items-center space-x-3">
            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

@if (session('error') || $errors->any())
    <div class="mb-6 rounded-lg bg-rose-50 p-4 text-rose-800 border border-rose-200 shadow-sm">
        <div class="flex items-center space-x-3 mb-2">
            <svg class="h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-bold">Terjadi Kesalahan:</span>
        </div>
        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
            @if (session('error'))
                <li>{{ session('error') }}</li>
            @endif
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
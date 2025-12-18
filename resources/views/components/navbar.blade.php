{{-- resources/views/components/navbar.blade.php --}}
@php
    $user = Auth::user();
@endphp

<div class="bg-white shadow-sm h-20 flex items-center justify-between px-8 sticky top-0 z-40">

    <!-- Left Side - Page Title -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            @yield('page-title', 'Dashboard')
        </h1>

        <p class="text-sm text-gray-600">
            @yield(
                'page-subtitle',
                'Selamat datang kembali, ' . ($user->nama_lengkap ?? 'User') . '!'
            )
        </p>
    </div>

    <!-- Right Side - User Info -->
    <div class="flex items-center gap-4">
        <div class="text-right leading-tight">
            <p class="font-medium text-gray-800">
                {{ $user->nama_lengkap ?? 'User' }}
            </p>
            <p class="text-xs text-gray-500">
                {{ $user->jabatan ?? '-' }}
            </p>
        </div>

        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold uppercase">
            {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 1)) }}
        </div>
    </div>

</div>
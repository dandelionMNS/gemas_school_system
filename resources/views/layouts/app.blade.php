<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 ">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8 flex gap-3">
                    @if (Auth::check() && Auth::user()->type === 'parent')
                        @if (Auth::user()->address == null ||
                                Auth::user()->phone == null ||
                                Auth::user()->address == null ||
                                Auth::user()->occupation == null)
                            <img src="{{ asset('icons/ic_warning.svg') }}" alt="Warning">
                            <p class="text-red-500">
                                Kemas kini profil akaun anda di bahagian "Sunting Profil" di penjuru kanan atas laman web.
                            </p>
                        @endif
                    @endif
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main style="height: calc(100vh - 138px)">
            <div class="flex max-w-full overflow-x-hidden">
                {{-- Sidebar --}}
                <div class="sidebar text-white">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <h4> {{ __('Laman Utama') }} </h4>
                    </x-nav-link>

                    @if (Auth::check() && Auth::user()->type === 'admin')
                        <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                            <h4> {{ __('Senarai Pengguna Berdaftar') }} </h4>
                        </x-nav-link>

                        <x-nav-link :href="route('class.index')" :active="request()->routeIs('class.index')">
                            <h4> {{ __('Senarai Kelas') }} </h4>
                        </x-nav-link>
                        <x-nav-link :href="route('feetype.index')" :active="request()->routeIs('feetype.index')">
                            <h4> {{ __('Senarai Jenis Yuran') }} </h4>
                        </x-nav-link>

                        <x-nav-link :href="route('record.index')" :active="request()->is('records')">
                            <h4> {{ __('Rekod Transaksi') }} </h4>
                        </x-nav-link>
                    @endif

                    @if (Auth::check() && Auth::user()->type !== 'parent')
                    <x-nav-link :href="route('student.index')" :active="request()->routeIs('student.index')">
                        <h4> {{ __('Senarai Pelajar') }} </h4>
                    </x-nav-link>
                    @endif
                </div>
                {{ $slot }} 

            </div>
        </main>
    </div>
</body>

</html>

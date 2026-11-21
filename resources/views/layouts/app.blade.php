<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PT Auto Prima Sukses') }}</title>
    <link rel="icon" href="{{ asset('images/logo-aps.jpeg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased">

    <!-- ===== NAVBAR ===== -->
    <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-aps.jpeg') }}" alt="Logo PT Auto Prima Sukses" class="h-11 w-auto object-contain">
                <div class="hidden sm:block">
                    <p class="font-black leading-none text-[#0B2D6B]">Auto Prima Sukses</p>
                    <p class="mt-0.5 text-[10px] font-bold tracking-widest text-slate-400 uppercase">Trusted Trading</p>
                </div>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}#beranda"
                   class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-[#0B2D6B] transition">Beranda</a>
                <a href="{{ route('home') }}#filosofi"
                   class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-[#0B2D6B] transition">Filosofi & Visi</a>
                <a href="{{ route('home') }}#nilai"
                   class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-[#0B2D6B] transition">Nilai Perusahaan</a>
                <a href="{{ route('catalog') }}"
                   class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-[#0B2D6B] transition">Katalog</a>
                
                <a href="https://wa.me/?text={{ urlencode('Halo PT Auto Prima Sukses, saya ingin menanyakan informasi produk & distribusi cat Huber.') }}"
                   target="_blank" rel="noopener"
                   class="ml-2 inline-flex items-center gap-1.5 rounded-xl bg-[#D91B24] px-4 py-2 text-xs font-black text-white hover:bg-red-700 transition shadow-sm">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Hubungi Sales
                </a>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="ml-2 rounded-xl bg-[#0B2D6B] px-4 py-2 text-xs font-black text-white hover:bg-[#09245a] transition shadow-sm">
                        Dashboard Admin
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button id="mobile-menu-btn" aria-label="Toggle Menu"
                    class="inline-flex items-center rounded-xl border border-slate-200 p-2 text-slate-600 hover:bg-slate-100 md:hidden">
                <svg id="icon-open" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white px-4 pb-4 md:hidden">
            <div class="mt-3 flex flex-col gap-1">
                <a href="{{ route('home') }}#beranda"
                   class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Beranda</a>
                <a href="{{ route('home') }}#filosofi"
                   class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Filosofi & Visi Misi</a>
                <a href="{{ route('home') }}#nilai"
                   class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Nilai Perusahaan</a>
                <a href="{{ route('catalog') }}"
                   class="rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Katalog</a>
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="mt-1 rounded-xl bg-[#0B2D6B] px-4 py-3 text-sm font-black text-white text-center">Dashboard Admin</a>
                @endauth
                <a href="https://wa.me/?text={{ urlencode('Halo PT Auto Prima Sukses, saya ingin menanyakan informasi produk & distribusi cat Huber.') }}"
                   target="_blank" rel="noopener"
                   class="mt-2 rounded-xl bg-[#D91B24] px-4 py-3 text-sm font-black text-white text-center flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Hubungi Sales
                </a>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN ===== -->
    <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold text-emerald-800">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <svg class="h-5 w-5 shrink-0 text-[#D91B24]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold text-red-800">{{ session('error') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">{{ $errors->first() }}</div>
        @endif
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="border-t border-slate-200 bg-[#0B2D6B] text-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-3">
                <!-- Brand -->
                <div class="sm:col-span-1">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-aps.jpeg') }}" alt="PT Auto Prima Sukses" class="h-14 w-14 rounded-xl bg-white object-contain p-1">
                        <div>
                            <p class="font-black text-white leading-tight">PT Auto Prima Sukses</p>
                            <p class="mt-1 text-xs font-bold text-blue-200 tracking-widest uppercase">Trusted Trading</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm font-black tracking-wider text-blue-100 italic">
                        "CONNECTING BUSINESS, CREATING VALUE."
                    </p>
                </div>
                <!-- Links -->
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-blue-300 mb-4">Navigasi</p>
                    <div class="flex flex-col gap-2 text-sm">
                        <a href="{{ route('home') }}" class="text-blue-100 hover:text-white transition">Beranda</a>
                        <a href="{{ route('home') }}#filosofi" class="text-blue-100 hover:text-white transition">Filosofi & Visi Misi</a>
                        <a href="{{ route('home') }}#nilai" class="text-blue-100 hover:text-white transition">Nilai Perusahaan</a>
                        <a href="{{ route('catalog') }}" class="text-blue-100 hover:text-white transition">Katalog Produk</a>
                    </div>
                </div>
                <!-- Contact -->
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-blue-300 mb-4">Kontak</p>
                    <div class="flex flex-col gap-2.5 text-sm text-blue-100">
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            autoprimasukses.my.id
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            info@autoprimasukses.my.id
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4 shrink-0 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Jawa Timur, Indonesia
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-8 border-t border-white/10 pt-6 flex flex-col items-center gap-2 text-xs text-blue-300 sm:flex-row sm:justify-between">
                <span>© {{ date('Y') }} PT Auto Prima Sukses. All rights reserved.</span>
                <span>autoprimasukses.my.id</span>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
    </script>

    {{-- Global Confirmation Modal & Floating Toast Notification --}}
    <x-confirm-dialog />
    <x-toast-notification />
</body>
</html>

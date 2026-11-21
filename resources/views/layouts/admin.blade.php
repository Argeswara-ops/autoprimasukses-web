<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin APS | PT Auto Prima Sukses</title>
    <link rel="icon" href="{{ asset('images/logo-aps.jpeg') }}" type="image/jpeg">

    {{-- Google Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Chart.js for interactive analytics --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100/80 font-sans text-slate-800 antialiased">
    <div class="flex min-h-screen">

        {{-- ===== DESKTOP SIDEBAR ===== --}}
        <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 flex-col bg-[#0B2D6B] text-white shadow-2xl lg:flex">
            {{-- Brand Header --}}
            <a href="{{ route('dashboard') }}" class="flex h-24 items-center gap-3.5 border-b border-white/10 px-6 transition hover:bg-white/5">
                <div class="rounded-xl bg-white p-1.5 shadow-md shrink-0">
                    <img src="{{ asset('images/logo-aps.jpeg') }}" alt="APS Logo" class="h-11 w-11 object-contain">
                </div>
                <div class="overflow-hidden">
                    <p class="font-extrabold text-sm tracking-tight text-white truncate">PT Auto Prima Sukses</p>
                    <p class="mt-0.5 text-[11px] font-semibold text-blue-200 tracking-wider uppercase">Sistem Operasional</p>
                </div>
            </a>

            {{-- Navigation Menu --}}
            <nav class="flex-1 space-y-1.5 px-4 py-6 overflow-y-auto">
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-blue-300/80">Menu Utama</p>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-bold transition {{ request()->routeIs('dashboard') ? 'bg-white text-[#0B2D6B] shadow-md shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0 transition {{ request()->routeIs('dashboard') ? 'text-[#0B2D6B]' : 'text-blue-200 group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Produk & Stok --}}
                <a href="{{ route('products.index') }}"
                   class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-bold transition {{ request()->routeIs('products.*') ? 'bg-white text-[#0B2D6B] shadow-md shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0 transition {{ request()->routeIs('products.*') ? 'text-[#0B2D6B]' : 'text-blue-200 group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Produk &amp; Stok</span>
                </a>

                {{-- Faktur & Invoice --}}
                <a href="{{ route('invoices.index') }}"
                   class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-bold transition {{ request()->routeIs('invoices.*') ? 'bg-white text-[#0B2D6B] shadow-md shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0 transition {{ request()->routeIs('invoices.*') ? 'text-[#0B2D6B]' : 'text-blue-200 group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Faktur &amp; Invoice</span>
                </a>

                {{-- Suggest PO Jatim --}}
                <a href="{{ route('purchase_orders.index') }}"
                   class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-bold transition {{ request()->routeIs('purchase_orders.*') ? 'bg-white text-[#0B2D6B] shadow-md shadow-black/10' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0 transition {{ request()->routeIs('purchase_orders.*') ? 'text-[#0B2D6B]' : 'text-blue-200 group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span>Suggest PO Jatim</span>
                </a>

                <p class="px-3 pt-5 pb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-blue-300/80">Tampilan Luar</p>

                {{-- Website Publik --}}
                <a href="{{ route('catalog') }}" target="_blank"
                   class="group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-bold text-blue-100 hover:bg-white/10 hover:text-white transition">
                    <svg class="h-5 w-5 shrink-0 text-blue-200 group-hover:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Katalog Publik</span>
                </a>
            </nav>

            {{-- Sidebar Footer with User Profile and Logout Button with SVG Icon --}}
            <div class="border-t border-white/10 bg-[#082252]/50 p-4">
                {{-- User Badge --}}
                <div class="flex items-center gap-3 px-2 py-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-white font-black text-sm border border-white/15 shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            <p class="text-[10px] font-semibold text-blue-200">Online · Admin</p>
                        </div>
                    </div>
                </div>

                {{-- Logout Form with Confirmation UI --}}
                <form id="logout-form-desktop" method="POST" action="{{ route('logout') }}" class="mt-2.5">
                    @csrf
                    <button type="button"
                            onclick="confirmAction({
                                title: 'Konfirmasi Keluar',
                                message: 'Apakah Anda yakin ingin keluar dari sesi sistem operasional PT Auto Prima Sukses?',
                                confirmText: 'Ya, Keluar',
                                cancelText: 'Batal',
                                type: 'warning',
                                formId: 'logout-form-desktop'
                            })"
                            class="group flex w-full items-center justify-between rounded-xl border border-red-400/20 bg-red-500/10 px-3.5 py-2.5 text-xs font-bold text-red-200 hover:border-red-400/40 hover:bg-red-500/25 hover:text-white transition duration-150">
                        <div class="flex items-center gap-2.5">
                            {{-- Logout SVG Icon --}}
                            <svg class="h-4 w-4 text-red-300 transition group-hover:text-white group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Keluar dari Sistem</span>
                        </div>
                        <span class="text-[10px] uppercase tracking-wider text-red-300/80 group-hover:text-white font-extrabold">Exit</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT AREA ===== --}}
        <div class="w-full lg:pl-72 flex flex-col min-h-screen">
            {{-- Top Header --}}
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200/80 bg-white/95 px-4 backdrop-blur lg:px-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 lg:hidden">
                    <img src="{{ asset('images/logo-aps.jpeg') }}" alt="APS Logo" class="h-9 w-9 rounded-lg bg-white object-contain p-1 border border-slate-200">
                    <span class="font-extrabold text-sm text-[#0B2D6B]">PT APS</span>
                </a>
                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span>Sistem Operasional PT Auto Prima Sukses</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank"
                       class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-xs font-bold text-[#0B2D6B] hover:bg-slate-100 transition">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Website Publik
                    </a>
                </div>
            </header>

            {{-- Mobile Sub-Navigation --}}
            <nav class="flex gap-2 overflow-x-auto border-b border-slate-200 bg-white px-4 py-2.5 lg:hidden">
                <a href="{{ route('dashboard') }}" class="shrink-0 rounded-lg px-3 py-1.5 text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-[#0B2D6B] text-white' : 'bg-slate-100 text-slate-600' }}">Dashboard</a>
                <a href="{{ route('products.index') }}" class="shrink-0 rounded-lg px-3 py-1.5 text-xs font-bold {{ request()->routeIs('products.*') ? 'bg-[#0B2D6B] text-white' : 'bg-slate-100 text-slate-600' }}">Produk</a>
                <a href="{{ route('invoices.index') }}" class="shrink-0 rounded-lg px-3 py-1.5 text-xs font-bold {{ request()->routeIs('invoices.*') ? 'bg-[#0B2D6B] text-white' : 'bg-slate-100 text-slate-600' }}">Invoice</a>
                <a href="{{ route('purchase_orders.index') }}" class="shrink-0 rounded-lg px-3 py-1.5 text-xs font-bold {{ request()->routeIs('purchase_orders.*') ? 'bg-[#0B2D6B] text-white' : 'bg-slate-100 text-slate-600' }}">Suggest PO</a>
                <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="button"
                            onclick="confirmAction({
                                title: 'Konfirmasi Keluar',
                                message: 'Apakah Anda yakin ingin keluar dari sistem operasional PT Auto Prima Sukses?',
                                confirmText: 'Ya, Keluar',
                                cancelText: 'Batal',
                                type: 'warning',
                                formId: 'logout-form-mobile'
                            })"
                            class="inline-flex items-center gap-1 rounded-lg bg-red-50 border border-red-200 px-3 py-1.5 text-xs font-bold text-[#D91B24]">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </nav>

            {{-- Main Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
                         class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-semibold text-emerald-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif
                @if($errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms
                         class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 font-semibold text-red-800 shadow-sm">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                        <button type="button" @click="show = false" class="text-red-500 hover:text-red-700 p-1 rounded-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Global Confirmation Modal & Floating Toast Notification --}}
    <x-confirm-dialog />
    <x-toast-notification />

    @stack('scripts')
</body>
</html>

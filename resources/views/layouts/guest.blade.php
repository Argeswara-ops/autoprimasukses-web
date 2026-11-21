<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin | PT Auto Prima Sukses</title>
    <link rel="icon" href="{{ asset('images/logo-aps.jpeg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans antialiased text-slate-800">
    <main class="grid min-h-screen lg:grid-cols-[1.1fr_490px]">
        {{-- Left Hero Section --}}
        <section class="relative hidden items-center justify-center overflow-hidden bg-gradient-to-br from-[#0B2D6B] via-[#082252] to-[#04122d] p-12 text-white lg:flex">
            {{-- Ambient Decorative Glows --}}
            <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-20 -bottom-20 h-80 w-80 rounded-full bg-[#D91B24]/15 blur-3xl pointer-events-none"></div>

            <div class="relative max-w-lg z-10 space-y-6">
                {{-- Logo Card (Own Line) --}}
                <div>
                    <div class="inline-block rounded-2xl bg-white p-3.5 shadow-2xl shadow-black/30 border border-white/20">
                        <img src="{{ asset('images/logo-aps.jpeg') }}" alt="PT Auto Prima Sukses" class="h-16 w-auto object-contain">
                    </div>
                </div>

                {{-- Status Pill Badge (Strictly Below Logo) --}}
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-blue-300/30 bg-blue-500/20 px-3.5 py-1.5 text-xs font-black uppercase tracking-wider text-blue-200 backdrop-blur-sm shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Sistem Operasional &amp; Faktur B2B
                    </span>
                </div>

                {{-- Headline --}}
                <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl">
                    Kelola bisnis &amp; perdagangan lebih terstruktur.
                </h1>

                {{-- Description --}}
                <p class="text-base leading-relaxed text-blue-100/90 font-medium">
                    Akses portal internal PT Auto Prima Sukses untuk monitoring stok real-time, manajemen sistem faktur invoice penjualan B2B, dan perhitungan otomatis Suggest PO area Jawa Timur.
                </p>

                {{-- Key Highlights 3-Card Grid --}}
                <div class="grid grid-cols-3 gap-3 border-t border-white/15 pt-6">
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-blue-200">Katalog</p>
                        <p class="mt-1 text-base font-black text-white">Cat Huber</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-blue-200">Wilayah</p>
                        <p class="mt-1 text-base font-black text-white">Jawa Timur</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md shadow-sm">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-blue-200">Sistem</p>
                        <p class="mt-1 text-base font-black text-emerald-400">Terintegrasi</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Right Login Form Section --}}
        <section class="flex items-center justify-center px-5 py-10 sm:px-10 bg-slate-50">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </section>
    </main>
</body>
</html>

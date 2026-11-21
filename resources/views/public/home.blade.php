@extends('layouts.app')

@section('content')

{{-- ===== HERO ===== --}}
<section id="beranda" class="relative overflow-hidden rounded-[2rem] bg-[#0B2D6B] px-6 py-16 text-white shadow-2xl sm:px-10 lg:px-14 lg:py-24">
    <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 h-32 w-32 rounded-tl-full bg-[#D91B24]/90 pointer-events-none"></div>
    <div class="relative grid items-center gap-10 lg:grid-cols-[1.4fr_0.6fr]">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.32em] text-blue-200">A Trusted Trading &amp; Business Development Company</p>
            <h1 class="mt-5 max-w-4xl text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                CONNECTING BUSINESS, <span class="text-[#F35B61]">CREATING VALUE.</span>
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-blue-100">
                PT Auto Prima Sukses bukan hanya menjalankan aktivitas jual beli, tetapi juga menghubungkan peluang usaha,
                mengembangkan pasar, dan membangun kemitraan strategis yang saling menguntungkan.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('catalog') }}"
                   class="rounded-xl bg-white px-5 py-3 text-sm font-black text-[#0B2D6B] shadow-lg hover:bg-blue-50 transition">
                    Lihat Katalog Produk
                </a>
                <a href="mailto:info@autoprimasukses.my.id"
                   class="rounded-xl border border-white/30 px-5 py-3 text-sm font-black text-white hover:bg-white/10 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
        <div class="rounded-[2rem] border border-white/20 bg-white p-6 text-center shadow-xl">
            <img src="{{ asset('images/logo-aps.jpeg') }}" alt="Logo PT Auto Prima Sukses" class="mx-auto max-h-48 w-full object-contain">
        </div>
    </div>
</section>

{{-- ===== KEUNGGULAN ===== --}}
<section class="mt-10 grid gap-4 sm:grid-cols-3">
    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-[#0B2D6B] group-hover:text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h3 class="mt-4 font-black text-[#0B2D6B]">Distributor Resmi</h3>
        <p class="mt-2 text-sm leading-6 text-slate-500">Produk cat & pelapis otomotif berkualitas tinggi langsung dari pabrik terpercaya.</p>
    </div>

    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-[#0B2D6B] group-hover:text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <h3 class="mt-4 font-black text-[#0B2D6B]">Kemitraan Strategis</h3>
        <p class="mt-2 text-sm leading-6 text-slate-500">Jaringan mitra dealer, bengkel, dan toko cat di seluruh Jawa Timur dan sekitarnya.</p>
    </div>

    <div class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-blue-200 transition">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-[#0B2D6B] group-hover:text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
            </svg>
        </div>
        <h3 class="mt-4 font-black text-[#0B2D6B]">Pengiriman Terpercaya</h3>
        <p class="mt-2 text-sm leading-6 text-slate-500">Sistem logistik yang andal dengan ketersediaan stok yang terjaga dan pengiriman tepat waktu.</p>
    </div>
</section>

{{-- ===== FILOSOFI & VISI ===== --}}
<section id="filosofi" class="mt-12 grid gap-6 lg:grid-cols-[0.9fr_1.1fr] scroll-mt-20">
    <article class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm hover:shadow-md hover:border-blue-100 transition">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Filosofi Perusahaan</p>
        <blockquote class="mt-5 text-2xl font-black leading-snug text-[#0B2D6B]">
            Menghubungkan peluang, membangun kemitraan terpercaya, dan menciptakan nilai yang berkelanjutan.
        </blockquote>
        <p class="mt-4 font-semibold text-slate-500 italic">
            "We connect opportunities, build trusted partnerships, and create sustainable value."
        </p>
    </article>
    <article class="rounded-[2rem] bg-[#D91B24] p-8 text-white shadow-xl hover:shadow-2xl hover:scale-[1.01] transition">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-red-100">Visi Perusahaan</p>
        <h2 class="mt-5 text-2xl font-black leading-snug">
            Menjadi perusahaan perdagangan yang terpercaya, profesional, dan berdaya saing tinggi dengan membangun
            jaringan bisnis yang luas serta menciptakan nilai tambah dan pertumbuhan berkelanjutan bagi seluruh mitra usaha.
        </h2>
    </article>
</section>

{{-- ===== MISI ===== --}}
<section class="mt-12">
    <div class="mb-7 text-center">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Misi Perusahaan</p>
        <h2 class="mt-3 text-3xl font-black text-[#0B2D6B]">Komitmen dalam aktivitas perdagangan</h2>
        <p class="mt-2 text-slate-500 max-w-xl mx-auto">Enam langkah konkret yang menjadi panduan operasional PT Auto Prima Sukses setiap harinya.</p>
    </div>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach([
            ['01','Membangun Kemitraan Strategis','Mengembangkan hubungan bisnis yang kuat dan saling menguntungkan dengan supplier, distributor, pelanggan, dan mitra usaha.'],
            ['02','Mengutamakan Kepercayaan & Integritas','Menjalankan setiap aktivitas perdagangan secara jujur, transparan, profesional, dan bertanggung jawab.'],
            ['03','Menciptakan Nilai Tambah','Memberikan produk, layanan, dan solusi perdagangan yang berkualitas serta kompetitif.'],
            ['04','Mengembangkan Jaringan Perdagangan','Memperluas jangkauan pasar dan peluang bisnis di tingkat regional, nasional, maupun internasional.'],
            ['05','Mendorong Pertumbuhan Berkelanjutan','Membangun perusahaan yang sehat, produktif, inovatif, dan memberikan keuntungan bagi seluruh pemangku kepentingan.'],
            ['06','Membangun Sumber Daya Manusia Berkualitas','Mengembangkan tim yang kompeten, berintegritas, berorientasi pada hasil, dan menjunjung tinggi kerja sama.'],
        ] as $mission)
        <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm hover:border-[#0B2D6B] hover:shadow-md transition cursor-default">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#D91B24] text-sm font-black text-white">{{ $mission[0] }}</span>
            <h3 class="mt-4 text-base font-black text-[#0B2D6B] group-hover:text-[#D91B24] transition">{{ $mission[1] }}</h3>
            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $mission[2] }}</p>
        </article>
        @endforeach
    </div>
</section>

{{-- ===== CORE VALUES ===== --}}
<section id="nilai" class="mt-12 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm scroll-mt-20">
    <div class="mb-7 text-center">
        <p class="text-xs font-black uppercase tracking-[0.25em] text-[#D91B24]">Nilai-Nilai Perusahaan</p>
        <h2 class="mt-3 text-3xl font-black text-[#0B2D6B]">Five Core Values</h2>
        <p class="mt-2 text-slate-500 max-w-lg mx-auto">Lima nilai inti yang mendasari setiap keputusan dan tindakan PT Auto Prima Sukses.</p>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        {{-- TRUST --}}
        <article class="group rounded-2xl border border-blue-100 bg-slate-50 px-5 py-6 text-center hover:border-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition cursor-default">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-white group-hover:text-[#0B2D6B]">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="mt-4 font-black text-[#0B2D6B] group-hover:text-white transition tracking-widest text-sm uppercase">TRUST</h3>
            <p class="mt-2 text-xs leading-5 text-slate-500 group-hover:text-blue-200 transition">Kepercayaan adalah fondasi bisnis kami.</p>
        </article>

        {{-- INTEGRITY --}}
        <article class="group rounded-2xl border border-blue-100 bg-slate-50 px-5 py-6 text-center hover:border-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition cursor-default">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-white group-hover:text-[#0B2D6B]">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
            </div>
            <h3 class="mt-4 font-black text-[#0B2D6B] group-hover:text-white transition tracking-widest text-sm uppercase">INTEGRITY</h3>
            <p class="mt-2 text-xs leading-5 text-slate-500 group-hover:text-blue-200 transition">Kejujuran dalam setiap transaksi.</p>
        </article>

        {{-- PARTNERSHIP --}}
        <article class="group rounded-2xl border border-blue-100 bg-slate-50 px-5 py-6 text-center hover:border-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition cursor-default">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-white group-hover:text-[#0B2D6B]">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <h3 class="mt-4 font-black text-[#0B2D6B] group-hover:text-white transition tracking-widest text-sm uppercase">PARTNERSHIP</h3>
            <p class="mt-2 text-xs leading-5 text-slate-500 group-hover:text-blue-200 transition">Tumbuh dan sukses bersama mitra.</p>
        </article>

        {{-- EXCELLENCE --}}
        <article class="group rounded-2xl border border-blue-100 bg-slate-50 px-5 py-6 text-center hover:border-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition cursor-default">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-white group-hover:text-[#0B2D6B]">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3h14a1 1 0 011 1v3a5 5 0 01-5 5h-1a5 5 0 01-5-5V4a1 1 0 011-1z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6H2a1 1 0 00-1 1v1a4 4 0 004 4h1M20 6h2a1 1 0 011 1v1a4 4 0 01-4 4h-1M12 12v5m-4 4h8" />
                </svg>
            </div>
            <h3 class="mt-4 font-black text-[#0B2D6B] group-hover:text-white transition tracking-widest text-sm uppercase">EXCELLENCE</h3>
            <p class="mt-2 text-xs leading-5 text-slate-500 group-hover:text-blue-200 transition">Mengutamakan kualitas &amp; pelayanan terbaik.</p>
        </article>

        {{-- GROWTH --}}
        <article class="group rounded-2xl border border-blue-100 bg-slate-50 px-5 py-6 text-center hover:border-[#0B2D6B] hover:bg-[#0B2D6B] hover:text-white transition cursor-default">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-[#0B2D6B] transition group-hover:bg-white group-hover:text-[#0B2D6B]">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <h3 class="mt-4 font-black text-[#0B2D6B] group-hover:text-white transition tracking-widest text-sm uppercase">GROWTH</h3>
            <p class="mt-2 text-xs leading-5 text-slate-500 group-hover:text-blue-200 transition">Terus berkembang dan menciptakan peluang.</p>
        </article>
    </div>
</section>

{{-- ===== CTA KATALOG ===== --}}
<section class="mt-12 rounded-[2rem] bg-gradient-to-br from-[#0B2D6B] to-blue-800 px-8 py-12 text-white text-center shadow-xl">
    <p class="text-xs font-black uppercase tracking-[0.3em] text-blue-200">Distribusi & Kemitraan</p>
    <h2 class="mt-4 text-3xl font-black">Siap Bermitra dengan Kami?</h2>
    <p class="mt-4 max-w-xl mx-auto text-blue-100 leading-7">
        Jelajahi katalog lengkap produk cat & pelapis otomotif Huber yang kami distribusikan, atau hubungi tim kami untuk penawaran khusus distributor dan dealer.
    </p>
    <div class="mt-8 flex flex-wrap justify-center gap-4">
        <a href="{{ route('catalog') }}"
           class="rounded-xl bg-white px-6 py-3 text-sm font-black text-[#0B2D6B] shadow hover:bg-blue-50 transition">
            Lihat Katalog Produk →
        </a>
        <a href="https://wa.me/?text={{ urlencode('Halo PT Auto Prima Sukses, saya ingin mengetahui lebih lanjut tentang kemitraan distribusi.') }}"
           target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-black text-white shadow-lg hover:bg-emerald-700 transition">
            <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            Hubungi via WhatsApp
        </a>
    </div>
</section>

@endsection

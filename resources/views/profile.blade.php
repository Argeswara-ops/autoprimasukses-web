@extends('layouts.app')

@section('content')
<section class="relative overflow-hidden rounded-3xl bg-slate-950 px-6 py-14 text-white shadow-xl sm:px-10 lg:px-14 lg:py-20">
    <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl"></div>
    <div class="relative grid items-center gap-10 lg:grid-cols-[1.35fr_0.65fr]">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.28em] text-blue-300">Profil Perusahaan</p>
            <h1 class="mt-5 max-w-3xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                Connecting Business, <span class="text-blue-400">Creating Value.</span>
            </h1>
            <p class="mt-6 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                PT Auto Prima Sukses menghubungkan peluang, membangun kemitraan terpercaya,
                dan menciptakan nilai yang berkelanjutan bagi seluruh mitra usaha.
            </p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur sm:p-8">
            <img src="{{ asset('logo-aps.jpg') }}" alt="Logo PT Auto Prima Sukses" class="mx-auto max-h-40 w-full object-contain">
            <p class="mt-5 text-center text-sm font-bold uppercase tracking-[0.16em] text-slate-300">
                Trusted Trading &amp; Business Development
            </p>
        </div>
    </div>
</section>

<section class="mt-8 grid gap-6 lg:grid-cols-[0.85fr_1.15fr]">
    <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm sm:p-9">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-700">Visi</p>
        <h2 class="mt-4 text-2xl font-bold text-slate-950 sm:text-3xl">Menjadi perusahaan perdagangan yang terpercaya, profesional, dan berdaya saing tinggi.</h2>
        <p class="mt-5 leading-7 text-slate-600">
            Membangun jaringan bisnis yang luas serta menciptakan nilai tambah dan pertumbuhan
            berkelanjutan bagi seluruh mitra usaha.
        </p>
    </div>
    <div class="rounded-3xl bg-blue-700 p-7 text-white shadow-lg sm:p-9">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-200">Filosofi</p>
        <h2 class="mt-4 text-2xl font-bold">We connect opportunities, build trusted partnerships, and create sustainable value.</h2>
        <p class="mt-5 leading-7 text-blue-100">
            Menghubungkan peluang, membangun kemitraan terpercaya, dan menciptakan nilai yang
            berkelanjutan.
        </p>
    </div>
</section>

<section class="mt-8">
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-700">Misi Perusahaan</p>
        <h2 class="mt-3 text-3xl font-bold text-slate-950">Komitmen dalam aktivitas perdagangan</h2>
    </div>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach ([
            ['01', 'Membangun Kemitraan Strategis', 'Mengembangkan hubungan bisnis yang kuat dan saling menguntungkan dengan semua mitra.'],
            ['02', 'Kepercayaan & Integritas', 'Menjalankan aktivitas secara jujur, transparan, profesional, dan bertanggung jawab.'],
            ['03', 'Menciptakan Nilai Tambah', 'Memberikan produk, layanan, dan solusi perdagangan berkualitas serta kompetitif.'],
            ['04', 'Mengembangkan Jaringan', 'Memperluas jangkauan pasar dan peluang pada tingkat regional, nasional, maupun internasional.'],
            ['05', 'Pertumbuhan Berkelanjutan', 'Membangun perusahaan yang sehat, produktif, inovatif, dan menguntungkan bagi pemangku kepentingan.'],
            ['06', 'Sumber Daya Unggul', 'Mengembangkan tim yang kompeten, berintegritas, berorientasi hasil, dan menjunjung kerja sama.'],
        ] as $mission)
            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <span class="text-xs font-bold text-blue-700">{{ $mission[0] }}</span>
                <h3 class="mt-3 text-lg font-bold text-slate-950">{{ $mission[1] }}</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $mission[2] }}</p>
            </article>
        @endforeach
    </div>
</section>

<section class="mt-8 rounded-3xl border border-slate-200 bg-white p-7 shadow-sm sm:p-9">
    <div class="mb-7">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-700">Produk Huber</p>
        <h2 class="mt-3 text-3xl font-bold text-slate-950">Pilihan produk yang kami sediakan</h2>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($products as $product)
            <article class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="text-base font-bold leading-6 text-slate-950">{{ $product->name }}</h3>
                    <span class="shrink-0 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700">{{ $product->size }}</span>
                </div>
                <p class="mt-4 text-sm text-slate-600">
                    Isi {{ $product->box_content }} unit per dus
                </p>
                <p class="mt-2 text-lg font-bold text-blue-700">
                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                </p>
            </article>
        @empty
            <p class="text-sm text-slate-500">Belum ada data produk.</p>
        @endforelse
    </div>
</section>

<section class="mt-8 rounded-3xl border border-slate-200 bg-white p-7 shadow-sm sm:p-9">
    <div class="mb-7">
        <p class="text-xs font-bold uppercase tracking-[0.22em] text-blue-700">Nilai-Nilai Perusahaan</p>
        <h2 class="mt-3 text-3xl font-bold text-slate-950">Pedoman perilaku dan pengambilan keputusan</h2>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ([
            ['Trust', 'Kepercayaan adalah fondasi bisnis.'],
            ['Integrity', 'Kejujuran dalam setiap transaksi.'],
            ['Partnership', 'Tumbuh dan sukses bersama.'],
            ['Excellence', 'Mengutamakan kualitas dan pelayanan.'],
            ['Growth', 'Terus berkembang dan menciptakan peluang.'],
        ] as $value)
            <article class="rounded-2xl bg-slate-50 px-5 py-6 text-center">
                <h3 class="text-base font-bold text-slate-950">{{ $value[0] }}</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $value[1] }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection

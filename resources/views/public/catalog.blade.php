@extends('layouts.app')

@section('content')

{{-- Search Header --}}
<section class="rounded-[2rem] bg-[#0B2D6B] px-6 py-12 text-white sm:px-10">
    <p class="text-xs font-bold uppercase tracking-[0.25em] text-blue-200">Distribusi Cat & Pelapis Otomotif</p>
    <h1 class="mt-3 text-4xl font-black">Katalog Produk Huber</h1>
    <p class="mt-2 text-blue-100 text-sm">Area distribusi: Jawa Timur & sekitarnya. Hubungi sales kami untuk penawaran distributor/dealer.</p>
    <form method="GET" action="{{ route('catalog') }}" class="mt-7 flex flex-col gap-3 sm:max-w-3xl sm:flex-row">
        <input type="search" name="search" value="{{ $search }}"
               placeholder="Cari seri, produk, atau ukuran..."
               class="min-w-0 flex-1 rounded-xl border-0 px-5 py-3.5 text-slate-900 placeholder:text-slate-400 text-sm shadow-sm focus:ring-2 focus:ring-[#D91B24] outline-none">
        <input type="hidden" name="category" value="{{ $category }}">
        <button type="submit"
                class="rounded-xl bg-[#D91B24] px-6 py-3.5 text-sm font-black text-white hover:bg-red-700 transition shadow-sm">
            Cari Produk
        </button>
    </form>
</section>

{{-- Category Filter --}}
<section class="mt-6 flex flex-wrap gap-2">
    <a href="{{ route('catalog') }}"
       class="rounded-xl border px-4 py-2.5 text-sm font-black transition
       {{ $category === '' ? 'border-[#0B2D6B] bg-[#0B2D6B] text-white shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:border-[#0B2D6B] hover:text-[#0B2D6B]' }}">
        Semua Produk
    </a>
    @foreach(['Clearcoats & Hardener','Primer & Epoxy','Basecoat & Top Coat','Thinner & Degreaser'] as $item)
    <a href="{{ route('catalog', ['category' => $item, 'search' => $search]) }}"
       class="rounded-xl border px-4 py-2.5 text-sm font-black transition
       {{ $category === $item ? 'border-[#D91B24] bg-[#D91B24] text-white shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:border-[#D91B24] hover:text-[#D91B24]' }}">
        {{ $item }}
    </a>
    @endforeach
</section>

{{-- Results --}}
<section class="mt-8 space-y-8">
    @forelse($catalog as $categoryName => $seriesList)
    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8 hover:shadow-md transition">
        <div class="mb-2 flex items-center gap-3">
            <span class="inline-block h-1.5 w-8 rounded-full bg-[#D91B24]"></span>
            <h2 class="text-xl font-black text-[#0B2D6B]">{{ $categoryName }}</h2>
        </div>
        <p class="text-xs text-slate-400 mb-5 ml-11">{{ $seriesList->count() }} seri tersedia</p>
        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            @foreach($seriesList as $seriesName => $items)
            <article class="group rounded-2xl border border-slate-200 bg-slate-50 p-5 hover:border-[#0B2D6B] hover:bg-blue-50/40 transition">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-black text-slate-900 group-hover:text-[#0B2D6B] transition">{{ $seriesName }}</h3>
                    <span class="shrink-0 rounded-full bg-[#0B2D6B]/10 px-2.5 py-1 text-xs font-black text-[#0B2D6B]">
                        {{ $items->pluck('size')->unique()->count() }} ukuran
                    </span>
                </div>

                {{-- Size badges --}}
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($items->pluck('size')->unique() as $size)
                    <span class="rounded-full border border-blue-200 bg-white px-3 py-1.5 text-xs font-black text-[#0B2D6B] shadow-sm">
                        {{ $size }}
                    </span>
                    @endforeach
                </div>

                {{-- Box info --}}
                <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Kemasan: <strong>{{ $items->pluck('box_content')->filter()->unique()->implode(' / ') ?: '—' }} pcs/dus</strong>
                </div>

                {{-- CTA --}}
                <div class="mt-4">
                    <a href="https://wa.me/?text={{ urlencode('Halo PT Auto Prima Sukses, saya ingin menanyakan penawaran untuk '.$seriesName) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700 hover:shadow-md transition group-hover:scale-[1.02]">
                        <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Ajukan Penawaran
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @empty
    <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-sm">
        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <p class="font-bold text-slate-500">Produk tidak ditemukan untuk pencarian "<em>{{ $search }}</em>".</p>
        <a href="{{ route('catalog') }}" class="mt-4 inline-block text-sm font-black text-[#0B2D6B] hover:underline">Lihat semua produk →</a>
    </div>
    @endforelse
</section>

@endsection

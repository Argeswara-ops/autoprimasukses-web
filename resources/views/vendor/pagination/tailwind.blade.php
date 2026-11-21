@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex items-center justify-between">
        {{-- Mobile View --}}
        <div class="flex flex-1 justify-between items-center sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-100 px-4 py-2 text-xs font-bold text-slate-400 cursor-not-allowed">
                    ← Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                    ← Sebelumnya
                </a>
            @endif

            <span class="text-xs font-bold text-slate-500">
                Halaman {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center rounded-xl bg-[#0B2D6B] px-4 py-2 text-xs font-bold text-white hover:bg-[#09245a] transition shadow-sm">
                    Selanjutnya →
                </a>
            @else
                <span class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-100 px-4 py-2 text-xs font-bold text-slate-400 cursor-not-allowed">
                    Selanjutnya →
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-slate-500 font-medium">
                    Menampilkan
                    <span class="font-bold text-slate-800">{{ $paginator->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-bold text-slate-800">{{ $paginator->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-bold text-slate-800">{{ $paginator->total() }}</span>
                    total data
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-1.5">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-400 cursor-not-allowed">
                            ← Sebelumnya
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-700 hover:border-[#0B2D6B] hover:text-[#0B2D6B] transition shadow-sm">
                            ← Sebelumnya
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="px-2 py-1 text-xs font-bold text-slate-400">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex h-8 min-w-[2rem] px-2 items-center justify-center rounded-xl bg-[#0B2D6B] text-xs font-black text-white shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-8 min-w-[2rem] px-2 items-center justify-center rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700 hover:border-[#0B2D6B] hover:text-[#0B2D6B] transition shadow-sm">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-xl bg-[#0B2D6B] px-3.5 py-1.5 text-xs font-bold text-white hover:bg-[#09245a] transition shadow-sm">
                            Selanjutnya →
                        </a>
                    @else
                        <span class="inline-flex items-center rounded-xl border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-400 cursor-not-allowed">
                            Selanjutnya →
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif

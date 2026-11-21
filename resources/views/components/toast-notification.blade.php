{{-- Global High-End Toast Notification UI (Tailwind + Alpine.js) --}}
<div x-data="{
        toasts: [],
        add(toast) {
            const id = Date.now() + Math.random().toString(36).substring(2, 5);
            const item = {
                id,
                title: toast.title || (toast.type === 'success' ? 'Berhasil' : (toast.type === 'error' ? 'Pemberitahuan Sistem' : (toast.type === 'warning' ? 'Perhatian' : 'Informasi'))),
                message: toast.message || '',
                type: toast.type || 'success', {{-- success, error, warning, info --}}
                duration: toast.duration || 5000,
            };
            this.toasts.push(item);
            if (item.duration > 0) {
                setTimeout(() => this.remove(id), item.duration);
            }
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
     }"
     x-init="
        window.showToast = function(options) {
            add(options);
        };
        window.addEventListener('toast', (e) => add(e.detail));

        @if(session('success'))
            add({
                type: 'success',
                title: 'Berhasil',
                message: @js(session('success')),
                duration: 5000
            });
        @endif

        @if(session('error'))
            add({
                type: 'error',
                title: 'Gagal / Perhatian',
                message: @js(session('error')),
                duration: 7000
            });
        @endif

        @if($errors->any())
            add({
                type: 'error',
                title: 'Kesalahan Input',
                message: @js($errors->first()),
                duration: 7000
            });
        @endif
     "
     class="fixed top-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm w-full pointer-events-none"
     x-cloak>

    <template x-for="toast in toasts" :key="toast.id">
        <div x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="pointer-events-auto flex items-start gap-3 rounded-2xl bg-white p-4 shadow-xl border transition-all"
             :class="{
                 'border-emerald-200 shadow-emerald-500/10': toast.type === 'success',
                 'border-red-200 shadow-red-500/10': toast.type === 'error',
                 'border-amber-200 shadow-amber-500/10': toast.type === 'warning',
                 'border-blue-200 shadow-blue-500/10': toast.type === 'info'
             }">

            {{-- Icon Badge --}}
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl"
                 :class="{
                     'bg-emerald-50 text-emerald-600': toast.type === 'success',
                     'bg-red-50 text-[#D91B24]': toast.type === 'error',
                     'bg-amber-50 text-amber-600': toast.type === 'warning',
                     'bg-blue-50 text-[#0B2D6B]': toast.type === 'info'
                 }">
                <template x-if="toast.type === 'success'">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
                <template x-if="toast.type === 'info'">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </template>
            </div>

            {{-- Text content --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-xs font-black text-slate-900" x-text="toast.title"></p>
                <p class="mt-0.5 text-xs font-medium text-slate-600 leading-snug break-words" x-text="toast.message"></p>
            </div>

            {{-- Close Button --}}
            <button type="button"
                    @click="remove(toast.id)"
                    class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>

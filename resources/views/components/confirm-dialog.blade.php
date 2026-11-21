{{-- Global High-End Confirmation Modal UI (Tailwind + Alpine.js) --}}
<div x-data="{
        open: false,
        title: 'Konfirmasi',
        message: 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
        confirmText: 'Ya, Lanjutkan',
        cancelText: 'Batal',
        type: 'danger', {{-- danger, warning, success, info --}}
        formId: null,
        callback: null,
        submitting: false,

        show(options) {
            this.title = options.title || 'Konfirmasi Tindakan';
            this.message = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            this.confirmText = options.confirmText || (options.type === 'danger' ? 'Ya, Hapus' : (options.type === 'success' ? 'Ya, Konfirmasi' : 'Ya, Lanjutkan'));
            this.cancelText = options.cancelText || 'Batal';
            this.type = options.type || 'danger';
            this.formId = options.formId || null;
            this.callback = typeof options.onConfirm === 'function' ? options.onConfirm : null;
            this.submitting = false;
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },

        close() {
            this.open = false;
            this.submitting = false;
            document.body.classList.remove('overflow-hidden');
        },

        confirm() {
            if (this.submitting) return;
            this.submitting = true;

            if (this.formId) {
                const targetForm = document.getElementById(this.formId);
                if (targetForm) {
                    targetForm.submit();
                    return;
                }
            }

            if (this.callback) {
                try {
                    this.callback();
                } finally {
                    this.close();
                }
            } else {
                this.close();
            }
        }
     }"
     x-init="
        window.confirmAction = function(options) {
            show(options);
        };
        window.addEventListener('open-confirm', (e) => show(e.detail));
     "
     x-on:keydown.escape.window="close()"
     x-cloak
     class="relative z-50">

    {{-- Backdrop with soft blur --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity"
         @click="close()">
    </div>

    {{-- Modal Box Container --}}
    <div x-show="open"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.away="close()"
             class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all border border-slate-100 text-left">

            {{-- Header with icon and descriptive text --}}
            <div class="flex items-start gap-4">
                {{-- Icon Badge --}}
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border"
                     :class="{
                         'bg-red-50 border-red-200 text-[#D91B24]': type === 'danger',
                         'bg-amber-50 border-amber-200 text-amber-600': type === 'warning',
                         'bg-emerald-50 border-emerald-200 text-emerald-600': type === 'success',
                         'bg-blue-50 border-blue-200 text-[#0B2D6B]': type === 'info'
                     }">
                    
                    {{-- Danger Icon (Trash / Delete) --}}
                    <template x-if="type === 'danger'">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </template>

                    {{-- Warning Icon (Alert / Logout) --}}
                    <template x-if="type === 'warning'">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </template>

                    {{-- Success Icon (Checkmark / Pay) --}}
                    <template x-if="type === 'success'">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </template>

                    {{-- Info Icon --}}
                    <template x-if="type === 'info'">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </template>
                </div>

                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-black text-slate-900 leading-snug tracking-tight" x-text="title"></h3>
                    <p class="mt-2 text-xs leading-relaxed text-slate-600 font-medium" x-text="message"></p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button type="button"
                        @click="close()"
                        :disabled="submitting"
                        class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition focus:outline-none">
                    <span x-text="cancelText">Batal</span>
                </button>

                <button type="button"
                        @click="confirm()"
                        :disabled="submitting"
                        class="inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-black text-white shadow-sm transition focus:outline-none disabled:opacity-50"
                        :class="{
                            'bg-[#D91B24] hover:bg-red-700 shadow-red-500/20': type === 'danger',
                            'bg-amber-500 hover:bg-amber-600 shadow-amber-500/20': type === 'warning',
                            'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20': type === 'success',
                            'bg-[#0B2D6B] hover:bg-[#09245a] shadow-blue-500/20': type === 'info'
                        }">
                    {{-- Spinner if submitting --}}
                    <svg x-show="submitting" class="h-3.5 w-3.5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span x-text="submitting ? 'Memproses...' : confirmText"></span>
                </button>
            </div>
        </div>
    </div>
</div>

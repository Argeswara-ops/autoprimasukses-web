<x-guest-layout>
    {{-- Mobile Brand Header --}}
    <div class="mb-6 flex flex-col items-center justify-center text-center lg:hidden">
        <a href="{{ route('home') }}" class="inline-block rounded-2xl bg-white p-2.5 shadow-md border border-slate-200">
            <img src="{{ asset('images/logo-aps.jpeg') }}" alt="APS Logo" class="h-14 w-auto object-contain">
        </a>
        <h2 class="mt-3 text-lg font-black text-[#0B2D6B]">PT Auto Prima Sukses</h2>
        <p class="text-xs text-slate-500 font-medium">Portal Administrator Operasional</p>
    </div>

    {{-- Main Login Card --}}
    <div class="rounded-3xl border border-slate-200/80 bg-white p-8 shadow-xl shadow-slate-200/50 sm:p-10">
        {{-- Card Header --}}
        <div>
            <div class="inline-flex items-center gap-1.5 rounded-md bg-red-50 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider text-[#D91B24]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#D91B24]"></span>
                Autentikasi Internal
            </div>
            <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">Masuk ke Sistem</h1>
            <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                Silakan masukkan alamat email dan kata sandi akun Anda untuk mengakses sistem.
            </p>
        </div>

        {{-- Status Notification --}}
        <x-auth-session-status class="mt-4" :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5" x-data="{ showPassword: false }">
            @csrf

            {{-- Email Input --}}
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Alamat Email
                </label>
                <div class="relative mt-2">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="nama@autoprimasukses.my.id"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50/50 py-3 pl-11 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-[#0B2D6B] focus:bg-white focus:ring-4 focus:ring-blue-100">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            {{-- Password Input with Show/Hide Toggle --}}
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Kata Sandi
                    </label>
                </div>
                <div class="relative mt-2">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password"
                           :type="showPassword ? 'text' : 'password'"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full rounded-xl border border-slate-300 bg-slate-50/50 py-3 pl-11 pr-12 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-[#0B2D6B] focus:bg-white focus:ring-4 focus:ring-blue-100">
                    
                    {{-- Toggle Show/Hide Button --}}
                    <button type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#0B2D6B] transition focus:outline-none"
                            title="Tampilkan / Sembunyikan Kata Sandi">
                        {{-- Eye Open (when password is hidden) --}}
                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{-- Eye Slash (when password is shown) --}}
                        <svg x-show="showPassword" style="display: none;" class="h-5 w-5 text-[#D91B24]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center gap-2.5 cursor-pointer">
                    <input id="remember_me"
                           type="checkbox"
                           name="remember"
                           class="h-4 w-4 rounded border-slate-300 text-[#0B2D6B] focus:ring-2 focus:ring-[#0B2D6B]/20">
                    <span class="text-xs font-semibold text-slate-600">Ingat sesi saya</span>
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="group relative mt-2 flex w-full items-center justify-center gap-2 rounded-xl bg-[#0B2D6B] px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition duration-150 hover:bg-[#09245a] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-200">
                <span>Masuk ke Dashboard</span>
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        {{-- Footer Link --}}
        <div class="mt-8 border-t border-slate-100 pt-6 text-center">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-[#0B2D6B] transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda Website
            </a>
        </div>
    </div>
</x-guest-layout>

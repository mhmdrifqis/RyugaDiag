<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">Selamat Datang!</h2>
        <p class="text-white/70 text-sm mt-1">Silakan masuk menggunakan akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-semibold text-xs text-white/90 uppercase tracking-wider mb-2">{{ __('Email') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-accent text-white/50">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-white/20 bg-black/20 text-white placeholder-white/40 focus:border-accent focus:ring focus:ring-accent/30 focus:bg-black/40 transition-all shadow-inner text-sm" placeholder="Masukkan alamat email">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 font-medium text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-semibold text-xs text-white/90 uppercase tracking-wider mb-2">{{ __('Password') }}</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-accent text-white/50">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-white/20 bg-black/20 text-white placeholder-white/40 focus:border-accent focus:ring focus:ring-accent/30 focus:bg-black/40 transition-all shadow-inner text-sm" placeholder="Masukkan password">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 font-medium text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-white/30 bg-black/30 text-accent focus:ring-accent focus:ring-offset-0 shadow-sm w-4 h-4 cursor-pointer transition-colors">
                <span class="ms-2 text-sm text-white/70 group-hover:text-white transition-colors">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-accent hover:text-white transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-accent hover:bg-accent-hover text-white rounded-xl font-bold transition-all duration-300 shadow-[0_4px_14px_0_rgba(39,174,96,0.39)] hover:shadow-[0_6px_20px_rgba(39,174,96,0.5)] hover:-translate-y-1">
                {{ __('Masuk Sekarang') }} <i class="fa-solid fa-arrow-right-to-bracket ml-1"></i>
            </button>
        </div>
    </form>
</x-guest-layout>

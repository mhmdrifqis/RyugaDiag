<x-app-layout>
    <x-slot name="header">
        Tambah Akun Teknisi
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form action="{{ route('admin.teknisi.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-text-main mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('name') border-danger @enderror"
                           placeholder="Cth: Budi Santoso">
                    @error('name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-text-main mb-1">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                               class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('username') border-danger @enderror"
                               placeholder="Cth: buditeknisi">
                        @error('username')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-text-main mb-1">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('email') border-danger @enderror"
                               placeholder="Cth: budi@ryugadiag.test">
                        @error('email')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-border">
                    <div>
                        <label for="password" class="block text-sm font-medium text-text-main mb-1">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('password') border-danger @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-text-main mb-1">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-border">
                    <a href="{{ route('admin.teknisi.index') }}">
                        <x-button variant="outline" type="button">Batal</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        <i class="fa-solid fa-save mr-2"></i> Simpan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>

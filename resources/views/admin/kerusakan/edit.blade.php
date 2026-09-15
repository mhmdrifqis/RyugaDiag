<x-app-layout>
    <x-slot name="header">
        Edit Data Kerusakan
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <x-card>
            <form action="{{ route('admin.kerusakan.update', $kerusakan->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode_kerusakan" class="block text-sm font-medium text-text-main mb-1">Kode Kerusakan <span class="text-danger">*</span></label>
                        <input type="text" name="kode_kerusakan" id="kode_kerusakan" value="{{ old('kode_kerusakan', $kerusakan->kode_kerusakan) }}" required
                               class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('kode_kerusakan') border-danger @enderror">
                        @error('kode_kerusakan')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_kerusakan" class="block text-sm font-medium text-text-main mb-1">Nama Kerusakan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kerusakan" id="nama_kerusakan" value="{{ old('nama_kerusakan', $kerusakan->nama_kerusakan) }}" required
                               class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('nama_kerusakan') border-danger @enderror">
                        @error('nama_kerusakan')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-text-main mb-1">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('deskripsi') border-danger @enderror">{{ old('deskripsi', $kerusakan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="solusi" class="block text-sm font-medium text-text-main mb-1">Solusi / Penanganan (Opsional)</label>
                    <textarea name="solusi" id="solusi" rows="4"
                              class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('solusi') border-danger @enderror">{{ old('solusi', $kerusakan->solusi) }}</textarea>
                    @error('solusi')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-border">
                    <a href="{{ route('admin.kerusakan.index') }}">
                        <x-button variant="outline" type="button">Batal</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        <i class="fa-solid fa-save mr-2"></i> Perbarui
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>

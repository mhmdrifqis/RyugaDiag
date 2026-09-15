<x-app-layout>
    <x-slot name="header">
        Edit Data Gejala
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form action="{{ route('admin.gejala.update', $gejala->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="kode_gejala" class="block text-sm font-medium text-text-main mb-1">Kode Gejala <span class="text-danger">*</span></label>
                    <input type="text" name="kode_gejala" id="kode_gejala" value="{{ old('kode_gejala', $gejala->kode_gejala) }}" required
                           class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('kode_gejala') border-danger @enderror">
                    @error('kode_gejala')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_gejala" class="block text-sm font-medium text-text-main mb-1">Nama Gejala <span class="text-danger">*</span></label>
                    <input type="text" name="nama_gejala" id="nama_gejala" value="{{ old('nama_gejala', $gejala->nama_gejala) }}" required
                           class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('nama_gejala') border-danger @enderror">
                    @error('nama_gejala')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-text-main mb-1">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-2 @error('deskripsi') border-danger @enderror">{{ old('deskripsi', $gejala->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-border">
                    <a href="{{ route('admin.gejala.index') }}">
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

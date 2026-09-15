<x-app-layout>
    <x-slot name="header">
        Edit Basis Pengetahuan
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-card>
            <form action="{{ route('admin.rule.update', $rule->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- THEN Section -->
                <div class="bg-red-50 p-6 rounded-xl border border-red-100">
                    <h3 class="text-lg font-bold text-danger mb-4 flex items-center">
                        <i class="fa-solid fa-car-burst mr-2"></i> THEN (Hasil Kerusakan)
                    </h3>
                    <div class="max-w-xl">
                        <label for="kerusakan_id" class="block text-sm font-medium text-text-main mb-2">Pilih Kerusakan yang Terjadi <span class="text-danger">*</span></label>
                        <select name="kerusakan_id" id="kerusakan_id" required
                                class="w-full rounded-xl border-border focus:ring-primary focus:border-primary px-4 py-3 bg-white">
                            <option value="">-- Pilih Kerusakan --</option>
                            @foreach($kerusakans as $kerusakan)
                                <option value="{{ $kerusakan->id }}" {{ old('kerusakan_id', $rule->kerusakan_id) == $kerusakan->id ? 'selected' : '' }}>
                                    {{ $kerusakan->kode_kerusakan }} - {{ $kerusakan->nama_kerusakan }}
                                </option>
                            @endforeach
                        </select>
                        @error('kerusakan_id')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- IF Section -->
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg font-bold text-primary mb-4 flex items-center">
                        <i class="fa-solid fa-list-check mr-2"></i> IF (Kombinasi Gejala)
                    </h3>
                    <p class="text-sm text-text-muted mb-4">Pilih satu atau lebih gejala yang menjadi syarat terjadinya kerusakan di atas.</p>
                    
                    @error('gejala_ids')
                        <p class="mb-4 text-sm font-bold text-danger">{{ $message }}</p>
                    @enderror

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[400px] overflow-y-auto p-2">
                        @foreach($gejalas as $gejala)
                            <label class="flex items-start p-3 bg-white rounded-lg border border-border cursor-pointer hover:border-primary transition-colors">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="gejala_ids[]" value="{{ $gejala->id }}" 
                                           class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary"
                                           {{ in_array($gejala->id, old('gejala_ids', $selectedGejalas)) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-bold text-primary">{{ $gejala->kode_gejala }}</span>
                                    <p class="text-text-main font-medium">{{ $gejala->nama_gejala }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-border">
                    <a href="{{ route('admin.rule.index') }}">
                        <x-button variant="outline" type="button">Batal</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        <i class="fa-solid fa-save mr-2"></i> Perbarui Rule
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>

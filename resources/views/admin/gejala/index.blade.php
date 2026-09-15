<x-app-layout>
    <x-slot name="header">
        Data Gejala
    </x-slot>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <x-card>
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <form action="{{ route('admin.gejala.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau nama..." 
                           class="w-full pl-10 pr-4 py-2 border border-border rounded-xl focus:ring-primary focus:border-primary">
                    <div class="absolute left-3 top-2.5 text-text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </form>
            
            <div class="flex flex-col sm:flex-row w-full md:w-auto gap-2" x-data="{ showImportModal: false }">
                <button @click="showImportModal = true" class="w-full sm:w-auto px-4 py-2 bg-white border border-border rounded-xl text-primary font-semibold hover:bg-gray-50 focus:outline-none transition-colors shadow-sm">
                    <i class="fa-solid fa-file-import mr-2"></i> Import Excel
                </button>
                <a href="{{ route('admin.gejala.create') }}" class="w-full sm:w-auto">
                    <x-button variant="primary" class="w-full">
                        <i class="fa-solid fa-plus mr-2"></i> Tambah Data
                    </x-button>
                </a>
                
                <!-- Import Modal -->
                <div x-show="showImportModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showImportModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-900/50 backdrop-blur-sm" aria-hidden="true" @click="showImportModal = false"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="showImportModal" x-transition.scale.origin.bottom class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full border border-green-200">
                                    <i class="fa-solid fa-file-excel text-green-600 text-xl"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-lg font-bold text-primary" id="modal-title">Import Data Gejala</h3>
                                    <div class="mt-2 text-sm text-text-muted text-left">
                                        <p>Unggah file Excel (.xlsx / .csv) Anda. Baris pertama wajib digunakan sebagai <strong>Header</strong>.</p>
                                        <ul class="list-disc pl-5 mt-2 font-mono text-xs text-primary space-y-1">
                                            <li>kode_gejala <span class="text-danger">*</span> (Wajib, cth: G01)</li>
                                            <li>nama_gejala <span class="text-danger">*</span> (Wajib)</li>
                                            <li>deskripsi (Opsional)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('admin.gejala.import') }}" method="POST" enctype="multipart/form-data" class="mt-5 sm:mt-6">
                                @csrf
                                <div class="mb-4">
                                    <input type="file" name="file" accept=".xlsx,.csv,.xls" required class="block w-full text-sm text-text-muted file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer transition-colors border border-dashed border-border rounded-xl p-2 focus:outline-none">
                                </div>
                                <div class="flex gap-2 justify-end mt-6">
                                    <button type="button" @click="showImportModal = false" class="px-4 py-2 bg-white border border-border rounded-xl text-text-muted font-semibold hover:bg-gray-50 focus:outline-none transition-colors">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-accent hover:bg-accent-hover text-white rounded-xl font-semibold transition-colors shadow-sm shadow-accent/30"><i class="fa-solid fa-upload mr-2"></i>Upload Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-border">
            <table class="w-full text-left text-sm text-text-main">
                <thead class="bg-bg-light text-text-muted uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4 border-b border-border w-16 text-center">No</th>
                        <th class="px-6 py-4 border-b border-border w-24 text-center">Kode</th>
                        <th class="px-6 py-4 border-b border-border">Nama Gejala</th>
                        <th class="px-6 py-4 border-b border-border">Deskripsi</th>
                        <th class="px-6 py-4 border-b border-border w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($gejalas as $index => $gejala)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $gejalas->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-semibold text-primary text-center">{{ $gejala->kode_gejala }}</td>
                            <td class="px-6 py-4">{{ $gejala->nama_gejala }}</td>
                            <td class="px-6 py-4 text-text-muted">{{ Str::limit($gejala->deskripsi, 50) ?: '-' }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.gejala.edit', $gejala->id) }}" class="text-accent hover:text-accent-hover mr-3" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                </a>
                                <form action="{{ route('admin.gejala.destroy', $gejala->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:text-red-700" title="Hapus">
                                        <i class="fa-solid fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-text-muted">
                                Tidak ada data gejala ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $gejalas->links() }}
        </div>
    </x-card>
</x-app-layout>

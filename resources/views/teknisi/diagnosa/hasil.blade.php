<x-app-layout>
    <x-slot name="header">
        Hasil Diagnosa
    </x-slot>

    <div class="w-full max-w-7xl mx-auto">
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-accent p-4 rounded-r-xl">
                <span class="block sm:inline text-accent font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kolom Gejala Terpilih -->
            <div class="lg:col-span-1">
                <x-card title="Gejala Terpilih">
                    <p class="text-xs text-text-muted mb-4 border-b border-border pb-2">Tanggal: {{ $diagnosa->tanggal_diagnosa->format('d M Y H:i') }}</p>
                    
                    <ul class="space-y-3">
                        @foreach($diagnosa->detailDiagnosas as $detail)
                            <li class="flex items-start gap-3 text-sm">
                                <i class="fa-solid fa-check text-accent mt-1"></i>
                                <div>
                                    <span class="font-bold text-primary">{{ $detail->gejala->kode_gejala }}</span>
                                    <p class="text-text-main">{{ $detail->gejala->nama_gejala }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            </div>

            <!-- Kolom Hasil -->
            <div class="lg:col-span-2">
                @if($diagnosa->kerusakan)
                    <!-- Ada Kerusakan Terdeteksi -->
                    <div class="bg-card-bg rounded-2xl p-8 shadow-[0_4px_15px_rgba(0,0,0,0.03)] border border-danger/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-danger/5 rounded-bl-full -z-10"></div>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-danger/10 flex items-center justify-center text-danger">
                                <i class="fa-solid fa-triangle-exclamation text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-danger uppercase tracking-wider">Kerusakan Terdeteksi</h2>
                                <h1 class="text-2xl font-bold text-text-main mt-1">{{ $diagnosa->kerusakan->nama_kerusakan }}</h1>
                            </div>
                        </div>

                        <div class="bg-bg-light rounded-xl p-5 mb-6 border border-border">
                            <h3 class="font-bold text-primary mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info"></i> Deskripsi
                            </h3>
                            <p class="text-text-muted text-sm leading-relaxed">
                                {{ $diagnosa->kerusakan->deskripsi ?: 'Tidak ada deskripsi spesifik.' }}
                            </p>
                        </div>

                        <div class="bg-[#e8f8f5] rounded-xl p-5 border border-accent/20">
                            <h3 class="font-bold text-accent mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-wrench"></i> Solusi / Penanganan
                            </h3>
                            <div class="text-text-main text-sm leading-relaxed">
                                {!! nl2br(e($diagnosa->kerusakan->solusi)) ?: 'Belum ada panduan solusi.' !!}
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Tidak Ada Kerusakan Terdeteksi -->
                    <div class="bg-card-bg rounded-2xl p-10 shadow-[0_4px_15px_rgba(0,0,0,0.03)] border border-border text-center">
                        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center text-text-muted mx-auto mb-6">
                            <i class="fa-solid fa-circle-question text-5xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-text-main mb-2">Kerusakan Tidak Ditemukan</h2>
                        <p class="text-text-muted max-w-md mx-auto">
                            Berdasarkan gejala-gejala yang dipilih, sistem tidak dapat menemukan pola kerusakan yang cocok di dalam Basis Pengetahuan.
                        </p>
                    </div>
                @endif
                
                <div class="mt-6 flex justify-end gap-3 print:hidden">
                    <button onclick="window.print()" class="px-5 py-2.5 bg-white border border-border hover:bg-gray-50 text-text-main rounded-xl font-bold transition-colors shadow-sm flex items-center">
                        <i class="fa-solid fa-print mr-2"></i> Cetak
                    </button>
                    <a href="{{ route('teknisi.riwayat.index') }}">
                        <x-button variant="outline">Lihat Riwayat</x-button>
                    </a>
                    <a href="{{ route('teknisi.diagnosa.create') }}">
                        <x-button variant="primary">
                            <i class="fa-solid fa-rotate-right mr-2"></i> Diagnosa Ulang
                        </x-button>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            @page { margin: 1cm; }
            body { background-color: white !important; color: black !important; }
            header, aside, .mobile-menu-overlay, nav { display: none !important; }
            .print\:hidden { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
            .shadow-[0_4px_15px_rgba(0,0,0,0.03)] { shadow: none !important; border: 1px solid #e2e8f0 !important; }
            .bg-card-bg { background-color: white !important; }
            
            /* Ensure layout stays somewhat structured in print */
            .grid { display: flex !important; flex-direction: row !important; gap: 2rem !important; }
            .lg\:col-span-1 { width: 35% !important; }
            .lg\:col-span-2 { width: 65% !important; }
        }
    </style>
</x-app-layout>

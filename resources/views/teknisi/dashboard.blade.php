<x-app-layout>
    <x-slot name="header">
        Dashboard Teknisi
    </x-slot>

    <!-- Hero Welcome -->
    <div class="mb-8 relative rounded-3xl overflow-hidden bg-gradient-to-r from-[#2c3e50] via-[#1a252f] to-[#2c3e50] p-8 md:p-10 text-white shadow-xl border border-primary/20 group">
        <!-- Abstract Pattern Background -->
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
        
        <div class="absolute -right-10 -bottom-10 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-1000">
            <i class="fa-solid fa-car-side text-[20rem]"></i>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center justify-between">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-block px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold uppercase tracking-wider border border-white/20 backdrop-blur-sm shadow-inner">
                        <i class="fa-solid fa-wrench mr-1"></i> Area Teknisi
                    </span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold mb-3 tracking-tight drop-shadow-md">Halo, {{ auth()->user()->name }}! 🛠️</h1>
                <p class="text-white/80 text-sm md:text-base leading-relaxed mb-8 font-medium">
                    Selamat datang di Sistem Pakar Diagnosis BMW Seri 3. Siap untuk mendiagnosis keluhan mobil pelanggan hari ini? Cukup pilih gejala yang terlihat, dan biarkan sistem memproses kerusakannya!
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('teknisi.diagnosa.create') }}">
                        <button class="bg-accent hover:bg-accent-hover text-white font-bold py-3.5 px-8 rounded-xl transition-all duration-300 shadow-[0_4px_14px_0_rgba(39,174,96,0.39)] hover:shadow-[0_6px_20px_rgba(39,174,96,0.5)] hover:-translate-y-1 flex items-center gap-3">
                            <i class="fa-solid fa-stethoscope"></i> Mulai Diagnosa Baru
                        </button>
                    </a>
                </div>
            </div>
            
            <div class="hidden md:flex w-48 h-48 bg-white/5 backdrop-blur-md rounded-full border border-white/10 items-center justify-center shadow-[0_0_40px_rgba(39,174,96,0.15)] relative">
                <!-- Rotating Ring -->
                <div class="absolute inset-0 rounded-full border-t-2 border-r-2 border-accent opacity-50 animate-spin" style="animation-duration: 4s;"></div>
                <div class="absolute inset-4 rounded-full border-b-2 border-l-2 border-white/30 opacity-30 animate-spin" style="animation-duration: 6s; animation-direction: reverse;"></div>
                
                <i class="fa-solid fa-car-burst text-6xl text-white/90 drop-shadow-lg transform -translate-y-1"></i>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-stat-card 
            title="Total Diagnosa Saya" 
            :value="$totalDiagnosa" 
            icon="fa-solid fa-file-medical" />
            
        <x-stat-card 
            title="Diagnosa Berhasil Ditemukan" 
            :value="$diagnosaSukses" 
            icon="fa-solid fa-check-double"
            class="text-accent" />
            
        <x-stat-card 
            title="Kerusakan Tak Dikenali" 
            :value="$diagnosaGagal" 
            icon="fa-solid fa-circle-question"
            class="text-warning" />
    </div>

    <!-- Recent History -->
    <div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-border">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 border-b border-border pb-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/5 flex items-center justify-center text-primary border border-primary/10 shadow-sm">
                    <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-primary">Riwayat Diagnosa Terakhir</h2>
                    <p class="text-sm text-text-muted mt-0.5">5 aktivitas diagnosis terakhir yang Anda lakukan.</p>
                </div>
            </div>
            <a href="{{ route('teknisi.riwayat.index') }}" class="text-sm font-bold text-accent hover:text-accent-hover hidden md:inline-flex items-center transition-colors">
                Lihat Semua Riwayat <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-border shadow-sm">
            <table class="w-full text-left text-sm text-text-main">
                <thead class="bg-bg-light text-text-muted uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 border-b border-border">Tanggal & Waktu</th>
                        <th class="px-6 py-4 border-b border-border">Hasil Analisis Sistem</th>
                        <th class="px-6 py-4 border-b border-border text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($riwayatTerbaru as $riwayat)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-text-muted font-medium">
                                <i class="fa-regular fa-calendar-days mr-2 opacity-50"></i>{{ $riwayat->tanggal_diagnosa->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 font-bold">
                                @if($riwayat->kerusakan)
                                    <span class="text-danger flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-danger animate-pulse"></div>
                                        {{ $riwayat->kerusakan->nama_kerusakan }}
                                    </span>
                                @else
                                    <span class="text-text-muted flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                        Tidak Terdeteksi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <a href="{{ route('teknisi.riwayat.show', $riwayat->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-primary/5 text-primary hover:bg-primary hover:text-white rounded-lg text-xs font-bold transition-colors">
                                    Detail <i class="fa-solid fa-arrow-right ml-2 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-text-muted">
                                <div class="w-16 h-16 bg-gray-50 rounded-2xl border border-border flex items-center justify-center mx-auto mb-4 text-3xl text-gray-300 shadow-inner">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <p class="font-bold text-gray-500">Anda belum melakukan diagnosa.</p>
                                <p class="text-xs mt-1">Mulai diagnosa mobil pertama Anda sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(count($riwayatTerbaru) > 0)
            <div class="mt-6 text-center md:hidden">
                <a href="{{ route('teknisi.riwayat.index') }}" class="text-sm font-bold text-primary hover:text-accent border border-border hover:border-accent px-6 py-3 rounded-xl inline-block w-full transition-colors">
                    Lihat Semua Riwayat
                </a>
            </div>
        @endif
    </div>
</x-app-layout>

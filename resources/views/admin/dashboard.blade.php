<x-app-layout>
    <x-slot name="header">
        Dashboard Administrator
    </x-slot>

    <!-- Welcome Hero Section -->
    <div class="mb-8 relative rounded-3xl overflow-hidden bg-gradient-to-br from-[#1a252f] to-[#2c3e50] p-8 md:p-10 text-white shadow-xl border border-primary/20">
        <!-- Decor Pattern -->
        <div class="absolute top-0 right-0 opacity-[0.03] pointer-events-none">
            <i class="fa-solid fa-microchip text-[16rem] -mr-16 -mt-16"></i>
        </div>
        
        <div class="relative z-10 max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-block px-3 py-1 bg-accent/20 text-accent rounded-full text-xs font-bold uppercase tracking-wider border border-accent/30 shadow-inner">
                    Modul Admin Master
                </span>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold mb-3 tracking-tight">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-white/70 text-sm md:text-base leading-relaxed mb-8 max-w-2xl font-medium">
                Dari area ini, Anda memegang kendali penuh atas data master dan otak dari mesin inferensi Forward Chaining. Kelola Gejala, Kerusakan, dan Basis Pengetahuan (Rule) agar diagnosa mobil BMW selalu akurat.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.rule.create') }}">
                    <button class="bg-accent hover:bg-accent-hover text-white font-bold py-3 px-6 rounded-xl transition-all shadow-[0_4px_14px_0_rgba(39,174,96,0.39)] hover:shadow-[0_6px_20px_rgba(39,174,96,0.23)] hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Tambah Aturan Baru
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Total Gejala" 
            :value="$totalGejala" 
            icon="fa-solid fa-list-check" />
            
        <x-stat-card 
            title="Total Kerusakan" 
            :value="$totalKerusakan" 
            icon="fa-solid fa-car-burst" />
            
        <x-stat-card 
            title="Rule Basis Pengetahuan" 
            :value="$totalRule" 
            icon="fa-solid fa-diagram-project" />
            
        <x-stat-card 
            title="Total Teknisi Aktif" 
            :value="$totalTeknisi" 
            icon="fa-solid fa-user-gear" />
    </div>

    <!-- Quick Guide Section -->
    <div class="bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] border border-border">
        <div class="flex items-center gap-3 mb-8 border-b border-border pb-4">
            <div class="w-12 h-12 rounded-xl bg-primary/5 flex items-center justify-center text-primary border border-primary/10">
                <i class="fa-solid fa-book-open text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-primary">Panduan Ringkas Sistem</h2>
                <p class="text-sm text-text-muted mt-0.5">Langkah-langkah membangun mesin inferensi pakar</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-text-muted shrink-0 font-extrabold mb-4 border border-border group-hover:bg-primary group-hover:text-white transition-colors">1</div>
                <h3 class="font-bold text-primary mb-2 text-lg">Input Data Gejala</h3>
                <p class="text-sm text-text-muted leading-relaxed">Kelola seluruh daftar kemungkinan gejala yang dapat diamati secara visual maupun fisik pada mobil BMW.</p>
            </div>
            
            <div class="group">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-text-muted shrink-0 font-extrabold mb-4 border border-border group-hover:bg-primary group-hover:text-white transition-colors">2</div>
                <h3 class="font-bold text-primary mb-2 text-lg">Input Data Kerusakan</h3>
                <p class="text-sm text-text-muted leading-relaxed">Daftarkan semua jenis kerusakan/penyakit yang mungkin terjadi beserta langkah penanganan/solusinya.</p>
            </div>

            <div class="group">
                <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-text-muted shrink-0 font-extrabold mb-4 border border-border group-hover:bg-accent group-hover:text-white transition-colors">3</div>
                <h3 class="font-bold text-accent mb-2 text-lg">Rakit Basis Pengetahuan</h3>
                <p class="text-sm text-text-muted leading-relaxed">Buat aturan (Rules) yang menghubungkan Gejala-gejala (IF) ke sebuah Kerusakan (THEN). Aturan inilah yang menjadi otak diagnosis cerdas.</p>
            </div>
        </div>
    </div>
</x-app-layout>

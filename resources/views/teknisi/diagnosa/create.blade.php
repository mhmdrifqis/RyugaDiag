<x-app-layout>
    <x-slot name="header">
        Mulai Diagnosa Baru
    </x-slot>

    <div class="w-full max-w-7xl mx-auto">
        <div class="mb-6 bg-blue-50 border-l-4 border-primary p-4 rounded-r-xl">
            <h3 class="text-primary font-bold mb-1">Instruksi:</h3>
            <p class="text-sm text-text-muted">Centang gejala-gejala yang dialami oleh mobil pelanggan. Pilih semua gejala yang relevan agar sistem dapat mendiagnosis kerusakan dengan akurat. Setelah selesai, klik tombol <strong>Proses Diagnosa</strong>.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-danger p-4 rounded-r-xl">
                <ul class="list-disc list-inside text-sm text-danger font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-card>
            <form action="{{ route('teknisi.diagnosa.proses') }}" method="POST">
                @csrf
                
                <div x-data="gejalaSelector()" class="relative mb-8" @click.away="isOpen = false">
                    <label class="block text-sm font-bold text-text-main mb-3">Pilih Gejala yang Dialami Pelanggan</label>
                    
                    <!-- Hidden inputs for form submission -->
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="gejala_ids[]" :value="id">
                    </template>

                    <!-- Selected Chips Container + Search Input -->
                    <div class="min-h-[3.5rem] p-2 bg-white border border-border rounded-xl focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all flex flex-wrap gap-2 items-center cursor-text shadow-sm hover:border-primary/50"
                         @click="$refs.searchInput.focus(); isOpen = true">
                         
                         <template x-for="gejala in selectedGejalas" :key="gejala.id">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary text-white text-sm font-medium rounded-lg shadow-sm">
                                <span x-text="gejala.kode_gejala" class="font-bold opacity-80 text-xs"></span>
                                <span x-text="gejala.nama_gejala"></span>
                                <button type="button" @click.stop="removeGejala(gejala.id)" class="ml-1 text-white/70 hover:text-white focus:outline-none transition-colors">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </span>
                         </template>

                         <input x-ref="searchInput" 
                                type="text" 
                                x-model="search"
                                @focus="isOpen = true"
                                @keydown.enter.prevent="if(filteredGejalas.length > 0) toggleGejala(filteredGejalas[0].id)"
                                @keydown.backspace="if(search === '' && selectedIds.length > 0) { removeGejala(selectedIds[selectedIds.length - 1]); }"
                                class="flex-1 min-w-[200px] bg-transparent border-none focus:ring-0 text-sm p-2 text-text-main placeholder-text-muted"
                                placeholder="Ketik kode atau nama gejala (Cth: G01 atau Mesin bergetar)...">
                    </div>

                    <!-- Dropdown Options -->
                    <div x-show="isOpen" 
                         x-transition.opacity.duration.200ms
                         class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-border max-h-72 overflow-y-auto"
                         style="display: none;">
                         
                         <template x-if="filteredGejalas.length === 0">
                             <div class="p-6 text-center text-sm text-text-muted flex flex-col items-center justify-center">
                                 <i class="fa-solid fa-magnifying-glass text-2xl text-gray-300 mb-2"></i>
                                 Tidak ada gejala yang cocok.
                             </div>
                         </template>

                         <ul class="py-2">
                             <template x-for="gejala in filteredGejalas" :key="gejala.id">
                                 <li @click="toggleGejala(gejala.id)"
                                     class="px-5 py-3 hover:bg-primary/5 cursor-pointer flex flex-col transition-colors border-b border-border/50 last:border-0 group">
                                     <div class="flex items-center gap-3">
                                         <span class="inline-block px-2 py-1 bg-gray-100 group-hover:bg-primary/10 text-text-muted group-hover:text-primary text-xs font-bold rounded-md transition-colors" x-text="gejala.kode_gejala"></span>
                                         <span class="text-sm font-semibold text-text-main group-hover:text-primary transition-colors" x-text="gejala.nama_gejala"></span>
                                     </div>
                                     <p x-show="gejala.deskripsi" class="text-xs text-text-muted mt-1.5 leading-relaxed" x-text="gejala.deskripsi"></p>
                                 </li>
                             </template>
                         </ul>
                    </div>
                </div>

                <!-- AlpineJS Component Logic -->
                <script>
                    document.addEventListener('alpine:init', () => {
                        Alpine.data('gejalaSelector', () => ({
                            search: '',
                            isOpen: false,
                            allGejalas: @json($gejalas),
                            selectedIds: @json(old('gejala_ids', [])).map(String),
                            
                            get filteredGejalas() {
                                if (this.search.trim() === '') {
                                    return this.allGejalas.filter(g => !this.selectedIds.includes(String(g.id)));
                                }
                                const lowerSearch = this.search.toLowerCase();
                                return this.allGejalas.filter(g => {
                                    return !this.selectedIds.includes(String(g.id)) && 
                                           (g.kode_gejala.toLowerCase().includes(lowerSearch) || 
                                            g.nama_gejala.toLowerCase().includes(lowerSearch));
                                });
                            },
                            get selectedGejalas() {
                                return this.selectedIds.map(id => this.allGejalas.find(g => String(g.id) === String(id))).filter(g => g);
                            },
                            toggleGejala(id) {
                                const strId = String(id);
                                if (this.selectedIds.includes(strId)) {
                                    this.selectedIds = this.selectedIds.filter(i => i !== strId);
                                } else {
                                    this.selectedIds.push(strId);
                                }
                                this.search = '';
                                this.$refs.searchInput.focus();
                            },
                            removeGejala(id) {
                                this.selectedIds = this.selectedIds.filter(i => i !== String(id));
                            }
                        }));
                    });
                </script>

                <div class="mt-8 flex justify-end pt-5 border-t border-border">
                    <x-button variant="primary" type="submit" class="w-full md:w-auto text-lg px-8 py-4">
                        <i class="fa-solid fa-stethoscope mr-2"></i> Proses Diagnosa
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>

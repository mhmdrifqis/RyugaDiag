<aside :class="[
            mobileMenuOpen ? 'translate-x-0' : '-translate-x-full',
            sidebarCollapsed ? 'md:w-[85px]' : 'md:w-[260px]'
       ]"
       class="fixed inset-y-0 left-0 z-50 transform transition-all duration-300 ease-in-out md:translate-x-0 md:static md:flex md:flex-col h-full shadow-[4px_0_24px_rgba(0,0,0,0.05)] overflow-hidden group">
    
    <!-- Dark Glassmorphism Background with Image Overlay -->
    <div class="absolute inset-0 z-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
    <div class="absolute inset-0 z-0 bg-[#1a252f]/90 backdrop-blur-md"></div>
    <!-- ------------------------------------------------ -->

    <!-- Sidebar Content Wrapper (relative z-10) -->
    <div class="relative z-10 flex flex-col h-full w-full">
        <!-- Logo -->
        <div class="h-20 flex items-center justify-center border-b border-white/10 px-4 transition-all duration-300">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full" :class="sidebarCollapsed ? 'justify-center' : ''">
                <img src="{{ asset('image/ryugadiag_logo.jpg') }}" alt="RyugaDiag Logo" class="w-10 h-10 rounded-xl shadow-lg shrink-0 border border-white/20 object-cover">
                <span class="text-xl font-bold text-white tracking-wide whitespace-nowrap drop-shadow-md" x-show="!sidebarCollapsed" x-transition.opacity.duration.300ms>RyugaDiag</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto overflow-x-hidden py-6 space-y-2" :class="sidebarCollapsed ? 'px-2' : 'px-4'">
            @if(auth()->user()->role === 'admin')
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')" :collapsed="true">
                    <i class="fa-solid fa-house w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Dashboard</span>
                </x-nav-link>

                <div class="pt-4 pb-2 transition-all duration-300" :class="sidebarCollapsed ? 'px-0 text-center' : 'px-4'">
                    <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest" x-show="!sidebarCollapsed">Data Master</p>
                    <div x-show="sidebarCollapsed" class="w-full h-px bg-white/10"></div>
                </div>

                <x-nav-link :href="route('admin.gejala.index')" :active="request()->routeIs('admin.gejala.*')" :collapsed="true">
                    <i class="fa-solid fa-list-check w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Data Gejala</span>
                </x-nav-link>

                <x-nav-link :href="route('admin.kerusakan.index')" :active="request()->routeIs('admin.kerusakan.*')" :collapsed="true">
                    <i class="fa-solid fa-car-burst w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Data Kerusakan</span>
                </x-nav-link>

                <x-nav-link :href="route('admin.rule.index')" :active="request()->routeIs('admin.rule.*')" :collapsed="true">
                    <i class="fa-solid fa-diagram-project w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Basis Pengetahuan</span>
                </x-nav-link>

                <div class="pt-4 pb-2 transition-all duration-300" :class="sidebarCollapsed ? 'px-0 text-center' : 'px-4'">
                    <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest" x-show="!sidebarCollapsed">Pengguna</p>
                    <div x-show="sidebarCollapsed" class="w-full h-px bg-white/10"></div>
                </div>

                <x-nav-link :href="route('admin.teknisi.index')" :active="request()->routeIs('admin.teknisi.*')" :collapsed="true">
                    <i class="fa-solid fa-user-gear w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Data Teknisi</span>
                </x-nav-link>
            @else
                <!-- Teknisi Menu -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('teknisi.dashboard')" :collapsed="true">
                    <i class="fa-solid fa-house w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Dashboard</span>
                </x-nav-link>

                <x-nav-link :href="route('teknisi.diagnosa.create')" :active="request()->routeIs('teknisi.diagnosa.*')" :collapsed="true">
                    <i class="fa-solid fa-stethoscope w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Mulai Diagnosa</span>
                </x-nav-link>

                <x-nav-link :href="route('teknisi.riwayat.index')" :active="request()->routeIs('teknisi.riwayat.*')" :collapsed="true">
                    <i class="fa-solid fa-clock-rotate-left w-6 text-center text-lg transition-colors" :class="sidebarCollapsed ? 'mr-0' : 'mr-3'"></i>
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity duration-300">Riwayat Diagnosa</span>
                </x-nav-link>
            @endif
        </nav>

        <!-- User Profile & Logout -->
        <div class="p-4 border-t border-white/10 mt-auto transition-all duration-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center p-3 rounded-xl hover:bg-white/10 transition-colors group cursor-pointer border border-transparent hover:border-white/20 overflow-hidden backdrop-blur-sm" :class="sidebarCollapsed ? 'justify-center' : ''">
                    <div class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white group-hover:bg-red-500/20 group-hover:border-red-500/50 group-hover:text-red-400 transition-colors shrink-0">
                        <span class="font-bold text-sm" x-show="sidebarCollapsed" title="Logout"><i class="fa-solid fa-power-off"></i></span>
                        <span class="font-bold text-sm" x-show="!sidebarCollapsed">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3 flex-1 text-left whitespace-nowrap" x-show="!sidebarCollapsed">
                        <p class="text-sm font-semibold text-white group-hover:text-red-300 transition-colors truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-white/50 uppercase tracking-widest font-bold truncate">{{ auth()->user()->role }}</p>
                    </div>
                    <i class="fa-solid fa-arrow-right-from-bracket text-white/30 group-hover:text-red-400 transition-colors shrink-0" x-show="!sidebarCollapsed"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

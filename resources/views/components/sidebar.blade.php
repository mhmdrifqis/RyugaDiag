<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-[260px] bg-sidebar-bg border-r border-border transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:flex md:flex-col h-full shadow-sm">
    
    <!-- Logo -->
    <div class="h-20 flex items-center justify-center border-b border-border">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-md">
                <i class="fa-solid fa-car-wrench text-white text-xl"></i>
            </div>
            <span class="text-xl font-bold text-primary tracking-wide">RyugaDiag</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        @if(auth()->user()->role === 'admin')
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-house w-6 text-center mr-3 text-lg transition-colors"></i>
                Dashboard
            </x-nav-link>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Data Master</p>
            </div>

            <x-nav-link href="#" :active="request()->routeIs('admin.gejala.*')">
                <i class="fa-solid fa-list-check w-6 text-center mr-3 text-lg transition-colors"></i>
                Data Gejala
            </x-nav-link>

            <x-nav-link href="#" :active="request()->routeIs('admin.kerusakan.*')">
                <i class="fa-solid fa-car-burst w-6 text-center mr-3 text-lg transition-colors"></i>
                Data Kerusakan
            </x-nav-link>

            <x-nav-link href="#" :active="request()->routeIs('admin.rule.*')">
                <i class="fa-solid fa-diagram-project w-6 text-center mr-3 text-lg transition-colors"></i>
                Basis Pengetahuan
            </x-nav-link>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-text-muted uppercase tracking-wider">Pengguna</p>
            </div>

            <x-nav-link href="#" :active="request()->routeIs('admin.teknisi.*')">
                <i class="fa-solid fa-user-gear w-6 text-center mr-3 text-lg transition-colors"></i>
                Data Teknisi
            </x-nav-link>
        @else
            <!-- Teknisi Menu -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-house w-6 text-center mr-3 text-lg transition-colors"></i>
                Dashboard
            </x-nav-link>

            <x-nav-link href="#" :active="request()->routeIs('teknisi.diagnosa.*')">
                <i class="fa-solid fa-stethoscope w-6 text-center mr-3 text-lg transition-colors"></i>
                Mulai Diagnosa
            </x-nav-link>

            <x-nav-link href="#" :active="request()->routeIs('teknisi.riwayat.*')">
                <i class="fa-solid fa-clock-rotate-left w-6 text-center mr-3 text-lg transition-colors"></i>
                Riwayat Diagnosa
            </x-nav-link>
        @endif
    </nav>

    <!-- User Profile & Logout -->
    <div class="p-4 border-t border-border mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 rounded-xl hover:bg-red-50 transition-colors group cursor-pointer border border-transparent hover:border-red-100">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-red-100 group-hover:text-danger transition-colors">
                    <span class="font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="ml-3 flex-1 text-left">
                    <p class="text-sm font-semibold text-primary group-hover:text-danger">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-text-muted capitalize">{{ auth()->user()->role }}</p>
                </div>
                <i class="fa-solid fa-arrow-right-from-bracket text-text-muted group-hover:text-danger transition-colors"></i>
            </button>
        </form>
    </div>
</aside>

@props(['title', 'value', 'icon', 'subtitle' => null, 'highlight' => false])

<div class="group relative overflow-hidden bg-{{ $highlight ? 'primary' : 'card-bg' }} rounded-2xl p-6 shadow-[0_4px_15px_rgba(0,0,0,0.03)] border border-black/5 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
    <!-- Background Decor -->
    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-gradient-to-br from-primary/5 to-transparent group-hover:scale-[2] transition-transform duration-700 pointer-events-none"></div>
    
    <!-- Icon Container -->
    <div class="relative w-16 h-16 rounded-2xl flex items-center justify-center {{ $highlight ? 'bg-white/15 text-white shadow-inner border border-white/10' : 'bg-gradient-to-br from-primary/10 to-primary/5 text-primary border border-primary/10' }} group-hover:scale-110 transition-transform duration-300 shadow-sm">
        <i class="{{ $icon }} text-2xl drop-shadow-sm"></i>
    </div>
    
    <!-- Content -->
    <div class="relative z-10">
        <h3 class="text-xs font-bold tracking-wider uppercase {{ $highlight ? 'text-white/80' : 'text-text-muted' }} mb-1">{{ $title }}</h3>
        <p class="text-3xl font-extrabold {{ $highlight ? 'text-white' : 'text-primary' }} drop-shadow-sm">{{ $value }}</p>
        @if($subtitle)
            <p class="text-xs mt-1 {{ $highlight ? 'text-white/60' : 'text-text-muted' }} font-medium">{{ $subtitle }}</p>
        @endif
    </div>
</div>

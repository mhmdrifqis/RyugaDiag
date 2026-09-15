@props(['active', 'collapsed' => false])

@php
// The outer <a> tags use Alpine logic for classes so we do this dynamically where we can.
$activeClasses = 'bg-white/10 shadow-sm text-white font-bold border border-white/20 backdrop-blur-sm';
$inactiveClasses = 'text-white/60 font-medium hover:bg-white/5 hover:text-white border border-transparent';

$iconActive = 'text-accent drop-shadow-md scale-110';
$iconInactive = 'text-white/50 group-hover:text-white transition-colors';
@endphp

<a {{ $attributes->merge(['class' => 'flex items-center py-3 rounded-xl transition-all duration-200 group mx-2 overflow-hidden ' . (($active ?? false) ? $activeClasses : $inactiveClasses)]) }}
   :class="sidebarCollapsed ? 'justify-center px-0' : 'px-4'">
    
    <div class="flex items-center w-full {{ ($active ?? false) ? $iconActive : $iconInactive }}" :class="sidebarCollapsed ? 'justify-center' : ''">
        {{ $slot }}
    </div>
</a>

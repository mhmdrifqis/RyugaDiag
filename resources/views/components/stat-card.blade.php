@props(['title', 'value', 'icon', 'subtitle' => null, 'highlight' => false])

<div class="bg-{{ $highlight ? 'primary' : 'card-bg' }} rounded-2xl p-6 shadow-[0_4px_15px_rgba(0,0,0,0.03)] border border-black/5 flex items-center gap-5">
    <div class="w-14 h-14 rounded-full flex items-center justify-center {{ $highlight ? 'bg-white/10 text-white' : 'bg-primary/5 text-primary' }}">
        <i class="{{ $icon }} text-2xl"></i>
    </div>
    <div>
        <h3 class="text-sm font-medium {{ $highlight ? 'text-white/70' : 'text-text-muted' }}">{{ $title }}</h3>
        <p class="text-2xl font-bold {{ $highlight ? 'text-white' : 'text-primary' }} mt-1">{{ $value }}</p>
        @if($subtitle)
            <p class="text-xs mt-1 {{ $highlight ? 'text-white/50' : 'text-text-muted' }}">{{ $subtitle }}</p>
        @endif
    </div>
</div>

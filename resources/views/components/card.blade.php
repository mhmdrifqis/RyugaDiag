<div {{ $attributes->merge(['class' => 'bg-card-bg rounded-2xl p-6 shadow-[0_4px_15px_rgba(0,0,0,0.03)] border border-black/5 mb-5']) }}>
    @isset($title)
        <h2 class="text-base font-semibold text-primary mb-4">{{ $title }}</h2>
    @endisset
    {{ $slot }}
</div>

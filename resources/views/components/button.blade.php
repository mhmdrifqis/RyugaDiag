@props(['variant' => 'primary', 'type' => 'button'])

@php
    $baseClasses = 'inline-flex items-center justify-center px-5 py-3 border border-transparent rounded-xl font-semibold text-sm tracking-wide transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-primary text-white hover:bg-[#1a252f] focus:ring-primary shadow-md hover:shadow-lg',
        'success' => 'bg-accent text-white hover:bg-accent-hover focus:ring-accent shadow-md hover:shadow-lg',
        'danger' => 'bg-danger text-white hover:bg-red-600 focus:ring-danger shadow-md hover:shadow-lg',
        'outline' => 'bg-transparent text-text-main border-border hover:bg-gray-50 focus:ring-gray-200',
        default => 'bg-primary text-white hover:bg-primary/90'
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses]) }}>
    {{ $slot }}
</button>

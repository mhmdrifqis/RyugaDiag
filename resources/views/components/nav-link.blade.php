@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 mx-2 rounded-xl bg-white shadow-sm text-primary font-bold border border-gray-100 transition-all duration-200'
            : 'flex items-center px-4 py-3 mx-2 rounded-xl text-text-muted font-medium hover:bg-gray-100 hover:text-primary transition-all duration-200';
            
$iconClasses = ($active ?? false)
            ? 'text-accent'
            : 'text-text-muted group-hover:text-primary';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' group']) }}>
    <!-- We inject the active state into the icon dynamically if possible, or just let the icon inherit color if we don't have direct access. -->
    <div class="flex items-center w-full {{ $iconClasses }}">
        {{ $slot }}
    </div>
</a>

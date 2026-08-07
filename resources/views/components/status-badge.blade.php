@props(['status'])

@php
    $classes = match($status) {
        'done', 'success' => 'bg-[#e8f8f5] text-accent',
        'warning' => 'bg-warning/10 text-warning',
        'danger', 'error' => 'bg-danger/10 text-danger',
        default => 'bg-gray-100 text-gray-600'
    };
@endphp

<span class="px-3 py-1 text-xs font-semibold rounded-full inline-block {{ $classes }}">
    {{ $slot }}
</span>

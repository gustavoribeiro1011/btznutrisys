@props(['icon', 'title', 'value', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-50 text-blue-500 text-blue-600 text-blue-900',
        'green' => 'bg-green-50 text-green-500 text-green-600 text-green-900',
        'yellow' => 'bg-yellow-50 text-yellow-500 text-yellow-600 text-yellow-900',
        'red' => 'bg-red-50 text-red-500 text-red-600 text-red-900',
    ];
    $classes = $colors[$color] ?? $colors['blue'];
@endphp

<div class="p-4 rounded-lg {{ explode(' ', $classes)[0] }}">
    <div class="flex items-center">
        <i class="{{ $icon }} {{ explode(' ', $classes)[1] }} text-xl mr-3"></i>
        <div>
        <p class="text-sm font-medium {{ explode(' ', $classes)[2] }}">{{ $title }}</p>
            <p class="text-lg font-bold {{ explode(' ', $classes)[3] }}">{{ $value }}</p>
        </div>
    </div>
</div>

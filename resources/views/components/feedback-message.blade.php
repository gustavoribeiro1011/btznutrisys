@props([
    'type' => 'success', // success, error, warning, info
    'message' => '',
])

@php
    $base = 'p-4 rounded-lg flex items-start gap-2 text-sm';
    $types = [
        'success' => 'bg-green-50 text-green-800 border border-green-200',
        'error' => 'bg-red-50 text-red-800 border border-red-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border border-yellow-200',
        'info' => 'bg-blue-50 text-blue-800 border border-blue-200',
    ];
    $icons = [
        'success' => 'fas fa-check-circle',
        'error' => 'fas fa-times-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'info' => 'fas fa-info-circle',
    ];
@endphp

<div class="{{ $base }} {{ $types[$type] }}">
    <i class="{{ $icons[$type] }} mt-0.5"></i>
    <div>{{ $message }}</div>
</div>

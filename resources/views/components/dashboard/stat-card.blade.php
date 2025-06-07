@php
    $iconStyle = str_starts_with($iconColor, '#') ? "style=color:{$iconColor};" : '';
    $iconColorClass = !str_starts_with($iconColor, '#') ? $iconColor : '';
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg h-full">
    <div class="p-4 sm:p-5 lg:p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i class="{{ $icon }} text-xl sm:text-2xl {{ $iconColorClass }}" {!! $iconStyle !!}></i>
            </div>
            <div class="ml-3 sm:ml-4 lg:ml-5 w-0 flex-1 min-w-0">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd class="text-base sm:text-lg lg:text-xl font-medium text-gray-900 truncate">{{ $value }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

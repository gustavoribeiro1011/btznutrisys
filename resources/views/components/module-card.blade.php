<a href="{{ $href }}"
   class="block bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i class="{{ $icon }} text-2xl {{ $iconColor }}"></i>
        </div>
        <div class="ml-4">
            <h4 class="text-sm font-medium text-gray-900">{{ $title }}</h4>
            <p class="text-xs text-gray-500">{{ $description }}</p>
        </div>
    </div>
</a>

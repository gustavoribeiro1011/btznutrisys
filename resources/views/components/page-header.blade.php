@props([
    'title',
    'description' => null,
    'buttonUrl' => null,
    'buttonText' => null,
    'buttonIcon' => null,
    'buttonBackUrl' => null,
])
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-gray-600">{{ $description }}</p>
        @endif
    </div>

    @if ($buttonUrl && $buttonText)
        <a href="{{ $buttonUrl }}"
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:bg-blue-700"
           style="background-color: #003977;">
            @if ($buttonIcon)
                <i class="{{ $buttonIcon }} mr-2"></i>
            @endif
            {{ $buttonText }}
        </a>
    @endif

    @if ($buttonBackUrl && $buttonText)
        <a href="{{ $buttonBackUrl }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ $buttonText }}
        </a>
    @endif

</div>

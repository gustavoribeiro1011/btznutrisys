@props(['for' => '', 'label' => '', 'theme' => 'default'])

@switch($theme)
    @case('secondary')
        <label for="{{ $for }}"
               class="block text-base font-medium text-gray-500 pb-2">
            {{ $label }}
            {{ $slot }}
        </label>
    @break

    @default
        <label for="{{ $for }}"
               class="block text-sm font-medium text-gray-700">
            {{ $label }}
            {{ $slot }}
        </label>
@endswitch

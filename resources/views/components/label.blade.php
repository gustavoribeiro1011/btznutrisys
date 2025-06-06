@props(['for' => '', 'label' => '', 'theme' => 'default'])

@switch($theme)
    @case('secondary')
        <label for="{{ $for }}"
               class="block text-base font-medium text-gray-500 dark:text-gray-300 pb-2">
            {{ $label }}
            {{ $slot }}
        </label>
    @break

    @default
        <label for="{{ $for }}"
               class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
            {{ $slot }}
        </label>
@endswitch

@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'value' => '',
    'class' => '',
    'wireModel' => null,
    'width' => 'full',
    'required' => false,
])

<div class="mb-4">
    <!-- Componente Label -->
    @if ($label)
        <x-label :for="$name"
                 :label="$label" />
    @endif

    <!-- Componente Select -->
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        @if($wireModel) wire:model="{{ $wireModel }}" @endif
        @if($required) required @endif
        class="w-{{ $width }} px-3 py-2 border border-gray-300  focus:ring focus:ring-blue-200 focus:border-blue-500  rounded-md shadow-sm {{ $class }}">

        {{ $slot }}

    </select>
</div>

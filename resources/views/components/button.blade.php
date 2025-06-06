@props([
    'type' => 'button',
    'theme' => 'primary', //primary, secondary, transparent, transparent-no-border, success, danger
    'fullWidth' => false,
    'py' => '4',
    'px' => '2',
    'mr' => '0',
    'ml' => '0',
    'mt' => '0',
    'mb' => '0',
    'pl' => '0',
    'pr' => '0',
    'rounded' => '',
    'size' => 'base',
    'disabled' => false,
    'animation' => '', // Ex. spinner
    'align' => 'center',
    'fontWeight' => 'font-normal',
    'noHover' => false,
    'onClick' => '', //onclick normal (nativo do botão)
    'alpineClick' => '', //onclick do AlpineJS - Ex: open=true;
    'wireClick' => '', //onclick do Livewire - Ex: openModal
    'eventStopProcessing' => '', //event-[nome-do-evento] ***Coloque o prefixo "event-"***
    'eventClick' => null, //Pode ser utilizado para abrir um modal, por exemplo
    'tippy' => '', //Exibir dica usando o Tippy.js
])


@switch($theme)
    @case('primary')
        @php
            $themeClasses =
                'text-white bg-blue-500' .
                (!$noHover ? ' hover:bg-blue-600 dark:hover:bg-blue-800' : '') .
                ' dark:bg-blue-700';
        @endphp
    @break

    @case('secondary')
        @php
            $themeClasses =
                'text-gray-700 bg-gray-200' .
                (!$noHover ? ' hover:bg-gray-300 dark:hover:bg-gray-700' : '') .
                ' dark:bg-gray-800 dark:text-gray-300';
        @endphp
    @break

    @case('transparent')
        @php
            $themeClasses =
                'text-gray-700 bg-transparent border border-gray-700' .
                (!$noHover ? ' hover:bg-gray-200 dark:hover:bg-gray-700' : '') .
                ' dark:text-gray-300';
        @endphp
    @break

    @case('outline-transparent')
        @php
            $themeClasses =
                'text-gray-700 bg-transparent' .
                (!$noHover ? ' hover:bg-gray-200 dark:hover:bg-gray-700' : '') .
                ' dark:text-gray-300';
        @endphp
    @break

    @case('outline-danger')
        @php
            $themeClasses =
                'text-red-500 bg-transparent border border-red-500' .
                (!$noHover ? ' hover:bg-red-500 dark:hover:bg-red-700 hover:text-white' : '');
        @endphp
    @break

    @case('outline-primary')
        @php
            $themeClasses =
                'text-blue-500 bg-transparent border border-blue-500' .
                (!$noHover ? ' hover:bg-blue-500 dark:hover:bg-blue-700 hover:text-white' : '');
        @endphp
    @break

    @case('success')
        @php
            $themeClasses =
                'text-white bg-green-500' .
                (!$noHover ? ' hover:bg-green-600 dark:hover:bg-green-800' : '') .
                ' dark:bg-green-700';
        @endphp
    @break

    @case('danger')
        @php
            $themeClasses =
                'text-white bg-red-500' .
                (!$noHover ? ' hover:bg-red-600 dark:hover:bg-red-800' : '') .
                ' dark:bg-red-700';
        @endphp
    @break

@endswitch



@if ($fullWidth)
    @php
        $fullWidth = 'w-full';
    @endphp
@endif

@if (Str::startsWith($eventStopProcessing, 'event-'))
    @php
        // Verifica se a variável começa com "event" e remove essa parte
        $eventStopProcessing = Str::replaceFirst('event-', '', $eventStopProcessing);
    @endphp
@endif

@php
    $rounded = match ($rounded) {
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'base' => 'rounded',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        default => 'rounded',
    };
@endphp


@php
    $disabledClasses = $disabled ? 'cursor: not-allowed; opacity: 0.5;' : '';

    $justifyClass = match ($align) {
        'left', 'start' => 'justify-start',
        'right', 'end' => 'justify-end',
        default => 'justify-center',
    };
@endphp

<button x-data="{ showSpinner: false }"
        @event-{{ $eventStopProcessing }}.window="showSpinner = false"
        x-bind:class="{ 'cursor-not-allowed opacity-50': showSpinner }"
        @if ($animation === 'spinner') x-on:click="showSpinner = true" @endif
        class="flex items-center {{ $justifyClass }} {{ $themeClasses }} {{ $fullWidth }}
               px-{{ $px }} py-{{ $py }} ml-{{ $ml }}
               @if (!$px) pl-{{ $pl }} pr-{{ $pr }} @endif
                mt-{{ $mt }} mb-{{ $mb }}
              {{ $rounded }} text-{{ $size }} font-{{ $fontWeight }}
               transition ease-in-out duration-300 group"
        type="{{ $type }}"
        wire:click="{{ !$disabled ? $wireClick : '' }}"
        @if ($alpineClick) @click="{{ $alpineClick }}" @endif
        @if ($onClick) onclick="{{ $onClick }}" @endif
        @if ($eventClick) onclick="document.dispatchEvent(new Event('{{ $eventClick }}'));" @endif
        @if ($disabled) disabled @endif
        @if ($tippy) data-tippy-content="{{ $tippy }}" @endif
        style="margin-right:{{ $mr }}rem; {{ $disabledClasses }}">

    <!-- Usa o componente de spinner -->
    <x-icon-spinner x-show="showSpinner" x-cloak
                    :style="'margin-right:5px;'" />

    <!-- Conteúdo do botão (texto) -->
    {{ $slot }}
</button>

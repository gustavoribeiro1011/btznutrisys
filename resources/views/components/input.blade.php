@props([
    'id' => '',
    'name' => Str::random(10),
    'value' => '',
    'placeholder' => '',
    'class' => '',
    'wireModel' => '',
    'wireModelDefer' => false,
    'wireModelLazy' => false,
    'wireIgnore' => false,
    'type' => 'text',
    'addon' => null, // Define o texto do input group
    'addonPosition' => 'start', // Define a posição do addon ('start' ou 'end')
    'autocomplete' => 'on',
    'onInputEvent' => null, // Define o evento a ser disparado ao digitar
    'alpineClick' => null,
    'alpineFocus' => null,
    'alpineClickOutside' => null,
    'alpineClickAway' => null,
    'alpineModel' => null,
    'alpineOnInputEvent' => null,
    'dataInputId' => null,
    'noSpaces' => false, // Nova propriedade para impedir espaços em branco
    'required' => false,
    'hideError' => false, // Nova propriedade para ocultar erros
])

<div class="flex items-stretch mt-1">
    @if ($addon && $addonPosition === 'start')
        <span class="flex items-center px-3 bg-gray-200 border border-gray-300 rounded-l-md text-gray-500">
            {{ $addon }}
        </span>
    @endif

    <input type="{{ $type }}"
           id="{{ $id }}"
           name="{{ $name }}"
           value="{!! old($name, default: $value ?? '') !!}"
           placeholder="{{ $placeholder ?? '' }}"
           @if ($autocomplete === 'off') autocomplete="{{ $type === 'password' ? 'new-password' : 'off' }}" @endif
           class="p-2 w-full border bg-white border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500    placeholder-gray-500 rounded-md @if ($addon && $addonPosition === 'start') rounded-l-none @elseif($addon && $addonPosition === 'end') rounded-r-none @endif @error($name) border-red-500 focus:border-red-500 focus:ring-red-500 @enderror {{ $class }}"
           @if ($wireModel) wire:model.debounce.500ms="{{ $wireModel }}" @endif
           @if ($wireModelDefer) wire:model.defer="{{ $wireModel }}" @endif
           @if ($wireModelLazy) wire:model.lazy="{{ $wireModel }}" @endif
           @if ($wireIgnore) wire:ignore @endif
           @if ($onInputEvent) oninput="{{ $onInputEvent }}" @endif
           @if ($alpineModel) x-model="{{ $alpineModel }}" @endif
           @if ($alpineOnInputEvent) x-on:input="{{ $alpineOnInputEvent }}" @endif
           @if ($alpineFocus) x-on:focus="{{ $alpineFocus }}" @endif
           @if ($alpineClickOutside) x-on:click.outside="{{ $alpineClickOutside }}" @endif
           @if ($alpineClick) x-on:click="{{ $alpineClick }}" @endif
           @if ($alpineClickAway) x-on:click.away="{{ $alpineClickAway }}" @endif
           @if ($dataInputId) data-input-id="{{ $dataInputId }}" @endif
           @if ($noSpaces) x-on:keydown="if($event.key === ' ') { $event.preventDefault(); return false; }"
              x-on:input="$el.value = $el.value.replace(/\s+/g, '')"
              x-on:paste.prevent="
                let clipboardData = $event.clipboardData || window.clipboardData;
                let pastedText = clipboardData.getData('text').replace(/\s+/g, '');
                $el.value = $el.value + pastedText;

                if ('{{ $alpineModel }}') {
                    {{ $alpineModel }} = $el.value;
                }

                @if ($alpineOnInputEvent)
                    {{ $alpineOnInputEvent }}; @endif
           @if ($wireModel) // Disparar evento para atualizar o modelo Livewire
                    const event = new Event('input', { bubbles: true });
                    $el.dispatchEvent(event);

                    // Para garantir que o Livewire captou a alteração
                    setTimeout(() => {
                        const changeEvent = new Event('change', { bubbles: true });
                        $el.dispatchEvent(changeEvent);
                    }, 100); @endif "


           @endif
    @if ($required) required @endif
    />

    @if ($addon && $addonPosition === 'end')
        <span class="flex items-center px-3 bg-gray-200 border border-gray-300 rounded-r-md text-gray-500">
            {{ $addon }}
        </span>
    @endif
</div>

@unless (isset($hideError) && $hideError)
    @if ($errors->has($name))
        <p class="text-red-500 text-sm mt-1">{{ $errors->first($name) }}</p>
    @endif
@endunless

@props([
    'name' => Str::random(6),
    'label', // Rótulo do campo
    'firstOption', // Primeira opção Ex. 'Selecione uma opção'
    'placeholder' => null, // Placeholder do campo Ex. 'Selecione uma opção'
    'placeholder_css' => 'text-gray-500', // Estilo do placeholder
    'collection', // Coleção de dados principal Ex. $tools ou $users
    'relatedCollection', // Coleção de dados relacionada, como $triggers ou $subscriptions
    'relationName', // Nome da relação, como 'triggers' ou 'subscriptions'
    'selected', // Valor selecionado
    'icon' => null,
    'bg_icon' => '#000',
    'option_css' => '',
    'disableWhenRelated' => true, // Desabilitar opção quando existe uma relação (fica com opacidade)
    'disabledReason' => 'Esta opção está desativada', // Mensagem quando a opção está desabilitada
    'allowClear' => true, // Permite limpar o campo
    'onSelect' => null, // Novo parâmetro para o script de seleção
    'wireModel' => null, //Parametro do Livewire
])

<div class="mb-4">
    @if (isset($label))
        <x-label :for="$name"
                 :label="$label" />
    @endif

    <select name="{{ $name }}"
            @if($wireModel) wire:model="{{ $wireModel }}" @endif
            class="select2_{{ $name }} w-full mt-1 @error($name) border-red-500 @enderror">
        @if (isset($placeholder) && !isset($selected))
            <option value=""
                    disabled
                    selected
                    class="{{ $placeholder_css }}">{{ $placeholder }}</option>
        @endif
        @if (isset($firstOption) && $firstOption === '')
            <option value=""></option>
        @elseif (isset($firstOption))
            <option value="">{{ $firstOption }}</option>
        @endif

        @if (isset($collection))
            @foreach ($collection as $item)
                @php
                    // Verifica a relação e aplica a lógica de desativação somente se 'relatedCollection' e 'relationName' estiverem definidas
                    $hasRelated =
                        isset($relatedCollection) && isset($relationName) && $item->{$relationName}->isNotEmpty();
                    $shouldDisable = isset($disableWhenRelated)
                        ? ($disableWhenRelated && $hasRelated) || (!$disableWhenRelated && !$hasRelated)
                        : false; // Padrão é não desativar

                @endphp


                <option value="{{ $item->id }}"
                        @if ($shouldDisable) disabled @endif
                        {{ old($name, isset($selected) ? $selected : '') == $item->id ? 'selected' : '' }}
                        data-icon="{{ isset($icon) ? $item->{$icon} : '' }}"
                        data-bg-icon="{{ isset($bg_icon) ? $item->{$bg_icon} : '' }}"
                        data-disabled="{{ $shouldDisable ? 'true' : 'false' }}"
                        data-reason="{{ $shouldDisable ? $disabledReason : '' }}"
                        data-title="{{ $shouldDisable ? $disabledReason : '' }}">
                    {{ __($item->name) }}
                </option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>

    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<script>
    $(document).ready(function() {

        var placeholder = '{{ $placeholder ?? '' }}';

        function initSelect2() {

            // Inicializa o select2
            $('select[name="{{ $name }}"]').select2({
                placeholder: placeholder ? placeholder : null,
                allowClear: {{ $allowClear ? 'true' : 'false' }},
                templateResult: function(item) {
                    if (!item.id || !item.element) {
                        return $.parseHTML('<span class="{{ $placeholder_css }}">' + item.text +
                            '</span>');
                    }

                    const iconUrl = $(item.element).data('icon') ||
                        ''; // Verifica se o ícone está definido
                    const bgIcon = $(item.element).data('bg-icon') || '#fff';
                    const isDisabled = $(item.element).data('disabled') === 'true';
                    const reason = $(item.element).data('reason') || '';
                    const reasonShort = reason.length > 65 ? reason.substring(0, 65) + '...' :
                        reason;
                    const title = $(item.element).data('title') || '';

                    // Começa a construção do resultado
                    let result = '<div style="display: flex; align-items: center;" class="' + (
                        isDisabled ? 'opacity-50' : 'opacity-100') + '" title="' + title + '">';

                    // Verifica se o ícone foi passado e renderiza o círculo com a imagem apenas se for necessário
                    if (iconUrl) {
                        let assetUrl =
                            '{{ asset('images/') }}'; // Gerar o caminho correto da pasta de storage

                        result += '<div style="background-color:' + bgIcon +
                            '; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; margin-right: 8px;">' +
                            '<img src="' + assetUrl + '/' + iconUrl +
                            '" class="rounded-full" style="width: 28px; height: 28px; border-radius: 50%;" ' +
                            'onerror="this.onerror=null;this.src=\'\';" />' +
                            '</div>';

                    }

                    // Sempre renderiza o texto da opção
                    result += '<span class="{!! $option_css !!}">' + item.text + '<br> ' +
                        '<p style="font-size:13px;">' + reasonShort + '</p>' +
                        '</span></div>';

                    return $.parseHTML(result);
                },

                templateSelection: function(item) {
                    if (!item.id) {
                        return $.parseHTML('<span class="{{ $placeholder_css }}">' + item.text +
                            '</span>');
                    }

                    const iconUrl = $(item.element).data('icon') ||
                        ''; // Verifica se o ícone está definido
                    const bgIcon = $(item.element).data('bg-icon') || '#fff';

                    // Começa a construção da seleção
                    let selection = '<div style="display: flex; align-items: center;">';

                    // Verifica se o ícone foi passado e renderiza o círculo com a imagem apenas se for necessário
                    if (iconUrl) {

                        let assetUrl =
                            '{{ asset('images/') }}'; // Gerar o caminho correto da pasta de storage

                        selection +=
                            '<div style="background-color:' + bgIcon +
                            '; border-radius: 50%; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; margin-right: 8px;">' +
                            '<img src="' + assetUrl + '/' + iconUrl +
                            '" class="rounded-full" style="width: 28px; height: 28px; border-radius: 50%;" onerror="this.onerror=null;this.src=\'\';" />' +
                            '</div>';
                    }

                    // Sempre renderiza o texto da opção
                    selection += '<span class="{!! $option_css !!}">' + item.text +
                        '</span></div>';

                    return $.parseHTML(selection);
                }

            });

            // Executa algum código javascript quando uma opção do select é selecionada
            @if ($onSelect)
                $('select[name="{{ $name }}"]').on('select2:select', function(e) {
                    {!! $onSelect !!}
                });
            @endif

            @if ($wireModel)
                $('select[name="{{ $name }}"]').on('change', function(e) {
                    @this.set('{{ $wireModel }}', e.target.value);
                });
            @endif
        }

        initSelect2();

        document.addEventListener('livewire:update', function() {
            initSelect2();
        });
    });
</script>

<script>
    $(document).ready(function() {
        function initializeTippy() {
            tippy('[data-tippy-content]', {
                placement: 'top', // Defina a posição do tooltip
                theme: 'light', // Defina o tema (opcional)
                allowHTML: true, // Permitir HTML dentro do tooltip
            });
        }

        document.addEventListener('livewire:load', function() {
            // Inicializa o select2 ao carregar a página
            initializeTippy();
        });

        document.addEventListener('livewire:update', function() {
            // Reinicializa o select2 após qualquer atualização do Livewire
            initializeTippy();
        });

        initializeTippy();
    });
</script>

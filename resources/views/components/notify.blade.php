<script>
    Livewire.on('notify', (type, message, position = 'top-end') => {
        Swal.fire({
            icon: type, // 'success', 'error', 'warning', etc.
            title: message,
            timer: 5000,
            toast: true,
            position: position,
            showConfirmButton: false,
            theme: document.documentElement.classList.contains('dark') ? 'dark' :
            'minimal', // Tema dinâmico baseado no estado do sistema
            width: '30rem',
            customClass: {
                container: 'swal2-dark'
            }
        });
    });
</script>


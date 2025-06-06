const theme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' :
'light');
document.documentElement.classList.add(theme);

// Verificando e alterando o tema do SweetAlert2 dinamicamente
function updateSweetAlertTheme() {
const currentTheme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
const sweetalertLink = document.getElementById('sweetalert-theme');
if (currentTheme === 'dark') {
    sweetalertLink.href = 'https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css'; // Tema escuro
} else {
    sweetalertLink.href =
    'https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css'; // Tema minimal
}
}
// Atualiza o tema do SweetAlert2 quando a página for carregada
window.addEventListener('DOMContentLoaded', () => {
updateSweetAlertTheme();
});

// login.js

document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('contrasenaInput');
    const toggle = document.getElementById('togglePassword');

    if (toggle && input) {
        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            // Cambiar icono
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Mostrar alerta si error en URL
    const url = new URL(window.location.href);
    if (url.searchParams.get('error') === '1') {
        mostrarAlertaLoginError();
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
    }
});

function mostrarAlertaLoginError() {
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Correo o contraseña incorrectos',
        confirmButtonText: 'Aceptar'
    });
}

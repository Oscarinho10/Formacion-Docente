// login.js

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('contrasenaInput');
    const toggle = document.getElementById('togglePassword');

    if (toggle && input) {
        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            // Cambiar icono directamente (sin necesidad de un <i id="eyeIcon">)
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Mostrar alerta de error si está definida
    if (typeof mostrarAlertaLoginError === 'function') {
        mostrarAlertaLoginError();
    }
});

// Función para mostrar alerta de error con SweetAlert2
function mostrarAlertaLoginError() {
    Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Correo o contraseña incorrectos',
        confirmButtonText: 'Aceptar'
    });
}

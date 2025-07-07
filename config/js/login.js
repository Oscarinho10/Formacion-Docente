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

document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('contrasenaInput');
    const toggle = document.getElementById('togglePassword');

    if (toggle && input) {
        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Detectar parámetro error=1 en la URL
    const url = new URL(window.location.href);
    if (url.searchParams.get('error') === '1') {
        mostrarAlertaLoginError();

        // Eliminar el parámetro de la URL para evitar repetir la alerta
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
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

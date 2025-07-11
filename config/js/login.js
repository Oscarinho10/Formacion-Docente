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

// === Listener para formulario de recuperación de contraseña ===
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formRecuperacion');
    if (!form) {
        console.warn('⚠️ No se encontró el formulario de recuperación');
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const correo = document.getElementById('correoRecuperacion').value;

        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas solicitar recuperación para: ${correo}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, enviar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then(result => {
            if (result.isConfirmed) {
                const formData = new URLSearchParams();
                formData.append('correo', correo);

                fetch('./config/controller/recoveryPassword.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formData.toString()
                })
                    .then(res => res.text())
                    .then(response => {
                        if (response.trim() === 'ok') {
                            Swal.fire('Enviado', 'Tu solicitud ha sido registrada correctamente.', 'success');
                            form.reset();
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalRecuperar'));
                            if (modal) modal.hide();
                        } else {
                            Swal.fire('Error', response, 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'No se pudo enviar la solicitud.', 'error');
                    });
            }
        });
    });
});


$(document).ready(function () {
    // Cargar datos del perfil al iniciar
    $.ajax({
        url: 'controller/profileUserController.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data && !data.error) {
                $('#nombre').val(data.nombre);
                $('#apellido_paterno').val(data.apellido_paterno);
                $('#apellido_materno').val(data.apellido_materno);
                $('#correo_electronico').val(data.correo_electronico);
                $('#numero_control_rfc').val(data.numero_control_rfc);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || 'Error al obtener los datos del perfil.'
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor.'
            });
        }
    });

    // Envío del formulario con validación y confirmación
    $('#userForm').on('submit', function (e) {
        e.preventDefault();

        const nombre = $('#nombre').val().trim();
        const apellido_paterno = $('#apellido_paterno').val().trim();
        const apellido_materno = $('#apellido_materno').val().trim();
        const nuevaContrasena = $('#nueva_contrasena').val().trim();

        if (nombre === '' || apellido_paterno === '' || apellido_materno === '') {
            Swal.fire('Campos incompletos', 'Por favor, completa todos los campos obligatorios.', 'warning');
            return;
        }

        Swal.fire({
            title: '¿Deseas guardar los cambios?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#E74B3E",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const data = {
                    nombre: nombre,
                    apellido_paterno: apellido_paterno,
                    apellido_materno: apellido_materno
                };

                if (nuevaContrasena !== '') {
                    data.nueva_contrasena = nuevaContrasena;
                }

                $.ajax({
                    url: 'controller/profileUserController.php',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        Swal.fire('Actualización exitosa', response, 'success');
                        $('#nueva_contrasena').val('');
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseText || 'Error al actualizar el perfil.', 'error');
                    }
                });
            }
        });
    });
});

// Mostrar/ocultar contraseña
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('nueva_contrasena');
    const toggle = document.getElementById('togglePassword');

    if (toggle && input) {
        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    }
});

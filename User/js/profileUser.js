$(document).ready(function () {
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
                $('#numero_control_rfc').val(data.numero_control_rfc); // ✅ Correcto
            } else {
                alert(data.error || 'Error al obtener los datos del perfil.');
            }
        },
        error: function () {
            alert('Error al conectar con el servidor.');
        }
    });

    $('#userForm').on('submit', function (e) {
        e.preventDefault();

        const nuevaContrasena = $('#nueva_contrasena').val();

        const data = {
            nombre: $('#nombre').val(),
            apellido_paterno: $('#apellido_paterno').val(),
            apellido_materno: $('#apellido_materno').val()
        };

        // Solo incluir contraseña si el campo fue llenado
        if (nuevaContrasena.trim() !== '') {
            data.nueva_contrasena = nuevaContrasena;
        }

        $.ajax({
            url: 'controller/profileUserController.php',
            type: 'POST',
            data: data,
            success: function (response) {
                Swal.fire('Actualización', response, 'success');
                $('#nueva_contrasena').val(''); // Limpiar campo por seguridad
            },
            error: function () {
                Swal.fire('Error', 'Error al actualizar el perfil.', 'error');
            }
        });
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('nueva_contrasena');
    const toggle = document.getElementById('togglePassword');

    if (toggle && input) {
        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            // Cambia icono (de ojo cerrado a abierto y viceversa)
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    }
});


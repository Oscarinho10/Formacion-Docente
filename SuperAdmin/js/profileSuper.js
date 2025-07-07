$(document).ready(function () {
    $.ajax({
        url: 'controller/profileSuperController.php',
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

    $('#userForm').on('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Guardar cambios?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controller/profileSuperController.php',
                    type: 'POST',
                    data: {
                        nombre: $('#nombre').val(),
                        apellido_paterno: $('#apellido_paterno').val(),
                        apellido_materno: $('#apellido_materno').val()
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo actualizar el perfil.'
                        });
                    }
                });
            }
        });
    });
});

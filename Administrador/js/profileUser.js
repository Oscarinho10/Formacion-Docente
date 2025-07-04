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

        $.ajax({
            url: 'controller/profileUserController.php',
            type: 'POST',
            data: {
                nombre: $('#nombre').val(),
                apellido_paterno: $('#apellido_paterno').val(),
                apellido_materno: $('#apellido_materno').val()
            },
            success: function (response) {
                alert(response);
            },
            error: function () {
                alert('Error al actualizar el perfil.');
            }
        });
    });
});

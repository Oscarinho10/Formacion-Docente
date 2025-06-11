$(document).ready(function() {
        // Obtener el ID de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        if (!id) {
            alert('No se proporcionó un ID de usuario.');
            return;
        }

        // Cargar datos del usuario
        $.ajax({
            url: 'getUser.php?id=' + encodeURIComponent(id),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    $('#nombre').val(data.nombre);
                    $('#apellidoPaterno').val(data.apellido_paterno);
                    $('#apellidoMaterno').val(data.apellido_materno);
                    $('#correo').val(data.correo);
                    $('#numeroControl').val(data.numero_control_rfc);
                }
            },
            error: function() {
                alert('Error al cargar el perfil del usuario.');
            }
        });

        // Manejar el envío del formulario
        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            const userData = {
                nombre: $('#nombre').val(),
                apellidoPaterno: $('#apellidoPaterno').val(),
                apellidoMaterno: $('#apellidoMaterno').val(),
                correo: $('#correo').val(),
                numeroControl: $('#numeroControl').val()
            };

            // Aquí puedes agregar la lógica para guardar los datos del usuario
            console.log(userData);
            alert('Datos guardados correctamente.');
        });
    });
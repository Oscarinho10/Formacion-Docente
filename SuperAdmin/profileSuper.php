<?php
include('../components/layoutSuper.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="form-title">Perfil de Usuario</h2>
            <form id="userForm">
                <div class="form-group">
                    <label for="nombre">Nombre*</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellidoPaterno">Apellido Paterno*</label>
                    <input type="text" class="form-control" id="apellidoPaterno" required>
                </div>
                <div class="form-group">
                    <label for="apellidoMaterno">Apellido Materno*</label>
                    <input type="text" class="form-control" id="apellidoMaterno" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo Electrónico*</label>
                    <input type="email" class="form-control" id="correo" readonly>
                </div>
                <div class="form-group">
                    <label for="numeroControl">Número de Control*</label>
                    <input type="text" class="form-control" id="numeroControl" readonly>
                </div>
                <button type="submit" class="btn btn-guardar">Guardar</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
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
    </script>
</body>
</html>

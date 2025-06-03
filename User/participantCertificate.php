<?php include('../components/layout.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancias del Participante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="card-header">
        <h2>Constancias del Participante</h2>
    </div>
    <div class="container mt-5">
        <div class="card">

            <div class="card-body" id="constancias-container">
                <!-- Aquí se mostrarán las constancias -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Cambia esto por el ID real del usuario participante (puede venir de sesión)
            var usuarioId = 123;

            $.ajax({
                url: 'getCertificate.php',
                type: 'GET',
                data: {
                    usuario_id: usuarioId
                },
                dataType: 'json',
                success: function(data) {
                    var container = $('#constancias-container');
                    if (data.length > 0) {
                        data.forEach(function(constancia) {
                            container.append(
                                '<div class="card mb-3">' +
                                '<div class="card-body">' +
                                '<h5 class="card-title">Constancia ID: ' + constancia.id + '</h5>' +
                                '<p class="card-text">Folio: ' + constancia.folio + '</p>' +
                                '</div>' +
                                '</div>'
                            );
                        });
                    } else {
                        container.append(
                            '<div class="alert alert-info" role="alert">No hay constancias disponibles.</div>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    $('#constancias-container').append(
                        '<div class="alert alert-danger" role="alert">Error al cargar las constancias.</div>'
                    );
                }
            });
        });
    </script>
</body>

</html>
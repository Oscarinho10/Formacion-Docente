<?php
include('../components/layout.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancias</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
</head>
<body>
    <div class="card-header">
                <h2>Constancias del instrcutor</h2>
            </div>
    <div class="container mt-5">
        <div class="card">
            
            <div class="card-body" id="constancias-container">
                <!-- Aquí se mostrarán las constancias o el mensaje -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/scrollreveal.js"></script>

    <script>
    $(document).ready(function() {
        $.ajax({
            url: 'getCertificate.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var container = $('#constancias-container');
                if (data.length > 0) {
                    data.forEach(function(constancia) {
                        container.append(`
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Constancia ID: ${constancia.id}</h5>
                                    <p class="card-text">Folio: ${constancia.folio}</p>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    container.append(`
                        <div class="alert alert-info" role="alert">
                            No hay constancias disponibles.
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#constancias-container').append(`
                    <div class="alert alert-danger" role="alert">
                        Error al cargar las constancias.
                    </div>
                `);
            }
        });
    });
    </script>
</body>
</html>

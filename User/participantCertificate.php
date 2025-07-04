<?php
include_once('../config/verificaRol.php');
verificarRol('participante'); // Esto asegura el acceso solo a participantes

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layout.php');

?>

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
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/User/js/participantCertificate.js"></script>
</body>

</html>
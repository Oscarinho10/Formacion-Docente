<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'instructor') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutInstructor.php');
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
    <div class="container mt-4">
        <h2></h2>
        <h4 class="mb-3">Constancias del instructor</h4>
    </div>
    <div class="container mt-4">
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
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/Instructor/js/instructorCertificate.js"></script>

    <script>

    </script>
</body>

</html>
<?php
include_once('../config/verificaRol.php');
verificarRol('superAdmin');
include('../components/layoutSuper.php');
$idInstructor = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idInstructor <= 0) {
    echo "<div class='alert alert-danger m-4'>ID de instructor no válido.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Constancias del Instructor</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/tabla.css">
    <link rel="stylesheet" href="../assets/css/estilo.css">
    <link rel="stylesheet" href="../assets/fontawesome/all.min.css">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <h4 class="mb-3">Constancias emitidas al instructor</h4>
        <div class="table-responsive">
            <table class="table table-bordered" id="constancyTable">
                <thead class="table-light">
                    <tr>
                        <th>Actividad</th>
                        <th>Horas</th>
                        <th>Modalidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBodyConstancias">
                    <!-- Contenido dinámico -->
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <button onclick="window.history.back()" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> Regresar
            </button>
        </div>
    </div>

    <script>
        const instructorId = <?php echo $idInstructor; ?>;
    </script>
     <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/instructorConstancy.js"></script>
</body>

</html>
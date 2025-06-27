<?php
session_start();

// Prevenir que el navegador guarde páginas en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar que hay sesión iniciada y es admin
include_once('../config/verificaSesion.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Docentes</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">


    <div class="container mt-4">
        <h4 class="mb-3">Instructores</h4>
        <!-- Filtros y boton de agregar -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar instructor...">
                </div>
            </div>

            <div class="col-md-6 text-end">
                <a href="addInstructor.php" class="btn btn-primary" id="addButton"><i class="fas fa-plus"></i> Agregar </a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered" id="professorsTable">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Perfil Académico</th>
                        <th>Unidad Académica</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Contenido dinámico -->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div id="paginationInfo"></div>
            <ul class="pagination" id="pagination"></ul>
            <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/initAdmin.php'" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> Regresar
            </button>
        </div>

    </div>
    <?php include('../Administrador/modalAdmin/modalInstructor.php') ?>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/listInstructorsScript.js"></script>

</body>

</html>
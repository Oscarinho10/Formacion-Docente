<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Docentes</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">


    <div class="container mt-4">
        <h4 class="mb-3">Instructores</h4>
        <!-- Filtros y boton de agregar -->
        <div class="row g-2 align-items-end mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar instructor...">
                </div>
            </div>

            <div class="col-md-6 text-end">
                <a href="addInstructor.php" class="btn btn-primary w-80 w-md-auto" id="addButton"><i class="fas fa-plus"></i> Agregar </a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered" id="professorsTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Perfil Académico</th>
                        <th class="text-center">Unidad Académica</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Contenido dinámico -->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-3 gap-2">
            <div id="paginationInfo" class="text-start w-100 w-md-auto"></div>

            <div class="table-pagination-wrapper w-100 w-md-auto">
                <ul class="pagination mb-0" id="pagination"></ul>
            </div>

            <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/initAdmin.php'" class="btn btn-dark btn-compact">
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
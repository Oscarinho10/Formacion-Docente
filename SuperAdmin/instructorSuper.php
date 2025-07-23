<?php 
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutSuper.php') ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Docentes</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
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
                        <th>Número de Control</th>
                        <th>Perfil Académico</th>
                        <th>Unidad Académica</th>
                        <th>Estado</th>
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
            <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/initSuper.php'" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> Regresar
            </button>
        </div>

    </div>
    <?php include('../SuperAdmin/modalSuper/modalInstructor.php')?>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>>
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/instructorSuper.js"></script>

</body>

</html>
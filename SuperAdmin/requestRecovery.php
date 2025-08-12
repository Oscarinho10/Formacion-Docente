<?php
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // Asegura acceso solo a superAdmins

include('../components/layoutSuper.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitudes de recuperación</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <h4 class="mb-3">Solicitudes de restablecimiento de contraseña</h4>

        <!-- Filtro de búsqueda -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchRecovery" placeholder="Buscar por correo...">
                </div>
            </div>
        </div>

        <!-- Tabla de solicitudes -->
        <div class="table-responsive">
            <table class="table table-bordered" id="recoveryTable">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Fecha de solicitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="recoveryTableBody">
                    <!-- Datos se llenarán dinámicamente con JS -->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-3 gap-2">
            <div id="paginationInfo" class="text-start w-100 w-md-auto"></div>

            <div class="table-pagination-wrapper w-100 w-md-auto">
                <ul class="pagination mb-0" id="pagination"></ul>
            </div>
            
            <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/requestSuper.php'" class="btn btn-dark btn-compact">
                <i class="fas fa-arrow-left"></i> Regresar
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/requestRecovery.js"></script>

</body>

</html>
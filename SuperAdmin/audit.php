<?php
include('../components/layoutSuper.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body>
    <div class="container mt-4 d-flex justify-content-center">
        <div style="width: 100%; max-width: 1000px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Movimientos</h3>
            </div>
            <!-- Filtros -->
            <div class="form-row mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="date" id="filterFecha" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-block" id="clearFilters">Limpiar filtros</button>
                </div>
                <div class="col-md-3">
                    <button  onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/manageAdmin.php'" class="btn btn-primary" id="addButton"> Gestionar administradores</button>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered" id="tablaActividades">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Administrador</th>
                            <th>Movimientos</th>
                            <th>Modulos</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Filas dinámicas -->
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
    </div>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/audit.js"></script>
</body>

</html>
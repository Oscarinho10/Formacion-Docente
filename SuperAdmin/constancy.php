<?php
include('../components/layoutSuper.php')
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Constancias</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">
    <div class="container mt-4 d-flex justify-content-center">
        <div style="width: 100%; max-width: 1000px;">


            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre...">

                <div class="col-md-3">
                    <input type="date" id="filterFecha" class="form-control">
                </div>
                <div class="col-md-2 text-right">
                    <button id="clearFiltersBtn" class="btn btn-outline-secondary">Limpiar filtros</button>
                </div>
            </div>
            <br>
            <table class="table table-bordered" id="studentsTable">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha actividad</th>
                        <th>Tipo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Llenado por JS -->
                </tbody>
            </table>

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

    </div>

    <!-- Scripts -->

    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/constancy.js"></script>


</body>

</html>
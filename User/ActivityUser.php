<?php
include('../components/layout.php');
include('../User/Controller/activityUserController.php')
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla con filtros</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <!-- Filtros -->
        <div class="form-row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar curso...">
                </div>
            </div>

            <div class="col-md-3">
                <select class="form-control" id="filterModality">
                    <option value="">Todas las modalidades</option>
                    <?php foreach ($modalidades as $modo): ?>
                        <option value="<?php echo htmlspecialchars($modo); ?>"><?php echo htmlspecialchars($modo); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <button class="btn btn-outline-secondary" id="clearFilters">Limpiar filtros</button>
            </div>
        </div>

        <!-- Contenedor para centrar la tabla -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="coursesTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre del curso</th>
                            <th>Total de horas</th>
                            <th>Modalidad</th>
                            <th>Cupo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginador y contador -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="pagination-info" id="paginationInfo">
                Mostrando 1-5 de <?php echo count($actividades); ?> registros
            </div>
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- Botones de página dinámicos -->
                </ul>
            </nav>
        </div>

    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
    <script>
        const actividadesData = <?php echo json_encode($actividades); ?>; //importante para que funcione activityUser.js
    </script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/User/js/activityUser.js"></script>

    <?php include('./modals/modalDetalles.php'); ?>

</body>

</html>
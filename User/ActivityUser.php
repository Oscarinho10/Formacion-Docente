<?php
include('../components/layout.php');
include('../User/Controller/activityUserController.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla con filtros</title>

    <!-- Bootstrap & Estilos -->
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
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar curso...">
                </div>
            </div>

            <div class="col-md-4">
                <select class="form-control" id="filterModality">
                    <option value="">Todas las modalidades</option>
                    <?php foreach ($modalidades as $modo): ?>
                        <option value="<?= htmlspecialchars($modo) ?>"><?= htmlspecialchars($modo) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4 text-end">
                <button class="btn btn-outline-secondary" id="clearFilters">Limpiar filtros</button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-container table-responsive">
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
                    <!-- Datos dinámicos -->
                </tbody>
            </table>
        </div>

        <!-- Paginador -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div id="paginationInfo">
                Mostrando 1-5 de <?= count($actividades) ?> registros
            </div>
            <nav>
                <ul class="pagination mb-0" id="pagination">
                    <!-- Paginación dinámica -->
                </ul>
            </nav>
        </div>

    </div>

    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>

    <!-- Exportar datos PHP a JS -->
    <script>
        const actividadesData = <?= json_encode($actividades); ?>;
    </script>

    <!-- Lógica de renderizado JS -->
    <script src="<?php echo BASE_URL; ?>/User/js/activityUser.js"></script>

    <!-- Modal -->
    <?php include('./modals/modalDetalles.php'); ?>

</body>
</html>

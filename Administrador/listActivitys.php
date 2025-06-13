<?php
include('../components/layoutAdmin.php');
// include('./controller/listActivitysController.php');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Usuarios</title>
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

        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <h4 class="mb-3">Actividades formativas</h4>
            <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/addActivity.php'" class="btn btn-primary col-md-2" id="addButton" href="addInstructor.php">+ Registrar</button>
        </div>

            <!-- Filtros  -->
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar general...">
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-control" id="filterUnidad">
                        <option value="">Todas las unidades</option>
                        <option value="">Derecho</option>
                        <?php foreach ($unidades as $unidad): ?>
                            <option value="<?php echo htmlspecialchars($unidad); ?>"><?php echo htmlspecialchars($unidad); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-control" id="filterPerfil">
                        <option value="">Todos los perfiles</option>
                        <option value="">Perfil de facebook</option>
                        <?php foreach ($perfiles as $perfil): ?>
                            <option value="<?php echo htmlspecialchars($perfil); ?>"><?php echo htmlspecialchars($perfil); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-outline-secondary btn-block" id="clearFilters">Limpiar filtros</button>
                </div>
            </div>

            <!-- Contenedor de la tabla -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-bordered" id="usersTable">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Total de horas</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Se llenará con JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginador y contador -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div id="paginationInfo"></div>
                <ul class="pagination" id="pagination"></ul>
            </div>

            <!-- Botón totalmente a la derecha -->
            <div class="d-flex justify-content-end mt-3 mb-4">
                <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/initAdmin.php'" class="btn btn-dark">
                    <i class="fas fa-arrow-left"></i> Regresar
                </button>
            </div>

        </div>

        <!-- Scripts -->
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/listActivitysScript.js"></script>


</body>

</html>
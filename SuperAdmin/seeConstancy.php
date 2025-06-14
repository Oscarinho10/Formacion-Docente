<?php
include('../components/layoutSuper.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Generar Constancias</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
</head>

<body class="bg-light">
    <div class="container mt-4 d-flex justify-content-center">
        <div style="width: 100%; max-width: 1000px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Generar Constancias</h3>
            </div>

            <!-- Filtros de búsqueda -->
            <div class="form-row mb-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar participante...">
                    </div>
                </div>
                    <div class="col-md-4">
                        <input type="date" id="filterFecha" class="form-control">
                    </div>
            </div>

            <!-- Tabla de Participantes -->
            <div class="table-responsive">
                <table class="table table-bordered" id="studentsTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Rellenado por JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between mt-3">
                <button class="btn btn-primary" id="generateAllButton">Generar Constancias de Todos</button>

                 <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/constancy.php'" class="btn btn-dark">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/seeConstancy.js"></script>

 
</body>

</html>

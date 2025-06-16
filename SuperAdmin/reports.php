<?php
include('../components/layoutSuper.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body>
    <div class="container mt-4" style="max-width: 1200px;">

        <h4 class="mb-3">Generar reporte general</h4>
        <div class="d-flex justify-content-end">

            <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/initSuper.php'" class="btn btn-dark mr-2">
                <i class="fas fa-arrow-left"></i> Regresar
            </button>

            <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/reportsUnityAcademy.php'" class="btn btn-dark mr-2">
                <i class="fas fa-clipboard-list"></i> Consultar reporte por Unidad Academica
            </button>

            <button class="btn btn-general btn-sm" onclick="imprimirReporte()">Imprimir reporte</button>


        </div>

        <div class="p-3 mb-4">

        </div>
        <!-- Filtros -->
        <div class="p-3 mb-4" style="background-color: #215472; border-radius: 5px;">
            <div class="form-row align-items-center">
                <div class="col-md-4 mb-2">
                    <label class="mb-0"></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por actividad formativa">
                    </div>
                </div>

                <div class="col-md-3 mb-2 text-white">
                    <label class="mb-0">Seleccionar semestre</label>
                    <select class="form-control" id="semestreSelect">
                        <option value="">Todos</option>
                        <option value="Enero - Junio">Enero - Junio</option>
                        <option value="Julio - Diciembre">Julio - Diciembre</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2 text-white">
                    <label class="mb-0">Seleccionar año</label>
                    <select class="form-control" id="anioSelect">
                        <option value="">Todos</option>
                        <option>2023</option>
                        <option>2024</option>
                        <option>2025</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label class="mb-0"></label>
                    <button class="btn btn-success btn-block" onclick="filtrarTabla()">Consultar</button>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-bordered " id="tablaReporte">
                <thead class="thead-light">
                    <tr>
                        <th>Tipo</th>
                        <th>Actividad</th>
                        <th>Instructor</th>
                        <th>Duración</th>
                        <th>Modalidad</th>
                        <th>Fecha inicio</th>
                        <th>Horario</th>
                        <th>Total participantes</th>
                        <th>Total asistidos</th>
                    </tr>
                </thead>
                <tbody id="tbodyReporte">
                    <!-- Se llena con JS -->
                </tbody>
            </table>
        </div>

    </div>
</body>
<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/reports.js"></script>

</html>
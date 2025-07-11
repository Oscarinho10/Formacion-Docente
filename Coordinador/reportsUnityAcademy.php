<?php 
include_once('../config/verificaRol.php');
verificarRol('coordinador'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutCoordinador.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Reporte por Unidad Académica</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body class="bg-light">
  <div class="container my-4">
    <div class="card-body">

      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h4 class="mb-0">Generar reporte por unidad académica</h4>
        <div class="d-flex flex-wrap gap-2">
          <button onclick="window.location.href='<?php echo BASE_URL; ?>/Coordinador/reports.php'" class="btn btn-dark">
            <i class="fas fa-arrow-left me-1"></i> Regresar
          </button>
          <button class="btn btn-general btn-sm" id="btnExportarActividad">
            <i class="fas fa-print me-1"></i> Imprimir reporte
          </button>
        </div>
      </div>

      <!-- Filtros -->
      <div class="p-3 mb-4" style="background-color: #215472; border-radius: 5px;">
        <div class="row g-2 align-items-center">
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
              <input type="text" id="searchInput" class="form-control" placeholder="Buscar por unidad académica">
            </div>
          </div>

          <div class="col-md-4 text-white">
            <label class="form-label mb-1">Rango de años</label>
            <select id="yearSelect" class="form-select">
              <option value="">Todos los años</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
              <option value="2022">2022</option>
              <option value="2021">2021</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered text-center" id="tablaAnios">
          <thead class="table-light">
            <tr>
              <th>Año</th>
              <th>Unidad Académica</th>
              <th>Actividades Realizadas</th>
              <th>Total Participantes</th>
              <th>Total Asistencias</th>
            </tr>
          </thead>
          <tbody id="tbodyAnios">
            <!-- Contenido dinámico -->
          </tbody>
        </table>
        <div id="tablasPorAnio"></div>
      </div>

    </div>

  </div>

  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/Coordinador/js/reportsUnityAcademy.js"></script>

</body>

</html>
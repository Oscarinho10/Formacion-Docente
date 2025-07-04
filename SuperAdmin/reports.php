<?php 
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutSuper.php'); 
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Reportes</title>
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
          <h4 class="mb-0">Generar reporte general</h4>
          <div class="d-flex flex-wrap gap-2">
            <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/initSuper.php'" class="btn btn-dark">
              <i class="fas fa-arrow-left me-1"></i> Regresar
            </button>
            <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/reportsUnityAcademy.php'" class="btn btn-dark">
              <i class="fas fa-clipboard-list me-1"></i> Reporte por Unidad Académica
            </button>
            <button id="btnExportarPDF" class="btn btn-primary">
              <i class="fas fa-print me-1"></i> Imprimir reporte
            </button>
          </div>
        </div>

        <!-- Filtros -->
        <div class="p-3 mb-4" style="background-color: #215472; border-radius: 5px;">
          <div class="row g-2 align-items-center">
            <div class="col-md-4">
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar por actividad formativa">
              </div>
            </div>

            <div class="col-md-3 text-white">
              <label class="form-label mb-1">Semestre</label>
              <select class="form-select" id="semestreSelect">
                <option value="">Todos</option>
                <option value="Enero - Junio">Enero - Junio</option>
                <option value="Julio - Diciembre">Julio - Diciembre</option>
              </select>
            </div>

            <div class="col-md-3 text-white">
              <label class="form-label mb-1">Año</label>
              <select class="form-select" id="anioSelect">
                <option value="">Todos</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
              </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                
              <button class="btn btn-secondary w-100" id="clearFilters">Limpiar filtros</button>
            </div>
          </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="tablaReporte">
            <thead class="table-light">
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
              <!-- Rellenado por JS -->
            </tbody>
          </table>
        </div>

      </div>
    
  </div>

  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/reports.js"></script>

</body>
</html>

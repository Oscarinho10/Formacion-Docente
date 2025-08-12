<?php
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutSuper.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Movimientos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" type="text/css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">
  <div class="container my-4">
    <div style="max-width: 1000px; margin: auto;">
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h3 class="mb-0">Movimientos</h3>
      </div>

      <!-- Filtros -->
      <div class="row g-2 mb-4">
        <div class="col-md-4">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
          </div>
        </div>
        <div class="col-md-3">
          <input type="date" id="filterFecha" class="form-control">
        </div>
        <div class="col-md-2">
          <button class="btn btn-outline-secondary w-100" id="clearFilters">Limpiar filtros</button>
        </div>
        <div class="col-md-3">
          <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/manageAdmin.php'" class="btn btn-primary w-100" id="addButton">
            Gestionar administradores
          </button>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered text-center" id="tablaActividades">
          <thead class="table-light">
            <tr>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Administrador</th>
              <th>Movimientos</th>
              <th>Módulos</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <!-- Filas dinámicas -->
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-3 gap-2">
        <div id="paginationInfo" class="text-start w-100 w-md-auto"></div>

        <div class="table-pagination-wrapper w-100 w-md-auto">
          <ul class="pagination mb-0" id="pagination"></ul>
        </div>

        <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/initSuper.php'" class="btn btn-dark btn-compact">
          <i class="fas fa-arrow-left"></i> Regresar
        </button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/audit.js"></script>
</body>

</html>
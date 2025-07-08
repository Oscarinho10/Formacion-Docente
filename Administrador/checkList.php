<?php 
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutSuper.php'); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Tabla con filtros</title>
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

  <div class="container mt-4 d-flex justify-content-center">
    <div style="width: 100%; max-width: 1000px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Lista de Asistencia </h3>

      </div>

      <!-- Filtros -->
      <div class="row mb-4">
        <div class="col-12 col-md-4 mb-2 mb-md-0">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar actividad...">
          </div>
        </div>

        <div class="col-12 col-md-3 mb-2 mb-md-0">
          <input type="date" id="filterFecha" class="form-control">
        </div>

        <div class="col-12 col-md-3 mb-2 mb-md-0">
          <select id="filterEstado" class="form-select">
            <option value="">-- Estado --</option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
          </select>
        </div>

        <div class="col-12 col-md-2">
          <button class="btn btn-outline-secondary w-100" id="clearFilters">Limpiar filtros</button>
        </div>
      </div>


      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaActividades">
          <thead class="table-light">
            <tr>
              <th>Nombre de la Actividad</th>
              <th>Fecha Fin</th>
              <th>Estado</th>
              <th>Acciones</th>
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
        <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/initAdmin.php'" class="btn btn-dark">
          <i class="fas fa-arrow-left"></i> Regresar
        </button>
      </div>
    </div>
  </div>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/checkList.js"></script>

</body>

</html>
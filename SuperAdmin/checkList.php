<?php include('../components/layoutSuper.php'); ?>

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

<body>

<div class="container mt-4 d-flex justify-content-center">
  <div style="width: 100%; max-width: 1000px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Lista de Asistencia </h3>
      
    </div>

    <!-- Filtros -->
    <div class="form-row mb-4">
      <div class="col-md-4">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input type="text" id="searchInput" class="form-control" placeholder="Buscar actividad...">
        </div>
      </div>
      <div class="col-md-3">
        <input type="date" id="filterFecha" class="form-control">
      </div>
      <div class="col-md-3">
        <select id="filterEstado" class="form-control">
          <option value="">-- Estado --</option>
          <option value="Activo">Activo</option>
          <option value="Inactivo">Inactivo</option>
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-outline-secondary btn-block" id="clearFilters">Limpiar filtros</button>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered" id="tablaActividades">
        <thead class="thead-light">
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

    <!-- Paginador -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div class="pagination-info" id="paginationInfo"></div>
      <nav>
        <ul class="pagination" id="pagination"></ul>
      </nav>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/checkList.js"></script>

</body>
</html>

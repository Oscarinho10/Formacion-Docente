<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutAdmin.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asistencias de taller IA</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body class="bg-light">
  <div class="container mt-4">
    <h4 class="mb-4">Lista de Asistencia</h4>

    <!-- Filtros -->
    <div class="row mb-4">
      <div class="col-12 col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered" id="tablaAsistencias">
        <thead class="table-light">
          <tr>
            <th>Nombre participante</th>
            <th>No. Control / RFC</th>
            <th>Correo Electrónico</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div id="paginationInfo"></div>
      <ul class="pagination" id="pagination"></ul>
      <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/checkList.php'" class="btn btn-dark">
        <i class="fas fa-arrow-left"></i> Regresar
      </button>
    </div>

  </div>



  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
  <script src="<?php echo BASE_URL; ?>/Administrador/js/listActivity.js"></script>

  <?php include('../Administrador/modalAdmin/detailsListActivity.php') ?>
  <?php include('../Administrador/modalAdmin/modalAsistSessionsActivity.php') ?>
  <?php include('../Administrador/modalAdmin/modalEntrega.php') ?>

</body>

</html>
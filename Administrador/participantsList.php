<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutAdmin.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Asistencias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Estilos -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body class="bg-light">

  <div class="container my-4">

    <div class="card-body">
      <h4 class="mb-4">Lista de Participantes</h4>

      <!-- Filtros -->
      <div class="row mb-3">
        <div class="col-md-6 ">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" id="searchInput" placeholder="Buscar participante...">
          </div>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead class="table-light" id="theadAsistencias">
            <!-- Aquí se insertarán dinámicamente las fechas desde JS -->
          </thead>
          <tbody id="asistenciaBody">
            <!-- Contenido dinámico -->
          </tbody>
        </table>
      </div>

      <!-- Paginación y acciones -->
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mt-3 gap-2">
        <div id="paginationInfo" class="w-100 w-md-auto"></div>

        <div class="table-pagination-wrapper w-100 w-md-auto">
          <ul class="pagination mb-0" id="pagination"></ul>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto justify-content-md-end">
          <button class="btn btn-success" onclick="prepararImpresion()">
            <i class="fas fa-print me-1"></i> Imprimir
          </button>
          <a href="checkList.php" class="btn btn-dark btn-compact">
            <i class="fas fa-arrow-left me-1"></i> Regresar
          </a>
        </div>
      </div>


    </div>

  </div>

  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script src="<?php echo BASE_URL; ?>/Administrador/js/participantsList.js"></script>

</body>

</html>
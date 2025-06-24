<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Gestionar Administradores</title>
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
        <h3 class="mb-0">Gestionar Administradores</h3>
      </div>

      <!-- Filtros -->
      <div class="row g-2 mb-4">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
          </div>
        </div>

        <div class="col-md-6 text-end">
          <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/addAdmin.php'" class="btn btn-primary w-80 w-md-auto">
           <i class="fas fa-plus"></i> Agregar administrador
          </button>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered text-center" id="tablaActividades">
          <thead class="table-light">
            <tr>
              <th>Nombre</th>
              <th>Correo electrónico</th>
              <th>Número de control</th>
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
      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div id="paginationInfo" class="text-muted"></div>
        <ul class="pagination mb-0" id="pagination"></ul>
        <button onclick="window.location.href='<?php echo BASE_URL; ?>/SuperAdmin/audit.php'" class="btn btn-dark">
          <i class="fas fa-arrow-left me-1"></i> Regresar
        </button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/manageAdmin.js"></script>
</body>

</html>

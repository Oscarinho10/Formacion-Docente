<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Constancias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Estilos -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body class="bg-light">

  <div class="container my-4">
    
      <div class="card-body">
        <h4 class="mb-4">Lista de constancias por grupos</h4>

        <!-- Filtros -->
        <div class="row g-2 mb-3">
          <div class="col-12 col-md-4">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
              <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre...">
            </div>
          </div>

          <div class="col-12 col-md-4">
            <input type="date" id="filterFecha" class="form-control">
          </div>

          <div class="col-12 col-md-4 text-md-end">
            <button id="clearFiltersBtn" class="btn btn-outline-secondary w-100 w-md-auto">Limpiar filtros</button>
          </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="studentsTable">
            <thead class="table-light">
              <tr>
                <th>Nombre</th>
                <th>Fecha actividad</th>
                <th>Tipo</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <!-- Rellenado por JS -->
            </tbody>
          </table>
        </div>

        <!-- Paginación y botón regresar -->
        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
          <div id="paginationInfo" class="text-muted"></div>
          <ul class="pagination mb-0" id="pagination"></ul>
          <a href="<?php echo BASE_URL; ?>/SuperAdmin/initSuper.php" class="btn btn-dark">
            <i class="fas fa-arrow-left me-1"></i> Regresar
          </a>
        </div>
      </div>
 
  </div>

  <!-- Scripts -->
  <script src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/constancy.js"></script>

</body>
</html>

<?php
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // Esto asegura el acceso solo a superAdmins

include('../components/layoutSuper.php');
?>

<?php
$idActividad = isset($_GET['id']) ? $_GET['id'] : null;

if ($idActividad) {
  // Aquí vas a consultar todos los participantes que cumplieron con la actividad
} else {
  echo "Faltan parámetros para mostrar la constancia.";
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Generar Constancias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
</head>

<body class="bg-light">

  <div class="container my-4">

    <div class="card-body">
      <h4 class="mb-4">Generar Constancias</h4>

      <!-- Filtros de búsqueda -->
      <div class="row g-2 align-items-end mb-4">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar participante...">
          </div>
        </div>
        <div class="col-md-6 text-md-end">
          <button class="btn btn-primary w-80 w-md-auto" id="btnAll"
            onclick="window.open('controller/generateAllConstancys.php?id_actividad=' + actividadId, '_blank');">
            Generar Constancias de Todos
          </button>

        </div>
      </div>

      <!-- Tabla de Participantes -->
      <div class="table-responsive">
        <table class="table table-bordered text-center" id="studentsTable">
          <thead class="table-light">
            <tr>
              <th><input type="checkbox" id="selectAll"></th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <!-- Rellenado por JavaScript -->
          </tbody>
        </table>
      </div>

      <!-- Paginación y botón de regreso -->
      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div id="paginationInfo" class="text-muted"></div>
        <ul class="pagination mb-0" id="pagination"></ul>
        <a href="<?php echo BASE_URL; ?>/SuperAdmin/constancy.php" class="btn btn-dark">
          <i class="fas fa-arrow-left me-1"></i> Regresar
        </a>
      </div>
    </div>

  </div>

  <!-- Scripts -->

  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script>
    const actividadId = <?php echo isset($_GET['id']) ? intval($_GET['id']) : 'null'; ?>;
  </script>
  <script src="<?php echo BASE_URL; ?>/SuperAdmin/js/seeConstancy.js"></script>




</body>

</html>
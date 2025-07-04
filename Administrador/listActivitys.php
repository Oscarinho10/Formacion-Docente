<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Lista de Actividades</title>

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

  <div class="container mt-4">
    <h4 class="mb-3">Lista de actividades</h4>

    <!--Filtros y boton de agregar-->
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="text" class="form-control" id="searchInput" placeholder="Buscar actividad...">
        </div>
      </div>
      <div class="col-md-6 text-end">
        <a href="addActivity.php" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar</a>
      </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>Nombre de la Actividad</th>
            <th>Total de Horas</th>
            <th class="text-center">Estado</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody id="activityTableBody">
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

<!-- Exprtación del modal -->
<?php include('../Administrador/modalAdmin/detailsActivityModal.php'); ?> 
  
  <!-- UNA sola línea, carga Bootstrap + Popper -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/listActivitysScript.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>


  
</body>

</html>
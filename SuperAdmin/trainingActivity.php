<?php include('../components/layoutSuper.php'); ?>
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
    <h4 class="mb-3">Lista de Actividades</h4>

    <!-- Botón agregar -->
    <div class="d-flex justify-content-end mb-3">
      <a href="addTrainingActivity.php" class="btn btn-primary">+ Agregar Actividad</a>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="thead-light">
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
  </div>

  <!-- Bootstrap JS -->
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/trainingActivity.js"></script>
</body>

</html>

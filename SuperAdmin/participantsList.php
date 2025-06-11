<?php include('../components/layoutSuper.php') ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Asistencias</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body>

<div class="container mt-4" style="max-width: 1000px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Asistencias</h4>

    <div class="input-group" style="max-width: 250px;">
      <div class="input-group-prepend">
        <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
      </div>
      <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="table text-center table-bordered">
      <thead class="thead-light">
        <tr>
          <th>Nombre</th>
          <th>20/03/2025</th>
          <th>20/05/2025</th>
          <th>20/08/2025</th>
          <th>20/09/2025</th>
          <th>Constancia</th>
        </tr>
      </thead>
      <tbody id="asistenciaBody">
        <!-- Filas dinámicas -->
      </tbody>
    </table>
  </div>

  <div class="text-right mt-3">
    <button class="btn btn-success mr-2" onclick="window.print()">Imprimir</button>
     <a href="checkList.php" class="btn btn-dark">
          <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
  </div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/participantsList.js"></script>

</body>
</html>

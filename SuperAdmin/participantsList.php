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
    <h4 class="mb-3">Lista participantes</h4>
    <div class="form-row mb-3">
      <div class="col-md-6">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
          <input type="text" class="form-control" id="searchInput" placeholder="Buscar...">
        </div>
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

    <!-- Paginación -->
    <div class="d-flex justify-content-between align-items-center mt-3">
      <div id="paginationInfo"></div>
      <ul class="pagination" id="pagination"></ul>
      
      <button class="btn btn-success mr-2" onclick="window.print()"><i class="fas fa-print"></i>
      Imprimir</button>
      <a href="checkList.php" class="btn btn-dark">
        <i class="fas fa-arrow-left mr-2"></i> Regresar
      </a>
    </div>

  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/participantsList.js"></script>

</body>

</html>
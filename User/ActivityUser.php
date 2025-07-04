<?php 
include_once('../config/verificaRol.php');
verificarRol('usuario'); // o el rol que aplique
include('../components/layout.php'); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Actividades Disponibles</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/tabla.css">
  <link rel="stylesheet" href="../assets/css/estilo.css">
  <link rel="stylesheet" href="../assets/fontawesome/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
  <h4 class="mb-3">Actividades Disponibles</h4>

  <div class="row mb-3">
    <div class="col-md-6">
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" class="form-control" id="searchInput" placeholder="Buscar actividad...">
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Nombre</th>
          <th>Horas</th>
          <th>Modalidad</th>
          <th>Cupo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tableBody"></tbody>
    </table>
  </div>

  <div class="d-flex justify-content-between align-items-center mt-3">
    <div id="paginationInfo"></div>
    <ul class="pagination" id="pagination"></ul>
  </div>
</div>

<!-- Modal de detalles -->
<?php include('modalDetalles.php'); ?>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sweetAlert2.js"></script>
<script src="js/actividadUser.js"></script>
</body>
</html>

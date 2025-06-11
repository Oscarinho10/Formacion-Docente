<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Asistencias de taller IA</title>

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" type="text/css">
</head>

<body class="bg-light">
  <div class="container mt-4 d-flex justify-content-center">
    <div style="width: 100%; max-width: 1000px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Lista de Asistencia</h3>
      </div>

      <!-- Filtros -->
      <div class="form-row mb-4">
        <div class="col-md-6">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
          </div>
        </div>
      </div>

      <!-- Tabla -->
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaAsistencias">
          <thead class="thead-light">
            <tr>
              <th>Nombre Instructor</th>
              <th>No. Control</th>
              <th>Correo Electrónico</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>

      <!-- Paginador -->
      <div class="d-flex justify-content-between align-items-center mt-3">
        <div id="paginationInfo" class="text-muted"></div>
        <ul class="pagination" id="pagination"></ul>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Registrar asistencia</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <p id="nombreParticipante" class="font-weight-bold text-primary"></p>
          <input type="text" id="fechaAsistencia" class="form-control mt-2 mb-3" placeholder="Haz clic para elegir fechas" readonly />
          <div id="listaFechasSeleccionadas" class="text-left small text-dark font-weight-bold"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button class="btn btn-success" id="guardarAsistencia">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/listActivity.js"></script>
</body>

</html>
<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Actividad</title>

  <!-- Estilos Bootstrap -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body>
  <div class="container d-flex justify-content-center my-4">
    <div class="card shadow-sm w-100" style="max-width: 900px;">
      <div class="card-body">
        <h4 class="text-center mb-3">Registro de actividad formativa</h4>

        <form action="procesar_actividad.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12 col-md-4 mb-3">
              <label for="nombre_actividad" class="form-label">Nombre de la actividad:</label>
              <input type="text" name="nombre_actividad" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="instructores" class="form-label">Selecciona los instructores:</label>
              <select name="instructores[]" multiple class="form-select" style="height: 100px;">
                <option value="1">Juan Perez</option>
                <option value="2">Juana Teresa</option>
                <option value="3">Carlos López</option>
              </select>
              <small class="text-muted">Puedes seleccionar varios con Ctrl o Cmd</small>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="lugar" class="form-label">Lugar:</label>
              <input type="text" name="lugar" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="dirigido_a" class="form-label">Dirigido a:</label>
              <input type="text" name="dirigido_a" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="modalidad" class="form-label">Modalidad:</label>
              <select name="modalidad" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="linea">En línea</option>
                <option value="presencial">Presencial</option>
                <option value="hibrido">Híbrido</option>
              </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="clasificacion" class="form-label">Clasificación:</label>
              <input type="text" name="clasificacion" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="num_participantes" class="form-label">Número de participantes:</label>
              <input type="text" name="num_participantes" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="total_participantes" class="form-label">Total participantes:</label>
              <input type="text" name="total_participantes" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="total_horas" class="form-label">Total de horas:</label>
              <input type="text" name="total_horas" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
              <input type="date" name="fecha_inicio" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="fecha_fin" class="form-label">Fecha de fin:</label>
              <input type="date" name="fecha_fin" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="hora_inicio" class="form-label">Hora de inicio:</label>
              <input type="time" name="hora_inicio" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="hora_fin" class="form-label">Hora de fin:</label>
              <input type="time" name="hora_fin" class="form-control" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="temario_pdf" class="form-label">Agregar temario en PDF:</label>
              <input type="file" name="temario_pdf" class="form-control" accept=".pdf">
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="imagen" class="form-label">Agregar imagen:</label>
              <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>
          </div>

          <div class="d-flex justify-content-end mt-3 flex-wrap">
            <a href="./trainingActivity.php" class="btn btn-danger me-2 mb-3">Cancelar</a>
            <button type="submit" class="btn btn-general btn-sm mb-2 btn-editar">Registrar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

   <!-- Scripts necesarios -->
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/addTrainingActivity.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

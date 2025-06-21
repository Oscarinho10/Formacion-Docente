<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar participantes</title>

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body>
  <div class="container my-4">
    <div class="card shadow-sm mx-auto" style="max-width: 800px;">
      <div class="card-body">
        <h4 class="text-center mb-3">
          Formulario de registro de participantes<br>
          <strong><?php echo htmlspecialchars($nombre_curso); ?></strong>
        </h4>

        <form action="procesar_inscripcion.php" method="post">
          <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="apellido_paterno">Apellido Paterno</label>
              <input type="text" class="form-control" name="apellido_paterno" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="apellido_materno">Apellido Materno</label>
              <input type="text" class="form-control" name="apellido_materno" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="sexo">Sexo</label>
              <select class="form-control" name="sexo" required>
                <option value="">Seleccione</option>
                <option value="H">Hombre</option>
                <option value="M">Mujer</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="edad">Edad</label>
              <input type="number" class="form-control" name="edad" required>
            </div>

            <div class="col-md-4 mb-3">
              <label for="control_rfc">Número de control o RFC</label>
              <input type="text" class="form-control" name="control_rfc" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="correo">Correo electrónico</label>
              <input type="email" class="form-control" name="correo" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="perfil">Perfil Académico</label>
              <select class="form-control" name="unidadAcaddemica" required>
                <option value="">Seleccione</option>
                <option value="M">Docente</option>
                <option value="D">Doctorado</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="unidad_academica">Unidad Académica</label>
              <select class="form-control" name="unidadAcaddemica" required>
                <option value="">Seleccione</option>
                <option value="M">Medicina</option>
                <option value="D">Derecho</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="unidad_academica">Grado académico</label>
              <select class="form-control" name="unidadAcaddemica" required>
                <option value="">Seleccione</option>
                <option value="M">Medicina</option>
                <option value="D">Derecho</option>
              </select>
            </div>


          </div>

          <div class="d-flex justify-content-end mt-3">
            <a href="./requestSuper.php" class="btn btn-danger mr-2">Cancelar</a>
            <button type="submit" class="btn btn-general btn-sm">Registrar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</body>

</html>
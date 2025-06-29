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
  <div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm w-100" style="max-width: 800px;">
      <div class="card-body">
        <h4 class="text-center mb-3">
          Formulario de registro de participantes<br>
          <strong><?php echo htmlspecialchars($nombre_curso); ?></strong>
        </h4>

        <form action="procesar_inscripcion.php" method="post">
          <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

          <div class="row">
            <div class="col-12 col-md-4 mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col-12 col-md-4 mb-3">
              <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
              <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
            </div>
            <div class="col-12 col-md-4 mb-3">
              <label for="apellido_materno" class="form-label">Apellido Materno</label>
              <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="sexo" class="form-label">Sexo</label>
              <select class="form-select" id="sexo" name="sexo" required>
                <option value="">Seleccione</option>
                <option value="H">Hombre</option>
                <option value="M">Mujer</option>
              </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="edad" class="form-label">Edad</label>
              <input type="number" class="form-control" id="edad" name="edad" required>
            </div>

            <div class="col-12 col-md-4 mb-3">
              <label for="control_rfc" class="form-label">Número de control o RFC</label>
              <input type="text" class="form-control" id="control_rfc" name="control_rfc" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="perfil_academico" class="form-label">Perfil Académico</label>
              <select class="form-select" id="perfil_academico" name="perfil_academico" required>
                <option value="">Seleccione</option>
                <option value="Docente">Docente</option>
                <option value="Doctorado">Doctorado</option>
              </select>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="unidad_academica" class="form-label">Unidad Académica</label>
              <select class="form-select" id="unidad_academica" name="unidad_academica" required>
                <option value="">Seleccione</option>
                <option value="Medicina">Medicina</option>
                <option value="Derecho">Derecho</option>
              </select>
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="grado_academico" class="form-label">Grado Académico</label>
              <select class="form-select" id="grado_academico" name="grado_academico" required>
                <option value="">Seleccione</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestría">Maestría</option>
                <option value="Doctorado">Doctorado</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end mt-3 flex-wrap">
            <a href="./requestSuper.php" class="btn btn-danger me-2 mb-2 btn-cancelar">Cancelar</a>
            <button type="submit" class="btn btn-general btn-sm mb-2 btn-aceptar">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Scripts necesarios -->
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/addUser.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
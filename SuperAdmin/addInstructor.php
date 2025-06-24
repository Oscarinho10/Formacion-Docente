<?php include('../components/layoutSuper.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Participante</title>

  <!-- Recursos Bootstrap y personalizados -->
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
    <div class="card shadow-sm w-100" style="max-width: 600px;">
      <div class="card-body">
        <h4 class="text-center mb-4">Registro de instructores</h4>

        <form action="procesar_agregar.php" method="post">
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
              <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="apellido_materno" class="form-label">Apellido Materno</label>
              <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="sexo" class="form-label">Sexo</label>
              <select name="sexo" id="sexo" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="H">Hombre</option>
                <option value="M">Mujer</option>
              </select>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="edad" class="form-label">Edad</label>
              <input type="number" name="edad" id="edad" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label for="numero_control" class="form-label">Número de Control</label>
              <input type="text" name="numero_control" id="numero_control" class="form-control" required>
            </div>
            <div class="col-12 mb-3">
              <label for="correo" class="form-label">Correo Electrónico</label>
              <input type="email" name="correo" id="correo" class="form-control" required>
            </div>

            <div class="col-12 mb-3">
              <label for="perfil_academico" class="form-label">Perfil Académico</label>
              <select name="perfil_academico" id="perfil_academico" class="form-select" required>
                <option value="">Seleccione perfil</option>
                <option value="Docente">Docente</option>
                <option value="Investigador">Investigador</option>
              </select>
            </div>

            <div class="col-12 mb-3">
              <label for="unidad_academica" class="form-label">Unidad Académica</label>
              <select name="unidad_academica" id="unidad_academica" class="form-select" required>
                <option value="">Seleccione unidad académica</option>
                <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
                <option value="Facultad de Ciencias">Facultad de Ciencias</option>
                <option value="Facultad de Medicina">Facultad de Medicina</option>
                <option value="Facultad de Derecho">Facultad de Derecho</option>
                <option value="Facultad de Arquitectura">Facultad de Arquitectura</option>
              </select>
            </div>

            <div class="col-12 mb-4">
              <label for="grado_academico" class="form-label">Grado Académico</label>
              <select name="grado_academico" id="grado_academico" class="form-select" required>
                <option value="">Seleccione grado</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestría">Maestría</option>
                <option value="Doctorado">Doctorado</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end flex-wrap">
            <a href="./instructorSuper.php" class="btn btn-danger me-2 mb-2">Cancelar</a>
            <button type="submit" class=" btn btn-general btn-sm mb-2  btn-registrar">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Scripts necesarios -->
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/addInstructor.js"></script>
  <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
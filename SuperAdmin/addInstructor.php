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
  <div class="container my-4">
    <div class="card shadow-sm mx-auto" style="max-width: 600px;">
      <div class="card-body">
        <h4 class="text-center mb-4">Registro de instructores</h4>

        <form action="procesar_agregar.php" method="post">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="apellido_paterno">Apellido Paterno</label>
              <input type="text" name="apellido_paterno" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="apellido_materno">Apellido Materno</label>
              <input type="text" name="apellido_materno" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="sexo">Sexo</label>
              <select name="sexo" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="H">Hombre</option>
                <option value="M">Mujer</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label for="edad">Edad</label>
              <input type="number" name="edad" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="numero_control">Número de Control</label>
              <input type="text" name="numero_control" class="form-control" required>
            </div>
            <div class="col-md-12 mb-3">
              <label for="correo">Correo Electrónico</label>
              <input type="email" name="correo" class="form-control" required>
            </div>
               <div class="col-md-12 mb-3">
              <label for="unidad_academica">Perfil académico</label>
              <select name="unidad_academica" class="form-control" required>
                <option value="">Seleccione unidad académica</option>
                <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
                <option value="Facultad de Ciencias">Facultad de Ciencias</option>
                <option value="Facultad de Medicina">Facultad de Medicina</option>
                <option value="Facultad de Derecho">Facultad de Derecho</option>
                <option value="Facultad de Arquitectura">Facultad de Arquitectura</option>
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <label for="unidad_academica">Unidad Académica</label>
              <select name="unidad_academica" class="form-control" required>
                <option value="">Seleccione unidad académica</option>
                <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
                <option value="Facultad de Ciencias">Facultad de Ciencias</option>
                <option value="Facultad de Medicina">Facultad de Medicina</option>
                <option value="Facultad de Derecho">Facultad de Derecho</option>
                <option value="Facultad de Arquitectura">Facultad de Arquitectura</option>
              </select>
            </div>
            <div class="col-md-12 mb-4">
              <label for="grado_academico">Grado Académico</label>
              <select name="grado_academico" class="form-control" required>
                <option value="">Seleccione grado</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestría">Maestría</option>
                <option value="Doctorado">Doctorado</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <a href="./instructorSuper.php" class="btn btn-danger mr-2">Cancelar</a>
            <button type="submit" class="btn btn-general btn-sm">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</body>

</html>

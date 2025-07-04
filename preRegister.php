<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro Participante</title>

  <!-- Recursos CSS -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css" />

  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css" />
</head>

<body>
  <?php include('HeadAndFoot/header.php'); ?>

  <div class="container my-4">
    <div class="card shadow-sm mx-auto" style="max-width: 900px;">
      <div class="card-body">
        <h4 class="text-center mb-3">Formulario pre registro</h4>

        <form action="procesar_actividad.php" method="post" enctype="multipart/form-data">
          <div class="row">

            <!-- Nombre -->
            <div class="col-md-4 mb-3">
              <label for="nombre">Nombre:</label>
              <input type="text" name="nombre" id="nombre" style="width: 100%; padding: 8px;" required>
            </div>

            <!-- Apellido Paterno -->
            <div class="col-md-4 mb-3">
              <label for="apellido_paterno">Apellido Paterno:</label>
              <input type="text" name="apellido_paterno" id="apellido_paterno" style="width: 100%; padding: 8px;" required>
            </div>

            <!-- Apellido Materno -->
            <div class="col-md-4 mb-3">
              <label for="apellido_materno">Apellido Materno:</label>
              <input type="text" name="apellido_materno" id="apellido_materno" style="width: 100%; padding: 8px;" required>
            </div>

            <!-- Fecha de nacimiento -->
            <div class="col-md-4 mb-3">
              <label for="fecha_nacimiento">Fecha de nacimiento:</label>
              <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" style="width: 100%; padding: 8px;" required min="1930-01-01" max="2025-12-31">
            </div>

            <!-- Sexo -->
            <div class="col-md-4 mb-3">
              <label for="sexo">Sexo:</label>
              <select name="sexo" id="sexo" style="width: 100%; padding: 12px;" required>
                <option value="">Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="No especificado">Prefiero no decirlo</option>
              </select>
            </div>

            <!-- Correo -->
            <div class="col-md-4 mb-3">
              <label for="correo">Correo electrónico:</label>
              <input type="email" name="correo" id="correo" style="width: 100%; padding: 8px;" required>
            </div>

            <!-- No. Control -->
            <div class="col-md-4 mb-3">
              <label for="numero_control">Número de control:</label>
              <input type="text" name="numero_control" id="numero_control" style="width: 100%; padding: 8px;" required>
            </div>

            <!-- Unidad Académica -->
            <div class="col-md-4 mb-3">
              <label for="unidad_academica">Unidad Académica:</label>
              <select name="unidad_academica" id="unidad_academica" style="width: 100%; padding: 12px;" required>
                <option value="">Seleccione</option>
                <option value="Tepetongo">Tepetongo</option>
                <option value="Chamilpa">Chamilpa</option>
                <option value="Cuautla">Cuautla</option>
              </select>
            </div>

            <!-- Grado Académico -->
            <div class="col-md-4 mb-3">
              <label for="grado_academico">Grado Académico:</label>
              <select name="grado_academico" id="grado_academico" style="width: 100%; padding: 12px;" required>
                <option value="">Seleccione</option>
                <option value="Licenciado">Licenciado</option>
                <option value="Ingeniero">Ingeniero</option>
                <option value="Maestro">Maestro</option>
              </select>
            </div>

            <!-- Perfil Académico -->
            <div class="col-md-4 mb-3">
              <label for="perfil_academico">Perfil Académico:</label>
              <select name="perfil_academico" id="perfil_academico" style="width: 100%; padding: 12px;" required>
                <option value="">Seleccione</option>
                <option value="Tiempo completo">Tiempo completo</option>
                <option value="Medio tiempo">Medio tiempo</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end col-12 mt-3">
              <button type="button" onclick="window.location.href='<?php echo BASE_URL; ?>/login.php'" class="btn btn-sm btn-danger mr-3 col-2 py-2">Cancelar</button>
              <button type="submit" class="btn btn-sm btn-general col-2">Registrar</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include('HeadAndFoot/footer.php'); ?>
</body>

</html>

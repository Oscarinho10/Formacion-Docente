<?php
define('BASE_URL', '/formacion/PROYECTO/Formacion-Docente');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro Participante</title>

  <!-- CSS -->
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
        <form action="./config/controller/preRegisterController.php" method="post" enctype="multipart/form-data">
          <div class="row g-3">
            <!-- Nombre -->
            <div class="col-md-4 col-12">
              <label for="nombre" class="form-label">Nombre:</label>
              <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <!-- Apellido Paterno -->
            <div class="col-md-4 col-12">
              <label for="apellido_paterno" class="form-label">Apellido Paterno:</label>
              <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" required>
            </div>

            <!-- Apellido Materno -->
            <div class="col-md-4 col-12">
              <label for="apellido_materno" class="form-label">Apellido Materno:</label>
              <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" required>
            </div>

            <!-- Fecha de nacimiento -->
            <div class="col-md-4 col-12">
              <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
              <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required min="1930-01-01" max="2025-12-31">
            </div>

            <!-- Sexo -->
            <div class="col-md-4 col-12">
              <label for="sexo" class="form-label">Sexo:</label>
              <select name="sexo" id="sexo" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="NoEspecificado">Prefiero no decirlo</option>
              </select>
            </div>

            <!-- Correo -->
            <div class="col-md-4 col-12">
              <label for="correo" class="form-label">Correo electrónico:</label>
              <input type="email" name="correo" id="correo" class="form-control" required>
            </div>

            <!-- Número de control -->
            <div class="col-md-4 col-12">
              <label for="numero_control" class="form-label">Número de control:</label>
              <input type="text" name="numero_control" id="numero_control" class="form-control" required>
            </div>

            <!-- Grado Académico -->
            <div class="col-md-4 col-12">
              <label for="grado_academico" class="form-label">Grado Académico:</label>
              <select name="grado_academico" id="grado_academico" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestria">Maestría</option>
                <option value="Doctorado">Doctorado</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <!-- Perfil Académico -->
            <div class="col-md-4 col-12">
              <label for="perfil_academico" class="form-label">Perfil Académico:</label>
              <select name="perfil_academico" id="perfil_academico" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="PTP">PROFESOR TIEMPO PARCIAL</option>
                <option value="PITP">PROFESOR INVESTIGADOR DE TIEMPO PARCIAL</option>
                <option value="PTC">PROFESOR TIEMPO COMPLETO</option>
                <option value="PITC">PROFESOR INVESTIGADOR DE TIEMPO COMPLETO</option>
                <option value="TA">TECNICO ACADEMICO</option>
                <option value="TC">TECNICO CULTURAL</option>
                <option value="ADMIN">ADMINISTRATIVO</option>
              </select>
            </div>

            <!-- Unidad Académica -->
            <div class="col-12">
              <label for="unidad_academica" class="form-label">Unidad Académica:</label>
              <select name="unidad_academica" id="unidad_academica" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="Centro de Investigación Interdisciplinar para el Desarrollo Universitario">Centro de Investigación Interdisciplinar para el Desarrollo Universitario</option>
                <option value="Centro de Investigación Transdisciplinar en Psicología">Centro de Investigación Transdisciplinar en Psicología</option>
                <option value="Centro de Investigación en Biodiversidad y Conservación">Centro de Investigación en Biodiversidad y Conservación</option>
                <option value="Centro de Investigaciones Biológicas">Centro de Investigaciones Biológicas</option>
                <option value="Centro de Investigación en Biotecnología">Centro de Investigación en Biotecnología</option>
                <option value="Escuela de Estudios Superiores de Atlatlahucan">Escuela de Estudios Superiores de Atlatlahucan</option>
                <option value="Escuela de Estudios Superiores de Atlatlahucan (Subsede de Totolapan)">Escuela de Estudios Superiores de Atlatlahucan (Subsede de Totolapan)</option>
                <option value="Escuela de Estudios Superiores de Jicarero">Escuela de Estudios Superiores de Jicarero</option>
                <option value="Escuela de Estudios Superiores de Jonacatepec">Escuela de Estudios Superiores de Jonacatepec</option>
                <option value="Escuela de Estudios Superiores de Jonacatepec (Subsede de Axochiapan)">Escuela de Estudios Superiores de Jonacatepec (Subsede de Axochiapan)</option>
                <option value="Escuela de Estudios Superiores de Jonacatepec (Subsede de Tepalcingo)">Escuela de Estudios Superiores de Jonacatepec (Subsede de Tepalcingo)</option>
                <option value="Escuela de Estudios Superiores de Jojutla">Escuela de Estudios Superiores de Jojutla</option>
                <option value="Escuela de Estudios Superiores de Mazatepec">Escuela de Estudios Superiores de Mazatepec</option>
                <option value="Escuela de Estudios Superiores de Mazatepec (Subsede de Miacatlán)">Escuela de Estudios Superiores de Mazatepec (Subsede de Miacatlán)</option>
                <option value="Escuela de Estudios Superiores de Mazatepec (Subsede de Tetecala)">Escuela de Estudios Superiores de Mazatepec (Subsede de Tetecala)</option>
                <option value="Escuela de Estudios Superiores de Xalostoc">Escuela de Estudios Superiores de Xalostoc</option>
                <option value="Escuela de Estudios Superiores de Yautepec">Escuela de Estudios Superiores de Yautepec</option>
                <option value="Escuela de Estudios Superiores de Yecapixtla">Escuela de Estudios Superiores de Yecapixtla</option>
                <option value="Escuela de Estudios Superiores de Yecapixtla (Subsede de Tetela del Volcán)">Escuela de Estudios Superiores de Yecapixtla (Subsede de Tetela del Volcán)</option>
                <option value="Escuela de Teatro, Danza y Música">Escuela de Teatro, Danza y Música</option>
                <option value="Escuela de Turismo">Escuela de Turismo</option>
                <option value="Facultad de Arquitectura">Facultad de Arquitectura</option>
                <option value="Facultad de Artes">Facultad de Artes</option>
                <option value="Facultad de Ciencias Agropecuarias">Facultad de Ciencias Agropecuarias</option>
                <option value="Facultad de Ciencias Biológicas">Facultad de Ciencias Biológicas</option>
                <option value="Facultad de Ciencias del Deporte">Facultad de Ciencias del Deporte</option>
                <option value="Facultad de Ciencias Químicas e Ingeniería">Facultad de Ciencias Químicas e Ingeniería</option>
                <option value="Facultad de Comunicación Humana">Facultad de Comunicación Humana</option>
                <option value="Facultad de Contaduría, Administración e Informática">Facultad de Contaduría, Administración e Informática</option>
                <option value="Facultad de Derecho y Ciencias Sociales">Facultad de Derecho y Ciencias Sociales</option>
                <option value="Facultad de Diseño">Facultad de Diseño</option>
                <option value="Facultad de Enfermería">Facultad de Enfermería</option>
                <option value="Facultad de Estudios Sociales">Facultad de Estudios Sociales</option>
                <option value="Facultad de Estudios Superiores de Cuautla">Facultad de Estudios Superiores de Cuautla</option>
                <option value="Facultad de Farmacia">Facultad de Farmacia</option>
                <option value="Facultad de Medicina">Facultad de Medicina</option>
                <option value="Facultad de Nutrición">Facultad de Nutrición</option>
                <option value="Facultad de Psicología">Facultad de Psicología</option>
                <option value="Instituto de Ciencias de la Educación">Instituto de Ciencias de la Educación</option>
                <option value="Instituto de Investigación en Ciencias Básicas y Aplicadas">Instituto de Investigación en Ciencias Básicas y Aplicadas</option>
                <option value="Instituto de Investigación en Humanidades y Ciencias Sociales">Instituto de Investigación en Humanidades y Ciencias Sociales</option>
              </select>
            </div>
          </div>

          <!-- Botones -->
          <div class="d-flex justify-content-end mt-4">
            <a href="<?php echo BASE_URL; ?>/login.php" class="btn btn-danger me-2">Cancelar</a>
            <button type="submit" class="btn btn-success">Registrar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <?php include('HeadAndFoot/footer.php'); ?>

  <!-- JS -->
  <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
  <script src="<?php echo BASE_URL; ?>/config/js/preRegister.js"></script>
</body>

</html>
<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

// Hasta aquí no se ha enviado contenido, entonces ahora sí
include('../components/layoutAdmin.php');
?>

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
        <div class="card shadow-sm mx-auto" style="max-width: 900px;">
            <div class="card-body">
                <h4 class="text-center mb-3">
                    Formulario de registro de participantes<br>
                    <strong><?php echo htmlspecialchars($nombre_curso); ?></strong>
                </h4>

                <form action="./controller/addParticipantController.php" method="post" enctype="multipart/form-data">
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
                            <select name="sexo" id="sexo" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="No Especificado">Prefiero no decirlo</option>
                            </select>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-4 mb-3">
                            <label for="correo_electronico">Correo electrónico:</label>
                            <input type="email" name="correo_electronico" id="correo_electronico" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- No. Control -->
                        <div class="col-md-4 mb-3">
                            <label for="numero_control">Número de control:</label>
                            <input type="text" name="numero_control" id="numero_control" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Grado Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="grado_academico">Grado Académico</label>
                            <select style="width: 100%; padding: 11px;" id="grado_academico" name="grado_academico" required>
                                <option value="">Seleccione</option>
                                <option value="Licenciatura">Licenciatura</option>
                                <option value="Maestria">Maestría</option>
                                <option value="Doctorado">Doctorado</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <!-- Perfil Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="perfil_academico">Perfil Académico</label>
                            <select style="width: 100%; padding: 11px;" id="perfil_academico" name="perfil_academico" required>
                                <option value="">Seleccione</option>
                                <option value="N/A">No aplica</option>
                                <option value="PTP">PROFESOR TIEMPO PARCIAL</option>
                                <option value="PITP">PROFESOR INVESTIGADOR DE TIEMPO PARCIAL</option>
                                <option value="PTC">PROFESOR TIEMPO COMPLETO</option>
                                <option value="PITC">PROFESOR INVESTIGADOR DE TIEMPO COMPLETO</option>
                                <option value="TA">TECNICO ACADEMICO</option>
                                <option value="TC">TECNICO CULTURAL</option>
                                <option value="ADMIN">ADMINISTRATIVO</option>
                            </select>
                        </div>
                    </div>

                    <!-- Unidad Académica -->
                    <div class="col-md-12 mb-3">
                        <label for="unidad_academica" class="form-label">Unidad Académica</label>
                        <select style="width: 100%; padding: 11px;" id="unidad_academica" name="unidad_academica" required>
                            <option value="">Seleccione</option>
                            <option value="N/A">No aplica</option>
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

                    <!-- Botones -->
                    <div class="d-flex justify-content-end col-12 mb-10 mt-3 btn-responsive-container">
                        <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/listParticipants.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-general me-2 col-2 py-2">Registrar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>/Administrador/js/addParticipant.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
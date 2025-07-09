<?php
include_once('../config/verificaRol.php');
verificarRol('admin'); // Esto asegura el acceso solo a admins

include('../components/layoutAdmin.php');
include('../config/conexion.php');

// Obtener ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de instructor inválido.";
    exit;
}

$id = intval($_GET['id']);
$query = pg_query($conn, "SELECT * FROM usuarios WHERE id_usuario = $id");
$usuario = pg_fetch_assoc($query);

if (!$usuario) {
    echo "Instructor no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Instructor</title>

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
        <div class="card shadow-sm mx-auto" style="max-width: 900px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Editar Instructor</h4>

                <form action="../Administrador/controller/editInstructorController.php" method="post">
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $usuario['nombre']; ?>" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="apellido_paterno">Apellido Paterno:</label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno" value="<?php echo $usuario['apellido_paterno']; ?>" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="apellido_materno">Apellido Materno:</label>
                            <input type="text" name="apellido_materno" id="apellido_materno" value="<?php echo $usuario['apellido_materno']; ?>" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>" style="width: 100%; padding: 8px;" required min="1930-01-01" max="2025-12-31">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sexo">Sexo:</label>
                            <select name="sexo" id="sexo" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="H" <?php if ($usuario['sexo'] == 'H') echo 'selected'; ?>>Masculino</option>
                                <option value="M" <?php if ($usuario['sexo'] == 'M') echo 'selected'; ?>>Femenino</option>
                                <option value="Otro" <?php if ($usuario['sexo'] == 'Otro') echo 'selected'; ?>>Prefiero no decirlo</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="correo">Correo electrónico:</label>
                            <input type="text" name="correo_electronico" id="correo" value="<?php echo $usuario['correo_electronico']; ?>" style="width: 100%; padding: 8px;" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="numero_control_rfc">Número de control:</label>
                            <input type="text" name="numero_control_rfc" id="numero_control_rfc" value="<?php echo $usuario['numero_control_rfc']; ?>" style="width: 100%; padding: 8px;" required>
                        </div>

                        <!-- Grado Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="grado_academico">Grado Académico</label>
                            <select style="width: 100%; padding: 11px;" id="grado_academico" name="grado_academico" required>
                                <option value="">Seleccione</option>
                                <option value="Licenciatura" <?php if ($usuario['grado_academico'] == 'Licenciatura') echo 'selected'; ?>>Licenciatura</option>
                                <option value="Maestria" <?php if ($usuario['grado_academico'] == 'Maestria') echo 'selected'; ?>>Maestría</option>
                                <option value="Doctorado" <?php if ($usuario['grado_academico'] == 'Doctorado') echo 'selected'; ?>>Doctorado</option>
                                <option value="Otro" <?php if ($usuario['grado_academico'] == 'Otro') echo 'selected'; ?>>Otro</option>
                            </select>
                        </div>

                        <!-- Perfil Académico -->
                        <div class="col-md-4 mb-3">
                            <label for="perfil_academico">Perfil Académico</label>
                            <select style="width: 100%; padding: 11px;" id="perfil_academico" name="perfil_academico" required>
                                <option value="">Seleccione</option>
                                <option value="N/A" <?php if ($usuario['perfil_academico'] == 'N/A') echo 'selected'; ?>>No aplica</option>
                                <option value="PTP" <?php if ($usuario['perfil_academico'] == 'PTP') echo 'selected'; ?>>PROFESOR TIEMPO PARCIAL</option>
                                <option value="PITP" <?php if ($usuario['perfil_academico'] == 'PITP') echo 'selected'; ?>>PROFESOR INVESTIGADOR DE TIEMPO PARCIAL</option>
                                <option value="PTC" <?php if ($usuario['perfil_academico'] == 'PTC') echo 'selected'; ?>>PROFESOR TIEMPO COMPLETO</option>
                                <option value="PITC" <?php if ($usuario['perfil_academico'] == 'PITC') echo 'selected'; ?>>PROFESOR INVESTIGADOR DE TIEMPO COMPLETO</option>
                                <option value="TA" <?php if ($usuario['perfil_academico'] == 'TA') echo 'selected'; ?>>TECNICO ACADEMICO</option>
                                <option value="TC" <?php if ($usuario['perfil_academico'] == 'TC') echo 'selected'; ?>>TECNICO CULTURAL</option>
                                <option value="ADMIN" <?php if ($usuario['perfil_academico'] == 'ADMIN') echo 'selected'; ?>>ADMINISTRATIVO</option>
                            </select>
                        </div>

                    </div>


                    <!-- Unidad Académica -->
                    <div class="col-md-12 mb-3">
                        <label for="unidad_academica" class="form-label">Unidad Académica</label>
                        <select style="width: 100%; padding: 11px;" id="unidad_academica" name="unidad_academica" required>
                            <option value="">Seleccione</option>
                            <option value="N/A" <?php if ($usuario['unidad_academica'] == 'N/A') echo 'selected'; ?>>No aplica</option>
                            <option value="Centro de Investigación Interdisciplinar para el Desarrollo Universitario" <?php if ($usuario['unidad_academica'] == 'Centro de Investigación Interdisciplinar para el Desarrollo Universitario') echo 'selected'; ?>>Centro de Investigación Interdisciplinar para el Desarrollo Universitario</option>
                            <option value="Centro de Investigación Transdisciplinar en Psicología" <?php if ($usuario['unidad_academica'] == 'Centro de Investigación Transdisciplinar en Psicología') echo 'selected'; ?>>Centro de Investigación Transdisciplinar en Psicología</option>
                            <option value="Centro de Investigación en Biodiversidad y Conservación" <?php if ($usuario['unidad_academica'] == 'Centro de Investigación en Biodiversidad y Conservación') echo 'selected'; ?>>Centro de Investigación en Biodiversidad y Conservación</option>
                            <option value="Centro de Investigaciones Biológicas" <?php if ($usuario['unidad_academica'] == 'Centro de Investigaciones Biológicas') echo 'selected'; ?>>Centro de Investigaciones Biológicas</option>
                            <option value="Centro de Investigación en Biotecnología" <?php if ($usuario['unidad_academica'] == 'Centro de Investigación en Biotecnología') echo 'selected'; ?>>Centro de Investigación en Biotecnología</option>
                            <option value="Escuela de Estudios Superiores de Atlatlahucan" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Atlatlahucan') echo 'selected'; ?>>Escuela de Estudios Superiores de Atlatlahucan</option>
                            <option value="Escuela de Estudios Superiores de Atlatlahucan (Subsede de Totolapan)" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Atlatlahucan (Subsede de Totolapan)') echo 'selected'; ?>>Escuela de Estudios Superiores de Atlatlahucan (Subsede de Totolapan)</option>
                            <option value="Escuela de Estudios Superiores de Jicarero" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Jicarero') echo 'selected'; ?>>Escuela de Estudios Superiores de Jicarero</option>
                            <option value="Escuela de Estudios Superiores de Jonacatepec" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Jonacatepec') echo 'selected'; ?>>Escuela de Estudios Superiores de Jonacatepec</option>
                            <option value="Escuela de Estudios Superiores de Jonacatepec (Subsede de Axochiapan)" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Jonacatepec (Subsede de Axochiapan)') echo 'selected'; ?>>Escuela de Estudios Superiores de Jonacatepec (Subsede de Axochiapan)</option>
                            <option value="Escuela de Estudios Superiores de Jonacatepec (Subsede de Tepalcingo)" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Jonacatepec (Subsede de Tepalcingo)') echo 'selected'; ?>>Escuela de Estudios Superiores de Jonacatepec (Subsede de Tepalcingo)</option>
                            <option value="Escuela de Estudios Superiores de Jojutla" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Jojutla') echo 'selected'; ?>>Escuela de Estudios Superiores de Jojutla</option>
                            <option value="Escuela de Estudios Superiores de Mazatepec" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Mazatepec') echo 'selected'; ?>>Escuela de Estudios Superiores de Mazatepec</option>
                            <option value="Escuela de Estudios Superiores de Mazatepec (Subsede de Miacatlán)" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Mazatepec (Subsede de Miacatlán)') echo 'selected'; ?>>Escuela de Estudios Superiores de Mazatepec (Subsede de Miacatlán)</option>
                            <option value="Escuela de Estudios Superiores de Mazatepec (Subsede de Tetecala)" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Mazatepec (Subsede de Tetecala)') echo 'selected'; ?>>Escuela de Estudios Superiores de Mazatepec (Subsede de Tetecala)</option>
                            <option value="Escuela de Estudios Superiores de Xalostoc" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Xalostoc') echo 'selected'; ?>>Escuela de Estudios Superiores de Xalostoc</option>
                            <option value="Escuela de Estudios Superiores de Yautepec" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Yautepec') echo 'selected'; ?>>Escuela de Estudios Superiores de Yautepec</option>
                            <option value="Escuela de Estudios Superiores de Yecapixtla" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Yecapixtla') echo 'selected'; ?>>Escuela de Estudios Superiores de Yecapixtla</option>
                            <option value="Escuela de Estudios Superiores de Yecapixtla (Subsede de Tetela del Volcán)" <?php if ($usuario['unidad_academica'] == 'Escuela de Estudios Superiores de Yecapixtla (Subsede de Tetela del Volcán)') echo 'selected'; ?>>Escuela de Estudios Superiores de Yecapixtla (Subsede de Tetela del Volcán)</option>
                            <option value="Escuela de Teatro, Danza y Música" <?php if ($usuario['unidad_academica'] == 'Escuela de Teatro, Danza y Música') echo 'selected'; ?>>Escuela de Teatro, Danza y Música</option>
                            <option value="Escuela de Turismo" <?php if ($usuario['unidad_academica'] == 'Escuela de Turismo') echo 'selected'; ?>>Escuela de Turismo</option>
                            <option value="Facultad de Arquitectura" <?php if ($usuario['unidad_academica'] == 'Facultad de Arquitectura') echo 'selected'; ?>>Facultad de Arquitectura</option>
                            <option value="Facultad de Artes" <?php if ($usuario['unidad_academica'] == 'Facultad de Artes') echo 'selected'; ?>>Facultad de Artes</option>
                            <option value="Facultad de Ciencias Agropecuarias" <?php if ($usuario['unidad_academica'] == 'Facultad de Ciencias Agropecuarias') echo 'selected'; ?>>Facultad de Ciencias Agropecuarias</option>
                            <option value="Facultad de Ciencias Biológicas" <?php if ($usuario['unidad_academica'] == 'Facultad de Ciencias Biológicas') echo 'selected'; ?>>Facultad de Ciencias Biológicas</option>
                            <option value="Facultad de Ciencias del Deporte" <?php if ($usuario['unidad_academica'] == 'Facultad de Ciencias del Deporte') echo 'selected'; ?>>Facultad de Ciencias del Deporte</option>
                            <option value="Facultad de Ciencias Químicas e Ingeniería" <?php if ($usuario['unidad_academica'] == 'Facultad de Ciencias Químicas e Ingeniería') echo 'selected'; ?>>Facultad de Ciencias Químicas e Ingeniería</option>
                            <option value="Facultad de Comunicación Humana" <?php if ($usuario['unidad_academica'] == 'Facultad de Comunicación Humana') echo 'selected'; ?>>Facultad de Comunicación Humana</option>
                            <option value="Facultad de Contaduría, Administración e Informática" <?php if ($usuario['unidad_academica'] == 'Facultad de Contaduría, Administración e Informática') echo 'selected'; ?>>Facultad de Contaduría, Administración e Informática</option>
                            <option value="Facultad de Derecho y Ciencias Sociales" <?php if ($usuario['unidad_academica'] == 'Facultad de Derecho y Ciencias Sociales') echo 'selected'; ?>>Facultad de Derecho y Ciencias Sociales</option>
                            <option value="Facultad de Diseño" <?php if ($usuario['unidad_academica'] == 'Facultad de Diseño') echo 'selected'; ?>>Facultad de Diseño</option>
                            <option value="Facultad de Enfermería" <?php if ($usuario['unidad_academica'] == 'Facultad de Enfermería') echo 'selected'; ?>>Facultad de Enfermería</option>
                            <option value="Facultad de Estudios Sociales" <?php if ($usuario['unidad_academica'] == 'Facultad de Estudios Sociales') echo 'selected'; ?>>Facultad de Estudios Sociales</option>
                            <option value="Facultad de Estudios Superiores de Cuautla" <?php if ($usuario['unidad_academica'] == 'Facultad de Estudios Superiores de Cuautla') echo 'selected'; ?>>Facultad de Estudios Superiores de Cuautla</option>
                            <option value="Facultad de Farmacia" <?php if ($usuario['unidad_academica'] == 'Facultad de Farmacia') echo 'selected'; ?>>Facultad de Farmacia</option>
                            <option value="Facultad de Medicina" <?php if ($usuario['unidad_academica'] == 'Facultad de Medicina') echo 'selected'; ?>>Facultad de Medicina</option>
                            <option value="Facultad de Nutrición" <?php if ($usuario['unidad_academica'] == 'Facultad de Nutrición') echo 'selected'; ?>>Facultad de Nutrición</option>
                            <option value="Facultad de Psicología" <?php if ($usuario['unidad_academica'] == 'Facultad de Psicología') echo 'selected'; ?>>Facultad de Psicología</option>
                            <option value="Instituto de Ciencias de la Educación" <?php if ($usuario['unidad_academica'] == 'Instituto de Ciencias de la Educación') echo 'selected'; ?>>Instituto de Ciencias de la Educación</option>
                            <option value="Instituto de Investigación en Ciencias Básicas y Aplicadas" <?php if ($usuario['unidad_academica'] == 'Instituto de Investigación en Ciencias Básicas y Aplicadas') echo 'selected'; ?>>Instituto de Investigación en Ciencias Básicas y Aplicadas</option>
                            <option value="Instituto de Investigación en Humanidades y Ciencias Sociales" <?php if ($usuario['unidad_academica'] == 'Instituto de Investigación en Humanidades y Ciencias Sociales') echo 'selected'; ?>>Instituto de Investigación en Humanidades y Ciencias Sociales</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end col-12 mb-10 mt-3">
                        <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/listInstructors.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Cancelar</button>
                        <button class="btn btn-sm btn-general col-2">Guardar</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</body>

</html>
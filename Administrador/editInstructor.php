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

                        <div class="col-md-4 mb-3">
                            <label for="grado_academico">Grado Académico:</label>
                            <select name="grado_academico" id="grado_academico" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="Licenciado" <?php if ($usuario['grado_academico'] == 'Licenciado') echo 'selected'; ?>>Licenciado</option>
                                <option value="Ingeniero" <?php if ($usuario['grado_academico'] == 'Ingeniero') echo 'selected'; ?>>Ingeniero</option>
                                <option value="Maestro" <?php if ($usuario['grado_academico'] == 'Maestro') echo 'selected'; ?>>Maestro</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="perfil_academico">Perfil Académico:</label>
                            <select name="perfil_academico" id="perfil_academico" style="width: 100%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="Tiempo completo" <?php if ($usuario['perfil_academico'] == 'Tiempo completo') echo 'selected'; ?>>Tiempo completo</option>
                                <option value="Medio tiempo" <?php if ($usuario['perfil_academico'] == 'Medio tiempo') echo 'selected'; ?>>Medio tiempo</option>
                                <option value="Maestro" <?php if ($usuario['perfil_academico'] == 'Maestro') echo 'selected'; ?>>Maestro</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="unidad_academica">Unidad Académica:</label>
                            <select name="unidad_academica" id="unidad_academica" style="width: 322%; padding: 11px;" required>
                                <option value="">Seleccione</option>
                                <option value="Tepetongo" <?php if ($usuario['unidad_academica'] == 'Tepetongo') echo 'selected'; ?>>Tepetongo</option>
                                <option value="Chamilpa" <?php if ($usuario['unidad_academica'] == 'Chamilpa') echo 'selected'; ?>>Chamilpa</option>
                                <option value="Cuautla" <?php if ($usuario['unidad_academica'] == 'Cuautla') echo 'selected'; ?>>Cuautla</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end col-12 mb-10 mt-3">
                            <button onclick="window.location.href='<?php echo BASE_URL; ?>/Administrador/listInstructors.php'" class="btn btn-sm btn-danger me-2 col-2 py-2">Cancelar</button>
                            <button class="btn btn-sm btn-general col-2">Guardar</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</body>

</html>
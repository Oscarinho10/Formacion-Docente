<?php
session_start();

// Prevenir caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verifica sesión admin
include_once('../config/verificaSesion.php');
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Conexión y layout
include('../config/conexion.php');
include('../components/layoutAdmin.php');

// Obtener ID de la actividad desde GET
$id_actividad = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nombre de la actividad
$query_nombre = "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad";
$result_nombre = pg_query($conn, $query_nombre);
$nombreActividad = '';
if ($result_nombre && pg_num_rows($result_nombre) > 0) {
    $row = pg_fetch_assoc($result_nombre);
    $nombreActividad = $row['nombre'];
}

// Obtener instructores
$query_instructores = "SELECT id_usuario, nombre, apellido_paterno, apellido_materno 
                       FROM usuarios 
                       WHERE rol = 'instructor' AND estado = 'activo'";
$res_instructores = pg_query($conn, $query_instructores);

// Obtener sesiones con nombre de instructor
$query = "SELECT s.id_sesion, s.fecha, s.hora_inicio, s.hora_fin, 
                 u.nombre, u.apellido_paterno, u.apellido_materno
          FROM sesiones_actividad s
          LEFT JOIN usuarios u ON s.id_usuario = u.id_usuario
          WHERE s.id_actividad = $id_actividad
          ORDER BY s.fecha, s.hora_inicio";
$resultado_sesiones = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar sesiones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/tabla.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>
<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Registrar sesiones para actividad: <?php echo htmlspecialchars($nombreActividad); ?></h4>

                <?php if (isset($_GET['ok'])): ?>
                    <div class="alert alert-success">Sesión guardada correctamente.</div>
                <?php endif; ?>

                <form action="../Administrador/controller/addSessionsController.php" method="post">
                    <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

                    <!-- Instructor -->
                    <div class="mb-3">
                        <label for="id_usuario">Instructor asignado:</label>
                        <select name="id_usuario" id="id_usuario" style="width: 100%; padding: 11px;" required>
                            <option value="">Seleccione un instructor</option>
                            <?php while ($instr = pg_fetch_assoc($res_instructores)): ?>
                                <option value="<?php echo $instr['id_usuario']; ?>">
                                    <?php echo htmlspecialchars(trim(
                                        $instr['nombre'] . ' ' . $instr['apellido_paterno'] . ' ' . $instr['apellido_materno']
                                    )); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Fecha -->
                    <div class="mb-3">
                        <label for="fecha">Fecha de la sesión:</label>
                        <input type="date" id="fecha" name="fecha" style="width: 100%; padding: 11px;" required>
                    </div>

                    <!-- Hora inicio -->
                    <div class="mb-3">
                        <label for="hora_inicio">Hora de inicio:</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" style="width: 100%; padding: 11px;" required>
                    </div>

                    <!-- Hora fin -->
                    <div class="mb-3">
                        <label for="hora_fin">Hora de fin:</label>
                        <input type="time" id="hora_fin" name="hora_fin" style="width: 100%; padding: 11px;" required>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end mt-3">
                        <a href="../Administrador/listActivitys.php" class="btn btn-sm btn-danger me-2 col-2 py-2">Finalizar</a>
                        <button type="submit" class="btn btn-sm btn-general col-2 me-2">Guardar</button>
                    </div>
                </form>

                <hr>

                <h5 class="mt-4">Sesiones ya registradas:</h5>
                <?php if (pg_num_rows($resultado_sesiones) > 0): ?>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                                <th>Instructor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($sesion = pg_fetch_assoc($resultado_sesiones)): ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($sesion['fecha'])); ?></td>
                                    <td><?php echo substr($sesion['hora_inicio'], 0, 5); ?></td>
                                    <td><?php echo substr($sesion['hora_fin'], 0, 5); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars(trim(
                                            $sesion['nombre'] . ' ' . $sesion['apellido_paterno'] . ' ' . $sesion['apellido_materno']
                                        )); ?>
                                    </td>
                                    <td>
                                        <form action="./controller/deleteSessionController.php" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta sesión?');">
                                            <input type="hidden" name="id_sesion" value="<?php echo $sesion['id_sesion']; ?>">
                                            <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted">No hay sesiones registradas aún.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

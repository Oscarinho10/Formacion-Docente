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

// Obtener sesiones ya registradas
$query = "SELECT id_sesion, fecha, hora_inicio, hora_fin FROM sesiones_actividad 
          WHERE id_actividad = $id_actividad 
          ORDER BY fecha, hora_inicio";
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
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/brands.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/fontawesome/solid.min.css">
</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h4 class="text-center mb-4">Registrar sesiones para actividad #<?php echo $id_actividad; ?></h4>

                <?php if (isset($_GET['ok'])): ?>
                    <div class="alert alert-success">Sesión guardada correctamente.</div>
                <?php endif; ?>

                <form action="../Administrador/controller/addSessionsController.php" method="post">
                    <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

                    <div class="mb-3">
                        <label for="fecha">Fecha de la sesión:</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="hora_inicio">Hora de inicio:</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="hora_fin">Hora de fin:</label>
                        <input type="time" id="hora_fin" name="hora_fin" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-sm btn-general col-2 me-2">Guardar</button>
                        <a href="../Administrador/listActivitys.php" class="btn btn-sm btn-danger col-2">Finalizar</a>
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
                                        <form action="eliminar_sesion.php" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta sesión?');">
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

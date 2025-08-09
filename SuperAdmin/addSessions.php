<?php
include_once('../config/verificaRol.php');
verificarRol('superAdmin'); // acceso solo superAdmin
include('../config/conexion.php');
include('../components/layoutAdmin.php');

// ID actividad
$id_actividad = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nombre + fechas de la actividad (para limitar datepicker)
$query_datos = "
  SELECT nombre, fecha_inicio, fecha_fin
  FROM actividades_formativas
  WHERE id_actividad = $id_actividad
";
$result_datos = pg_query($conn, $query_datos);

$nombreActividad = '';
$fecha_inicio = '';
$fecha_fin = '';

if ($result_datos && pg_num_rows($result_datos) > 0) {
  $row = pg_fetch_assoc($result_datos);
  $nombreActividad = $row['nombre'];
  $fecha_inicio    = $row['fecha_inicio'];
  $fecha_fin       = $row['fecha_fin'];
}

// Instructores activos
$query_instructores = "
  SELECT id_usuario, nombre, apellido_paterno, apellido_materno
  FROM usuarios
  WHERE rol = 'instructor' AND estado = 'activo'
  ORDER BY nombre, apellido_paterno, apellido_materno
";
$res_instructores = pg_query($conn, $query_instructores);
$instructores_ok  = ($res_instructores !== false);
$hay_instructores = ($instructores_ok && pg_num_rows($res_instructores) > 0);

// Sesiones registradas (usa CAST como en el archivo 1)
$query_sesiones = "
  SELECT s.id_sesion, s.fecha, s.hora_inicio, s.hora_fin,
         u.nombre, u.apellido_paterno, u.apellido_materno
  FROM sesiones_actividad s
  LEFT JOIN usuarios u ON CAST(s.id_usuario AS INTEGER) = u.id_usuario
  WHERE s.id_actividad = $id_actividad
  ORDER BY s.fecha, s.hora_inicio
";
$resultado_sesiones = pg_query($conn, $query_sesiones);
$sesiones_ok = ($resultado_sesiones !== false);
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
      <h4 class="text-center mb-4">
        Registrar sesiones para actividad: <?php echo htmlspecialchars($nombreActividad); ?>
      </h4>

      <?php if (isset($_GET['ok'])): ?>
        <div class="alert alert-success">Sesión guardada correctamente.</div>
      <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Ocurrió un error: <?php echo htmlspecialchars($_GET['error']); ?></div>
      <?php endif; ?>

      <form action="../SuperAdmin/controller/addSessionsController.php" method="post">
        <input type="hidden" name="id_actividad" value="<?php echo $id_actividad; ?>">

        <!-- Instructor -->
        <div class="mb-3">
          <label for="id_usuario">Instructor asignado:</label>
          <select name="id_usuario" id="id_usuario" style="width:100%; padding:11px;" required>
            <option value="">Seleccione un instructor</option>
            <?php if ($hay_instructores): ?>
              <?php while ($instr = pg_fetch_assoc($res_instructores)): ?>
                <option value="<?php echo htmlspecialchars($instr['id_usuario']); ?>">
                  <?php echo htmlspecialchars(trim(
                    $instr['nombre'].' '.$instr['apellido_paterno'].' '.$instr['apellido_materno']
                  )); ?>
                </option>
              <?php endwhile; ?>
            <?php else: ?>
              <option value="" disabled>No hay instructores activos</option>
            <?php endif; ?>
          </select>
        </div>

        <!-- Fecha (limitada por rango de la actividad) -->
        <div class="mb-3">
          <label for="fecha">Fecha de la sesión:</label>
          <input type="date" id="fecha" name="fecha"
                 style="width:100%; padding:11px;" required
                 <?php if ($fecha_inicio) echo 'min="'.htmlspecialchars($fecha_inicio).'"'; ?>
                 <?php if ($fecha_fin)    echo 'max="'.htmlspecialchars($fecha_fin).'"'; ?> />
        </div>

        <!-- Hora inicio -->
        <div class="mb-3">
          <label for="hora_inicio">Hora de inicio:</label>
          <input type="time" id="hora_inicio" name="hora_inicio" style="width:100%; padding:11px;" required />
        </div>

        <!-- Hora fin -->
        <div class="mb-3">
          <label for="hora_fin">Hora de fin:</label>
          <input type="time" id="hora_fin" name="hora_fin" style="width:100%; padding:11px;" required />
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end mt-3">
          <a href="../SuperAdmin/trainingActivity.php" class="btn btn-sm btn-danger me-2 col-2 py-2">Finalizar</a>
          <button type="submit" class="btn btn-sm btn-general col-2 me-2">Guardar</button>
        </div>
      </form>

      <hr>

      <h5 class="mt-4">Sesiones ya registradas:</h5>

      <?php if (!$sesiones_ok): ?>
        <div class="alert alert-warning">No fue posible consultar las sesiones.</div>
      <?php elseif (pg_num_rows($resultado_sesiones) > 0): ?>
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
              <td><?php echo htmlspecialchars(trim(
                    $sesion['nombre'].' '.$sesion['apellido_paterno'].' '.$sesion['apellido_materno']
                  )); ?>
              </td>
              <td>
                <form class="form-eliminar-sesion" action="./controller/deleteSessionController.php" method="post" style="display:inline;"
                      onsubmit="return confirm('¿Estás seguro de eliminar esta sesión?');">
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

<!-- Scripts -->
<script src="<?php echo BASE_URL; ?>/assets/js/sweetAlert2.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.6.0.slim.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/SuperAdmin/js/addSessions.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

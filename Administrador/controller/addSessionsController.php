<?php
include('../../config/conexion.php');

$id_actividad = intval($_POST['id_actividad']);
$fecha = pg_escape_string($_POST['fecha']);
$inicio = pg_escape_string($_POST['hora_inicio']);
$fin = pg_escape_string($_POST['hora_fin']);

if (!$id_actividad || !$fecha || !$inicio || !$fin) {
    echo "Datos incompletos.";
    exit;
}

// Guardar sesión individual
pg_query($conn, "INSERT INTO sesiones_actividad (id_actividad, fecha, hora_inicio, hora_fin)
                 VALUES ($id_actividad, '$fecha', '$inicio', '$fin')");

// Regenerar descripcion_horarios
$result = pg_query($conn, "SELECT fecha, hora_inicio, hora_fin 
                           FROM sesiones_actividad 
                           WHERE id_actividad = $id_actividad 
                           ORDER BY fecha, hora_inicio");

$descripcion = '';
while ($row = pg_fetch_assoc($result)) {
    $dia = strftime('%A', strtotime($row['fecha']));
    $fecha_format = date('d/m/Y', strtotime($row['fecha']));
    $descripcion .= ucfirst($dia) . " $fecha_format: " . substr($row['hora_inicio'], 0, 5) . " a " . substr($row['hora_fin'], 0, 5) . "\n";
}

$descripcion_sql = pg_escape_string($descripcion);
pg_query($conn, "UPDATE actividades_formativas 
                 SET descripcion_horarios = '$descripcion_sql' 
                 WHERE id_actividad = $id_actividad");

// Redirige nuevamente al formulario con confirmación
header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;

<?php
include('../../config/conexion.php');

// Obtener y sanitizar datos
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

// Obtener todas las sesiones para regenerar la descripción
$result = pg_query($conn, "SELECT fecha, hora_inicio, hora_fin 
                           FROM sesiones_actividad 
                           WHERE id_actividad = $id_actividad 
                           ORDER BY fecha, hora_inicio");

// Traducción manual del día en español (compatible con PHP 5.2.0)
$dias_es = array(
    'Sunday'    => 'Domingo',
    'Monday'    => 'Lunes',
    'Tuesday'   => 'Martes',
    'Wednesday' => 'Miércoles',
    'Thursday'  => 'Jueves',
    'Friday'    => 'Viernes',
    'Saturday'  => 'Sábado'
);

$descripcion = '';
while ($row = pg_fetch_assoc($result)) {
    $timestamp = strtotime($row['fecha']);
    $dia_en = date('l', $timestamp); // Día en inglés
    $dia = isset($dias_es[$dia_en]) ? $dias_es[$dia_en] : $dia_en;

    $fecha_format = date('d/m/Y', $timestamp);
    $hora_inicio = substr($row['hora_inicio'], 0, 5);
    $hora_fin = substr($row['hora_fin'], 0, 5);

    $descripcion .= $dia . " " . $fecha_format . ": " . $hora_inicio . " a " . $hora_fin . "\n";
}

// Guardar en la base de datos
$descripcion_sql = pg_escape_string($descripcion);
pg_query($conn, "UPDATE actividades_formativas 
                 SET descripcion_horarios = '$descripcion_sql' 
                 WHERE id_actividad = $id_actividad");

// Redirigir
header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;
?>

<?php
include('../../config/conexion.php');

// Establecer locale en español (ajustado para PHP 5.2.0 y Windows)
setlocale(LC_TIME, 'spanish');

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

$descripcion = '';
while ($row = pg_fetch_assoc($result)) {
    $timestamp = strtotime($row['fecha']);

    // strftime en español (PHP 5.2.0 compatible)
    $dia = strftime('%A', $timestamp); // Ej: lunes
    $diaCapitalizado = ucfirst(utf8_encode($dia)); // Asegura acentos y primera mayúscula

    $fecha_format = date('d/m/Y', $timestamp);
    $hora_inicio = substr($row['hora_inicio'], 0, 5);
    $hora_fin = substr($row['hora_fin'], 0, 5);

    $descripcion .= $diaCapitalizado . " " . $fecha_format . ": " . $hora_inicio . " a " . $hora_fin . "\n";
}

// Guardar en la base de datos
$descripcion_sql = pg_escape_string($descripcion);
pg_query($conn, "UPDATE actividades_formativas 
                 SET descripcion_horarios = '$descripcion_sql' 
                 WHERE id_actividad = $id_actividad");

// Redirigir
header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;

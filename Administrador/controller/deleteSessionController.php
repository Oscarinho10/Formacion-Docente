<?php
include('../../config/conexion.php');

$id_sesion = intval($_POST['id_sesion']);
$id_actividad = intval($_POST['id_actividad']);

if ($id_sesion > 0 && $id_actividad > 0) {
    // Eliminar la sesión
    pg_query($conn, "DELETE FROM sesiones_actividad WHERE id_sesion = $id_sesion");

    // Regenerar el campo descripcion_horarios
    $result = pg_query($conn, "SELECT fecha, hora_inicio, hora_fin 
                               FROM sesiones_actividad 
                               WHERE id_actividad = $id_actividad 
                               ORDER BY fecha, hora_inicio");

    $dias_es = array(
        'Sunday' => 'Domingo',
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado'
    );

    $descripcion = '';
    while ($row = pg_fetch_assoc($result)) {
        $timestamp = strtotime($row['fecha']);
        $dia_en = date('l', $timestamp);
        $dia = isset($dias_es[$dia_en]) ? $dias_es[$dia_en] : $dia_en;

        $fecha_format = date('d/m/Y', $timestamp);
        $descripcion .= $dia . " $fecha_format: " . substr($row['hora_inicio'], 0, 5) . " a " . substr($row['hora_fin'], 0, 5) . "\n";
    }

    $descripcion_sql = pg_escape_string($descripcion);
    pg_query($conn, "UPDATE actividades_formativas 
                     SET descripcion_horarios = '$descripcion_sql' 
                     WHERE id_actividad = $id_actividad");
}

header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;

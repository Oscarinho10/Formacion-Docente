<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');

include_once('../../config/auditor.php'); // Para registrar auditoría

$id_sesion = intval($_POST['id_sesion']);
$id_actividad = intval($_POST['id_actividad']);

if ($id_sesion > 0 && $id_actividad > 0) {
    // Eliminar la sesión
    pg_query($conn, "DELETE FROM sesiones_actividad WHERE id_sesion = $id_sesion");

    // ✅ Obtener nombre de la actividad
    $nombre_actividad = '';
    $consulta = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
    if ($consulta && pg_num_rows($consulta) > 0) {
        $row = pg_fetch_assoc($consulta);
        $nombre_actividad = $row['nombre'];
    }

    // ✅ Registrar en auditoría
    $movimiento = "Eliminó una sesión (ID $id_sesion) de la actividad \"$nombre_actividad\" (ID $id_actividad)";
    $modulo = "Sesiones de actividad";
    registrarAuditoria($conn, $movimiento, $modulo);

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

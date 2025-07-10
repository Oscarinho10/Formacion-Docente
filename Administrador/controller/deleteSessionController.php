<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
include_once('../../config/auditor.php');

// Validar y sanitizar entrada
$id_sesion = isset($_POST['id_sesion']) ? intval($_POST['id_sesion']) : 0;
$id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;

if ($id_sesion <= 0 || $id_actividad <= 0) {
    echo "Datos inválidos.";
    exit;
}

// Obtener nombre de la actividad (para auditoría)
$nombre_actividad = '';
$consulta = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
if ($consulta && pg_num_rows($consulta) > 0) {
    $row = pg_fetch_assoc($consulta);
    $nombre_actividad = $row['nombre'];
}

// Eliminar la sesión
pg_query($conn, "DELETE FROM sesiones_actividad WHERE id_sesion = $id_sesion");

// Registrar auditoría
$movimiento = "Eliminó una sesión (ID $id_sesion) de la actividad \"$nombre_actividad\" (ID $id_actividad)";
$modulo = "Sesiones de actividad";
registrarAuditoria($conn, $movimiento, $modulo);

// Regenerar la descripción de horarios
$result = pg_query($conn, "
    SELECT sa.fecha, sa.hora_inicio, sa.hora_fin,
           u.nombre, u.apellido_paterno, u.apellido_materno
    FROM sesiones_actividad sa
    LEFT JOIN usuarios u ON sa.id_usuario = u.id_usuario
    WHERE sa.id_actividad = $id_actividad
    ORDER BY sa.fecha, sa.hora_inicio
");

// Traducción de días y meses al español (PHP 5.2 compatible)
$dias_es = array(
    'Sunday'    => 'Domingo',
    'Monday'    => 'Lunes',
    'Tuesday'   => 'Martes',
    'Wednesday' => 'Miércoles',
    'Thursday'  => 'Jueves',
    'Friday'    => 'Viernes',
    'Saturday'  => 'Sábado'
);

$meses_es = array(
    'January'   => 'Enero',
    'February'  => 'Febrero',
    'March'     => 'Marzo',
    'April'     => 'Abril',
    'May'       => 'Mayo',
    'June'      => 'Junio',
    'July'      => 'Julio',
    'August'    => 'Agosto',
    'September' => 'Septiembre',
    'October'   => 'Octubre',
    'November'  => 'Noviembre',
    'December'  => 'Diciembre'
);

$descripcion = '';
while ($row = pg_fetch_assoc($result)) {
    $timestamp = strtotime($row['fecha']);
    $dia_en = date('l', $timestamp);
    $mes_en = date('F', $timestamp);
    $dia_es = isset($dias_es[$dia_en]) ? $dias_es[$dia_en] : $dia_en;
    $mes_es = isset($meses_es[$mes_en]) ? $meses_es[$mes_en] : $mes_en;

    $dia_num = date('d', $timestamp);
    $anio = date('Y', $timestamp);

    $hora_inicio = date('g:i A', strtotime($row['hora_inicio']));
    $hora_fin = date('g:i A', strtotime($row['hora_fin']));

    $nombre_instructor = trim($row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno']);
    if ($nombre_instructor == '') {
        $nombre_instructor = 'Sin instructor';
    }

    $descripcion .= "$dia_es $dia_num de $mes_es de $anio de $hora_inicio a $hora_fin (instruido por: $nombre_instructor)\n";
}

// Actualizar descripción en la tabla de actividades
$descripcion_sql = pg_escape_string($conn, $descripcion);
pg_query($conn, "UPDATE actividades_formativas 
                 SET descripcion_horarios = '$descripcion_sql' 
                 WHERE id_actividad = $id_actividad");

// Redirigir con éxito
header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;
?>

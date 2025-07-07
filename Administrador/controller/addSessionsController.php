<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');

include_once('../../config/auditor.php');

// Obtener y sanitizar datos
$id_actividad = intval($_POST['id_actividad']);
$id_usuario = intval($_POST['id_usuario']);
$fecha = pg_escape_string($_POST['fecha']);
$inicio = pg_escape_string($_POST['hora_inicio']);
$fin = pg_escape_string($_POST['hora_fin']);

if (!$id_actividad || !$id_usuario || !$fecha || !$inicio || !$fin) {
    echo "Datos incompletos.";
    exit;
}

// Guardar sesión con instructor
pg_query($conn, "INSERT INTO sesiones_actividad (id_actividad, id_usuario, fecha, hora_inicio, hora_fin)
                 VALUES ($id_actividad, $id_usuario, '$fecha', '$inicio', '$fin')");

// Obtener sesiones con nombre completo del instructor
$result = pg_query($conn, "
    SELECT sa.fecha, sa.hora_inicio, sa.hora_fin,
           u.nombre, u.apellido_paterno, u.apellido_materno
    FROM sesiones_actividad sa
    LEFT JOIN usuarios u ON sa.id_usuario = u.id_usuario
    WHERE sa.id_actividad = $id_actividad 
    ORDER BY sa.fecha, sa.hora_inicio
");

// Traducción de días y meses (compatible con PHP 5.2.0)
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

// Guardar descripción actualizada
$descripcion_sql = pg_escape_string($descripcion);
pg_query($conn, "UPDATE actividades_formativas 
                 SET descripcion_horarios = '$descripcion_sql' 
                 WHERE id_actividad = $id_actividad");

// Obtener nombre de la actividad para la auditoría
$nombre_actividad = '';
$consulta_nombre = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
if ($consulta_nombre && pg_num_rows($consulta_nombre) > 0) {
    $row = pg_fetch_assoc($consulta_nombre);
    $nombre_actividad = $row['nombre'];
}

// Registrar acción en auditoría
$movimiento = "Agregó una sesión a la actividad \"$nombre_actividad\" (ID $id_actividad)";
$modulo = "Sesiones de actividad";
registrarAuditoria($conn, $movimiento, $modulo);

// Redirigir
header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;
?>

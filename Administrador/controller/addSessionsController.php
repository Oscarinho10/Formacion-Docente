<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
include_once('../../config/auditor.php');

// Validar y sanitizar entrada
$id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
$id_usuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
$fecha = isset($_POST['fecha']) ? pg_escape_string($conn, $_POST['fecha']) : '';
$inicio = isset($_POST['hora_inicio']) ? pg_escape_string($conn, $_POST['hora_inicio']) : '';
$fin = isset($_POST['hora_fin']) ? pg_escape_string($conn, $_POST['hora_fin']) : '';

if ($id_actividad <= 0 || $id_usuario <= 0 || $fecha == '' || $inicio == '' || $fin == '') {
    echo "Datos incompletos.";
    exit;
}

// Verificar rango de fechas permitido
$queryFechas = "SELECT fecha_inicio, fecha_fin FROM actividades_formativas WHERE id_actividad = $id_actividad";
$resFechas = pg_query($conn, $queryFechas);

if (!$resFechas || pg_num_rows($resFechas) === 0) {
    echo "Actividad no encontrada.";
    exit;
}

$datosFecha = pg_fetch_assoc($resFechas);
$fechaInicio = $datosFecha['fecha_inicio'];
$fechaFin = $datosFecha['fecha_fin'];

if ($fecha < $fechaInicio || $fecha > $fechaFin) {
    header("Location: ../addSessions.php?id=$id_actividad&error=fuera_de_rango");
    exit;
}

// Insertar sesión
$insert = "INSERT INTO sesiones_actividad (id_actividad, id_usuario, fecha, hora_inicio, hora_fin) 
           VALUES ($id_actividad, $id_usuario, '$fecha', '$inicio', '$fin')";
pg_query($conn, $insert);

// Consultar sesiones con nombre del instructor
$result = pg_query($conn, "
    SELECT sa.fecha, sa.hora_inicio, sa.hora_fin,
           u.nombre, u.apellido_paterno, u.apellido_materno
    FROM sesiones_actividad sa
    LEFT JOIN usuarios u ON sa.id_usuario = u.id_usuario
    WHERE sa.id_actividad = $id_actividad 
    ORDER BY sa.fecha, sa.hora_inicio
");

// Traducción manual (PHP 5.2 compatible)
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

// Actualizar descripción de horarios
$descripcion_sql = pg_escape_string($conn, $descripcion);
$update = "UPDATE actividades_formativas 
           SET descripcion_horarios = '$descripcion_sql' 
           WHERE id_actividad = $id_actividad";
pg_query($conn, $update);

// Auditar movimiento
$nombre_actividad = '';
$resNombre = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
if ($resNombre && pg_num_rows($resNombre) > 0) {
    $rowNombre = pg_fetch_assoc($resNombre);
    $nombre_actividad = $rowNombre['nombre'];
}

$movimiento = "Agregó una sesión a la actividad \"$nombre_actividad\" (ID $id_actividad)";
$modulo = "Sesiones de actividad";
registrarAuditoria($conn, $movimiento, $modulo);

// Redirigir
header("Location: ../addSessions.php?id=$id_actividad&ok=1");
exit;
?>

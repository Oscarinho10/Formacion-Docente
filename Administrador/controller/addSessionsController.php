<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
include_once('../../config/auditor.php');

// --- Helper escape (PHP 5.2: usa versión con conexión) ---
function esc($conn, $s) { return pg_escape_string($conn, $s); }

// --- Entradas ---
$id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
$id_usuario   = isset($_POST['id_usuario'])   ? intval($_POST['id_usuario'])   : 0;
$fecha        = isset($_POST['fecha'])        ? esc($conn, $_POST['fecha'])    : '';
$inicio       = isset($_POST['hora_inicio'])  ? esc($conn, $_POST['hora_inicio']) : '';
$fin          = isset($_POST['hora_fin'])     ? esc($conn, $_POST['hora_fin'])    : '';

// Validación mínima
if ($id_actividad <= 0 || $id_usuario <= 0 || $fecha == '' || $inicio == '' || $fin == '') {
    header("Location: ../addSessions.php?id=".$id_actividad."&error=datos_incompletos");
    exit;
}

// --- Verificar rango de fechas permitido ---
$sqlRango = "SELECT fecha_inicio, fecha_fin FROM actividades_formativas WHERE id_actividad = $id_actividad";
$resRango = pg_query($conn, $sqlRango);
if (!$resRango || pg_num_rows($resRango) === 0) {
    header("Location: ../addSessions.php?id=".$id_actividad."&error=actividad_no_encontrada");
    exit;
}
$rowRango    = pg_fetch_assoc($resRango);
$fechaIniAct = $rowRango['fecha_inicio'];
$fechaFinAct = $rowRango['fecha_fin'];

if ($fecha < $fechaIniAct || $fecha > $fechaFinAct) {
    header("Location: ../addSessions.php?id=".$id_actividad."&error=fuera_de_rango");
    exit;
}

// --- Insertar sesión ---
// Nota: si sesiones_actividad.id_usuario es TEXT en la BD, no pasa nada: Postgres hará cast implícito de INT -> TEXT.
// Si es INT, mejor todavía.
$sqlInsert = "
    INSERT INTO sesiones_actividad (id_actividad, id_usuario, fecha, hora_inicio, hora_fin)
    VALUES ($id_actividad, $id_usuario, '$fecha', '$inicio', '$fin')
";
$okIns = pg_query($conn, $sqlInsert);
if (!$okIns) {
    header("Location: ../addSessions.php?id=".$id_actividad."&error=insert_failed");
    exit;
}

// --- Consultar sesiones para reconstruir descripcion_horarios ---
// Importante: CAStear s.id_usuario por si la columna en sesiones_actividad es TEXT.
$sqlSes = "
    SELECT sa.fecha, sa.hora_inicio, sa.hora_fin,
           u.nombre, u.apellido_paterno, u.apellido_materno
    FROM sesiones_actividad sa
    LEFT JOIN usuarios u ON CAST(sa.id_usuario AS INTEGER) = u.id_usuario
    WHERE sa.id_actividad = $id_actividad
    ORDER BY sa.fecha, sa.hora_inicio
";
$resSes = pg_query($conn, $sqlSes);
if (!$resSes) {
    // No detener el flujo; solo no actualizamos descripción si falló
    header("Location: ../addSessions.php?id=".$id_actividad."&ok=1&warn=desc_no_actualizada");
    exit;
}

// Traducción (PHP 5.2 compatible)
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
while ($row = pg_fetch_assoc($resSes)) {
    $ts       = strtotime($row['fecha']);
    $dia_en   = date('l', $ts);
    $mes_en   = date('F', $ts);
    $dia_es   = isset($dias_es[$dia_en]) ? $dias_es[$dia_en] : $dia_en;
    $mes_es   = isset($meses_es[$mes_en]) ? $meses_es[$mes_en] : $mes_en;
    $dia_num  = date('d', $ts);
    $anio     = date('Y', $ts);

    // Formato 12h como en tu código 1, o 24h si prefieres:
    $h_ini = date('g:i A', strtotime($row['hora_inicio']));
    $h_fin = date('g:i A', strtotime($row['hora_fin']));

    $instructor = trim($row['nombre'].' '.$row['apellido_paterno'].' '.$row['apellido_materno']);
    if ($instructor == '') { $instructor = 'Sin instructor'; }

    $descripcion .= $dia_es.' '.$dia_num.' de '.$mes_es.' de '.$anio.' de '.$h_ini.' a '.$h_fin.' (instruido por: '.$instructor.")\n";
}

// --- Actualizar descripcion_horarios ---
$descripcion_sql = esc($conn, $descripcion);
$sqlUpd = "
    UPDATE actividades_formativas
    SET descripcion_horarios = '$descripcion_sql'
    WHERE id_actividad = $id_actividad
";
pg_query($conn, $sqlUpd); // si falla, no detenemos el flujo

// --- Auditoría ---
$nombre_actividad = '';
$resNom = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
if ($resNom && pg_num_rows($resNom) > 0) {
    $rowNom = pg_fetch_assoc($resNom);
    $nombre_actividad = $rowNom['nombre'];
}
$mov = 'Agregó una sesión a la actividad "' . $nombre_actividad . '" (ID ' . $id_actividad . ')';
registrarAuditoria($conn, $mov, 'Sesiones de actividad');

// --- Redirigir ---
header("Location: ../addSessions.php?id=".$id_actividad."&ok=1");
exit;

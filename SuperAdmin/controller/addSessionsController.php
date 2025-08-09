<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('superAdmin'); // igual que archivo 1 pero para superAdmin
include_once('../../config/auditor.php');

// Helper escape (PHP 5.2.0)
function esc($conn, $s) { return pg_escape_string($conn, $s); }

// Entradas
$id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
$id_usuario   = isset($_POST['id_usuario'])   ? intval($_POST['id_usuario'])   : 0;
$fecha        = isset($_POST['fecha'])        ? esc($conn, $_POST['fecha'])    : '';
$inicio       = isset($_POST['hora_inicio'])  ? esc($conn, $_POST['hora_inicio']) : '';
$fin          = isset($_POST['hora_fin'])     ? esc($conn, $_POST['hora_fin'])    : '';

if ($id_actividad <= 0 || $id_usuario <= 0 || $fecha == '' || $inicio == '' || $fin == '') {
    header("Location: ../addSessions.php?id=".$id_actividad."&error=datos_incompletos");
    exit;
}

// Rango de fechas de la actividad (como en archivo 1)
$sqlRango = "SELECT fecha_inicio, fecha_fin
             FROM actividades_formativas
             WHERE id_actividad = $id_actividad";
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

// Insert sesión (como en archivo 1)
$sqlIns = "INSERT INTO sesiones_actividad (id_actividad, id_usuario, fecha, hora_inicio, hora_fin)
           VALUES ($id_actividad, $id_usuario, '$fecha', '$inicio', '$fin')";
$okIns = pg_query($conn, $sqlIns);
if (!$okIns) {
    header("Location: ../addSessions.php?id=".$id_actividad."&error=insert_failed");
    exit;
}

// Re-construir descripcion_horarios (igual que archivo 1)
$sqlSes = "SELECT sa.fecha, sa.hora_inicio, sa.hora_fin,
                  u.nombre, u.apellido_paterno, u.apellido_materno
           FROM sesiones_actividad sa
           LEFT JOIN usuarios u ON CAST(sa.id_usuario AS INTEGER) = u.id_usuario
           WHERE sa.id_actividad = $id_actividad
           ORDER BY sa.fecha, sa.hora_inicio";
$resSes = pg_query($conn, $sqlSes);

if ($resSes) {
    // Traducción manual (PHP 5.2.0)
    $dias_es = array(
        'Sunday'=>'Domingo','Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miércoles',
        'Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado'
    );
    $meses_es = array(
        'January'=>'Enero','February'=>'Febrero','March'=>'Marzo','April'=>'Abril','May'=>'Mayo','June'=>'Junio',
        'July'=>'Julio','August'=>'Agosto','September'=>'Septiembre','October'=>'Octubre','November'=>'Noviembre','December'=>'Diciembre'
    );

    $descripcion = '';
    while ($row = pg_fetch_assoc($resSes)) {
        $ts     = strtotime($row['fecha']);
        $dia_en = date('l', $ts);
        $mes_en = date('F', $ts);

        $dia_es = isset($dias_es[$dia_en]) ? $dias_es[$dia_en] : $dia_en;
        $mes_es = isset($meses_es[$mes_en]) ? $meses_es[$mes_en] : $mes_en;

        $dia_num = date('d', $ts);
        $anio    = date('Y', $ts);

        $h_ini = date('g:i A', strtotime($row['hora_inicio']));
        $h_fin = date('g:i A', strtotime($row['hora_fin']));

        $instructor = trim($row['nombre'].' '.$row['apellido_paterno'].' '.$row['apellido_materno']);
        if ($instructor == '') { $instructor = 'Sin instructor'; }

        $descripcion .= $dia_es.' '.$dia_num.' de '.$mes_es.' de '.$anio.' de '.$h_ini.' a '.$h_fin.' (instruido por: '.$instructor.")\n";
    }

    $desc_sql = esc($conn, $descripcion);
    $sqlUpd   = "UPDATE actividades_formativas
                 SET descripcion_horarios = '$desc_sql'
                 WHERE id_actividad = $id_actividad";
    pg_query($conn, $sqlUpd); // si falla, no rompemos el flujo
}

// Auditoría (igual archivo 1)
$nombre_actividad = '';
$resNom = pg_query($conn, "SELECT nombre FROM actividades_formativas WHERE id_actividad = $id_actividad");
if ($resNom && pg_num_rows($resNom) > 0) {
    $rowNom = pg_fetch_assoc($resNom);
    $nombre_actividad = $rowNom['nombre'];
}
registrarAuditoria($conn,
  'Agregó una sesión a la actividad "'.$nombre_actividad.'" (ID '.$id_actividad.')',
  'Sesiones de actividad'
);

// OK
header("Location: ../addSessions.php?id=".$id_actividad."&ok=1");
exit;

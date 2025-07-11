<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin');
header('Content-Type: application/json');

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '../../logs/error.log');

$id_actividad = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

$sesiones = array();

if ($id_actividad <= 0 || $id_usuario <= 0) {
  echo json_encode(array('error' => 'Parámetros inválidos.'));
  exit;
}

// Traducción manual de días y meses
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

$query = "
  SELECT 
    s.id_sesion,
    s.fecha,
    s.hora_inicio,
    s.hora_fin,
    CASE 
      WHEN a.presente IS TRUE THEN 1
      ELSE 0
    END AS asistio
  FROM sesiones_actividad s
  LEFT JOIN asistencias a 
    ON a.id_sesion = s.id_sesion AND a.id_usuario = $id_usuario
  WHERE s.id_actividad = $id_actividad
  ORDER BY s.fecha ASC
";

$result = pg_query($conn, $query);

if (!$result) {
  echo json_encode(array('error' => 'Error en la consulta: ' . pg_last_error($conn)));
  exit;
}

while ($row = pg_fetch_assoc($result)) {
  $timestamp = strtotime($row['fecha']);
  $dia_en = date('l', $timestamp);
  $dia_es = isset($dias_es[$dia_en]) ? $dias_es[$dia_en] : $dia_en;

  $mes_en = date('F', $timestamp);
  $mes_es = isset($meses_es[$mes_en]) ? $meses_es[$mes_en] : $mes_en;

  $dia_num = date('d', $timestamp);
  $anio = date('Y', $timestamp);

  // Convertir horas al formato 12h con AM/PM
  $hora_inicio = date('g:i A', strtotime($row['hora_inicio']));
  $hora_fin = date('g:i A', strtotime($row['hora_fin']));

  // Construir campo nombre_sesion
  $row['nombre_sesion'] = "$dia_es $dia_num de $mes_es de $anio de $hora_inicio a $hora_fin";

  $sesiones[] = $row;
}

echo json_encode($sesiones);
?>

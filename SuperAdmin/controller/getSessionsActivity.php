<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

$id_actividad = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
$sesiones = array();

$query = "
  SELECT 
    s.id_sesion,
    s.fecha,
    s.hora_inicio,
    s.hora_fin,
    to_char(s.fecha, 'DD/MM/YYYY') || ' de ' || 
    to_char(s.hora_inicio, 'HH24:MI') || ' a ' || 
    to_char(s.hora_fin, 'HH24:MI') AS nombre_sesion,
    CASE 
      WHEN a.presente IS TRUE THEN 1
      ELSE 0
    END AS asistio
  FROM sesiones_actividad s
  INNER JOIN inscripciones i ON s.id_actividad = i.id_actividad
  LEFT JOIN asistencias a 
    ON a.id_sesion = s.id_sesion AND a.id_usuario = $id_usuario
  WHERE i.id_usuario = $id_usuario
  ORDER BY s.fecha ASC
";

$result = pg_query($conn, $query);

if (!$result) {
  echo json_encode(array('error' => 'Error en la consulta: ' . pg_last_error($conn)));
  exit;
}

while ($row = pg_fetch_assoc($result)) {
  $sesiones[] = $row;
}

echo json_encode($sesiones);
?>

<?php
include('../../config/conexion.php');

$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
$sesiones = array();

$query = "
  SELECT s.id_sesion, s.nombre_sesion, s.fecha
  FROM sesiones_actividad s
  INNER JOIN inscripciones i ON i.id_actividad = s.id_actividad
  WHERE i.id_usuario = $id_usuario
  ORDER BY s.fecha ASC
";

$result = pg_query($conn, $query);

if (!$result) {
  http_response_code(500);
  echo json_encode(array('error' => 'Error en la consulta: ' . pg_last_error($conn)));
  exit;
}

while ($row = pg_fetch_assoc($result)) {
  $sesiones[] = $row;
}

header('Content-Type: application/json');
echo json_encode($sesiones);

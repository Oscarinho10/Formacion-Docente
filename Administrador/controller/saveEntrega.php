<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

// Leer el contenido crudo (formato JSON)
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Validar datos básicos
$id_usuario = isset($data['id_usuario']) ? intval($data['id_usuario']) : 0;
$id_actividad = isset($data['id_actividad']) ? intval($data['id_actividad']) : 0;
$observaciones = isset($data['observaciones']) ? pg_escape_string($conn, $data['observaciones']) : '';
$entregado = (isset($data['entregado']) && $data['entregado']) ? 'TRUE' : 'FALSE';

if ($id_usuario <= 0 || $id_actividad <= 0) {
  echo json_encode(array('error' => 'Datos incompletos'));
  exit;
}

// Obtener id_inscripcion
$query = "SELECT id_inscripcion FROM inscripciones WHERE id_usuario = $id_usuario AND id_actividad = $id_actividad LIMIT 1";
$result = pg_query($conn, $query);

if (!$result || pg_num_rows($result) == 0) {
  echo json_encode(array('error' => 'No se encontró inscripción.'));
  exit;
}

$row = pg_fetch_assoc($result);
$id_inscripcion = intval($row['id_inscripcion']);

// Verificar si ya hay entrega
$check = pg_query($conn, "SELECT 1 FROM entregas_actividad WHERE id_inscripcion = $id_inscripcion");

if ($check && pg_num_rows($check) > 0) {
  // Actualizar
  $sql = "UPDATE entregas_actividad SET entregado = $entregado, observaciones = '$observaciones', fecha_entrega = NOW() WHERE id_inscripcion = $id_inscripcion";
} else {
  // Insertar
  $sql = "INSERT INTO entregas_actividad (id_inscripcion, entregado, observaciones, fecha_entrega) VALUES ($id_inscripcion, $entregado, '$observaciones', NOW())";
}

$ok = pg_query($conn, $sql);

if ($ok) {
  echo json_encode(array('mensaje' => 'Entrega registrada correctamente.'));
} else {
  echo json_encode(array('error' => 'Error al guardar entrega.'));
}
?>

<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;
$id_actividad = isset($_GET['id_actividad']) ? intval($_GET['id_actividad']) : 0;

if ($id_usuario <= 0 || $id_actividad <= 0) {
  echo json_encode(array('error' => 'Parámetros incompletos'));
  exit;
}

// Buscar inscripción
$sqlInscripcion = "SELECT id_inscripcion FROM inscripciones WHERE id_usuario = $id_usuario AND id_actividad = $id_actividad LIMIT 1";
$resInscripcion = pg_query($conn, $sqlInscripcion);

if (!$resInscripcion || pg_num_rows($resInscripcion) === 0) {
  echo json_encode(array('entregado' => false, 'observaciones' => ''));
  exit;
}

$row = pg_fetch_assoc($resInscripcion);
$id_inscripcion = intval($row['id_inscripcion']);

// Buscar entrega
$sqlEntrega = "SELECT entregado, observaciones FROM entregas_actividad WHERE id_inscripcion = $id_inscripcion LIMIT 1";
$resEntrega = pg_query($conn, $sqlEntrega);

if ($resEntrega && pg_num_rows($resEntrega) > 0) {
  $entrega = pg_fetch_assoc($resEntrega);
  echo json_encode(array(
    'entregado' => $entrega['entregado'] === 't',
    'observaciones' => $entrega['observaciones']
  ));
} else {
  echo json_encode(array('entregado' => false, 'observaciones' => ''));
}
?>

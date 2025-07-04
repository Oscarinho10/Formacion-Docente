<?php
include('../../config/conexion.php');

$id_actividad = isset($_GET['id']) ? intval($_GET['id']) : 0;
$participantes = array();

$query = "
  SELECT 
    u.nombre, 
    u.apellido_paterno, 
    u.apellido_materno,
    u.numero_control_rfc AS control,
    u.correo_electronico AS correo
  FROM usuarios u
  INNER JOIN inscripciones i ON i.id_usuario = u.id_usuario
  WHERE i.id_actividad = $id_actividad
";

$result = pg_query($conn, $query);

if ($result) {
  while ($row = pg_fetch_assoc($result)) {
    $participantes[] = array(
      'nombre' => $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'],
      'control' => $row['control'],
      'correo' => $row['correo']
    );
  }
}

header('Content-Type: application/json');
echo json_encode($participantes);
?>

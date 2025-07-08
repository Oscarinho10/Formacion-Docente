<?php
include('../../config/conexion.php');

$id_actividad = isset($_GET['id']) ? intval($_GET['id']) : 0;
$participantes = array();

$query = "
  SELECT 
    u.id_usuario,
    u.nombre, 
    u.apellido_paterno, 
    u.apellido_materno,
    u.numero_control_rfc AS control,
    u.correo_electronico AS correo,
    u.fecha_nacimiento,
    u.sexo,
    u.unidad_academica,
    u.grado_academico,
    u.perfil_academico,
    u.fecha_registro
  FROM usuarios u
  INNER JOIN inscripciones i ON i.id_usuario = u.id_usuario
  WHERE i.id_actividad = $id_actividad
";

$result = pg_query($conn, $query);

if ($result) {
  while ($row = pg_fetch_assoc($result)) {
    $participantes[] = array(
      'id_usuario' => $row['id_usuario'],
      'nombre' => $row['nombre'],
      'apellido_paterno' => $row['apellido_paterno'],
      'apellido_materno' => $row['apellido_materno'],
      'control' => $row['control'],
      'correo' => $row['correo'],
      'fecha_nacimiento' => $row['fecha_nacimiento'],
      'sexo' => $row['sexo'],
      'unidad_academica' => $row['unidad_academica'],
      'grado_academico' => $row['grado_academico'],
      'perfil_academico' => $row['perfil_academico'],
      'fecha_registro' => $row['fecha_registro']
    );
  }
}

header('Content-Type: application/json');
echo json_encode($participantes);

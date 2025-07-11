<?php
session_start();
include('../../config/conexion.php');

$data = array();
$idActividad = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idActividad <= 0) {
  echo json_encode($data);
  exit;
}

$query = "
  SELECT 
    u.id_usuario,
    u.nombre || ' ' || u.apellido_paterno || ' ' || u.apellido_materno AS nombre_completo,
    u.correo_electronico,
    af.nombre AS nombre_actividad,
    af.tipo_evaluacion,
    af.id_actividad,
    COUNT(DISTINCT s.id_sesion) AS total_sesiones,
    SUM(CASE WHEN asi.presente = true THEN 1 ELSE 0 END) AS asistencias,
    (
      SELECT COUNT(*) 
      FROM entregas_actividad ea
      INNER JOIN inscripciones ins ON ins.id_inscripcion = ea.id_inscripcion
      WHERE ins.id_usuario = u.id_usuario AND ins.id_actividad = af.id_actividad
    ) AS entrego,
    (
      SELECT COUNT(*) 
      FROM constancias c 
      WHERE c.id_usuario = u.id_usuario AND c.id_actividad = af.id_actividad
    ) AS emitida
  FROM inscripciones i
  INNER JOIN usuarios u ON u.id_usuario = i.id_usuario
  INNER JOIN actividades_formativas af ON af.id_actividad = i.id_actividad
  LEFT JOIN sesiones_actividad s ON s.id_actividad = af.id_actividad
  LEFT JOIN asistencias asi ON asi.id_usuario = u.id_usuario AND asi.id_sesion = s.id_sesion
  WHERE af.id_actividad = $idActividad
  GROUP BY u.id_usuario, u.nombre, u.apellido_paterno, u.apellido_materno, u.correo_electronico, af.nombre, af.tipo_evaluacion, af.id_actividad
";

$result = pg_query($conn, $query);
if (!$result) {
  echo json_encode(array('error' => pg_last_error($conn)));
  exit;
}

while ($row = pg_fetch_assoc($result)) {
  $totalSesiones = (int)$row['total_sesiones'];
  $asistencias = (int)$row['asistencias'];
  $porcentaje = $totalSesiones > 0 ? ($asistencias / $totalSesiones) * 100 : 0;
  $entrego = ((int)$row['entrego']) > 0 ? true : false;
  $tipoEvaluacion = strtolower(trim($row['tipo_evaluacion']));
  $emitida = ((int)$row['emitida']) > 0 ? true : false;

  $tipoConstancia = '';

  if ($porcentaje >= 80) {
    if ($tipoEvaluacion == 'actividad' && $entrego) {
      $tipoConstancia = 'Acreditado';
    } else if ($tipoEvaluacion == 'asistencia') {
      $tipoConstancia = 'Por asistir al curso';
    }
  }

  if ($tipoConstancia != '') {
    $data[] = array(
      'id_usuario' => (int)$row['id_usuario'],
      'nombre' => $row['nombre_completo'],
      'correo' => $row['correo_electronico'],
      'tipo' => $tipoConstancia,
      'actividad' => $row['nombre_actividad'],
      'emitida' => $emitida
    );
  }
}

header('Content-Type: application/json');
echo json_encode($data);
?>

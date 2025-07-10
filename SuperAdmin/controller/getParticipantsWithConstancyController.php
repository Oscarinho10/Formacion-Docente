<?php
session_start();
include('../../config/conexion.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = array();
$idActividad = isset($_GET['id']) ? intval($_GET['id']) : null;

$query = "
  SELECT 
    u.nombre || ' ' || u.apellido_paterno || ' ' || u.apellido_materno AS nombre_completo,
    u.correo_electronico,
    af.nombre AS nombre_actividad,
    af.tipo_evaluacion,
    u.id_usuario,
    af.id_actividad,
    COUNT(DISTINCT s.id_sesion) AS total_sesiones,
    COUNT(DISTINCT asi.id_asistencia) FILTER (WHERE asi.presente IS TRUE) AS asistencias,
    (
      SELECT COUNT(*) 
      FROM entregas_actividad ea
      INNER JOIN inscripciones ins ON ins.id_inscripcion = ea.id_inscripcion
      WHERE ins.id_usuario = u.id_usuario
        AND ins.id_actividad = af.id_actividad
    ) AS entrego
  FROM inscripciones i
  INNER JOIN usuarios u ON u.id_usuario = i.id_usuario
  INNER JOIN actividades_formativas af ON af.id_actividad = i.id_actividad
  LEFT JOIN sesiones_actividad s ON s.id_actividad = af.id_actividad
  LEFT JOIN asistencias asi ON asi.id_usuario = u.id_usuario AND asi.id_sesion = s.id_sesion
";

// Aplicar filtro si se especificó id de actividad
if ($idActividad) {
  $query .= " WHERE af.id_actividad = $idActividad ";
}

$query .= "
  GROUP BY u.id_usuario, u.nombre, u.apellido_paterno, u.apellido_materno, u.correo_electronico, af.nombre, af.tipo_evaluacion, af.id_actividad
";

$result = pg_query($conn, $query);

if (!$result) {
  header("HTTP/1.1 500 Internal Server Error");
  echo json_encode(array('error' => pg_last_error($conn)));
  exit;
}

while ($row = pg_fetch_assoc($result)) {
  $totalSesiones = intval($row['total_sesiones']);
  $asistencias = intval($row['asistencias']);
  $porcentaje = $totalSesiones > 0 ? ($asistencias / $totalSesiones) * 100 : 0;
  $entrego = intval($row['entrego']) > 0;
  $tipoEvaluacion = strtolower(trim($row['tipo_evaluacion']));

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
      'nombre' => $row['nombre_completo'],
      'correo' => $row['correo_electronico'],
      'tipo' => $tipoConstancia,
      'actividad' => $row['nombre_actividad']
    );
  }
}

header('Content-Type: application/json');
echo json_encode($data);
?>

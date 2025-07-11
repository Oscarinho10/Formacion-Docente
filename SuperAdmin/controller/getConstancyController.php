<?php
session_start();
include('../../config/conexion.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = array();

$query = "
  SELECT 
    af.nombre AS nombre_actividad,
    af.fecha_inicio,
    af.fecha_fin,
    af.total_horas,
    u.id_usuario,
    af.id_actividad,
    COUNT(s.id_sesion) AS total_sesiones,
    SUM(CASE WHEN asi.presente THEN 1 ELSE 0 END) AS asistencias,
    (
      SELECT COUNT(*) 
      FROM entregas_actividad ea
      INNER JOIN inscripciones ins ON ins.id_inscripcion = ea.id_inscripcion
      WHERE ins.id_usuario = u.id_usuario
        AND ins.id_actividad = af.id_actividad
    ) AS entrego
  FROM inscripciones i
  INNER JOIN usuarios u ON i.id_usuario = u.id_usuario
  INNER JOIN actividades_formativas af ON af.id_actividad = i.id_actividad
  LEFT JOIN sesiones_actividad s ON s.id_actividad = af.id_actividad
  LEFT JOIN asistencias asi ON asi.id_usuario = u.id_usuario AND asi.id_sesion = s.id_sesion
  GROUP BY af.nombre, af.fecha_inicio, af.fecha_fin, af.total_horas, u.id_usuario, af.id_actividad
";

$result = pg_query($conn, $query);

if (!$result) {
  $error = pg_last_error($conn);
  header("HTTP/1.1 500 Internal Server Error");
  echo json_encode(array('error' => 'Error en la consulta: ' . $error));
  exit;
}

while ($row = pg_fetch_assoc($result)) {
  $totalSesiones = intval($row['total_sesiones']);
  $asistencias = intval($row['asistencias']);
  $porcentaje = $totalSesiones > 0 ? ($asistencias / $totalSesiones) * 100 : 0;
  $entrego = intval($row['entrego']) > 0;

  $tipo = '';
  if ($porcentaje >= 80) {
    $tipo = $entrego ? 'Acreditado' : 'Por asistir al curso';
  }

  if ($tipo != '') {
    $data[] = array(
      'nombre' => $row['nombre_actividad'],
      'fecha' => $row['fecha_fin'],
      'tipo' => $tipo,
      'id_actividad' => $row['id_actividad'],
      'id_usuario' => $row['id_usuario']
    );
  }
}

header('Content-Type: application/json');
echo json_encode($data);

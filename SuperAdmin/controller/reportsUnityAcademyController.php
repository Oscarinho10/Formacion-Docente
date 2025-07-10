<?php
require_once('../../config/conexion.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($conn)) {
    die("Error: variable \$conn no está definida. Verifica tu archivo de conexión.");
}
$query = "
SELECT
  EXTRACT(YEAR FROM af.fecha_inicio) AS anio,
  u.unidad_academica,
  COUNT(DISTINCT af.id_actividad) AS actividades_realizadas,
  COUNT(DISTINCT u.id_usuario || '-' || af.id_actividad) AS total_participantes,
  COUNT(a.id_asistencia) AS total_asistencias
FROM usuarios u
JOIN inscripciones i ON i.id_usuario = u.id_usuario
JOIN actividades_formativas af ON af.id_actividad = i.id_actividad
LEFT JOIN sesiones_actividad sa ON sa.id_actividad = af.id_actividad
LEFT JOIN asistencias a ON a.id_sesion = sa.id_sesion AND a.id_usuario = u.id_usuario
WHERE u.rol = 'participante'
  AND u.unidad_academica IS NOT NULL
  AND u.unidad_academica <> ''
  AND af.fecha_inicio IS NOT NULL
GROUP BY anio, u.unidad_academica
ORDER BY anio DESC, u.unidad_academica;
";


$resultado = pg_query($conn, $query);

if (!$resultado) {
    echo "<br><b>Error en consulta:</b> " . pg_last_error($conn);
    exit;
}

$datos = array();
while ($row = pg_fetch_assoc($resultado)) {
    $datos[] = array(
        'anio' => intval($row['anio']),
        'unidad' => $row['unidad_academica'] ? $row['unidad_academica'] : 'No especificada',
        'actividades' => intval($row['actividades_realizadas']),
        'participantes' => intval($row['total_participantes']),
        'asistencias' => intval($row['total_asistencias'])
    );
}

header('Content-Type: application/json');
echo json_encode($datos);

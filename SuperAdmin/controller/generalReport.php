<?php
include('../../config/conexion.php');

header('Content-Type: application/json');

$data = array();

$query = "
SELECT 
  af.tipo_evaluacion AS tipo,
  af.nombre AS actividad,
  CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) AS instructor,
  af.total_horas || 'h' AS duracion,
  af.modalidad,
  af.fecha_inicio,
  TO_CHAR(MIN(sa.hora_inicio), 'HH24:MI') || ' - ' || TO_CHAR(MAX(sa.hora_fin), 'HH24:MI') AS horario,
  (
    SELECT COUNT(*) FROM inscripciones i WHERE i.id_actividad = af.id_actividad
  ) AS participantes,
  (
    SELECT COUNT(DISTINCT asi.id_usuario)
    FROM asistencias asi
    INNER JOIN sesiones_actividad sas ON sas.id_sesion = asi.id_sesion
    WHERE sas.id_actividad = af.id_actividad AND asi.presente = TRUE
  ) AS asistidos
FROM actividades_formativas af
LEFT JOIN sesiones_actividad sa ON af.id_actividad = sa.id_actividad
LEFT JOIN usuarios u ON sa.id_usuario = u.id_usuario::text
GROUP BY af.id_actividad, af.nombre, u.nombre, u.apellido_paterno, u.apellido_materno, af.total_horas, af.modalidad, af.fecha_inicio, af.tipo_evaluacion
ORDER BY af.fecha_inicio DESC;
";


$result = pg_query($conn, $query);
$json = '[';

while ($row = pg_fetch_assoc($result)) {
    $fecha = $row['fecha_inicio'];
    $anio = date('Y', strtotime($fecha));
    $mes = date('n', strtotime($fecha));
    $semestre = ($mes >= 1 && $mes <= 6) ? "Enero - Junio" : "Julio - Diciembre";

    $json .= '{';
    $json .= '"tipo":"' . addslashes($row['tipo']) . '",';
    $json .= '"actividad":"' . addslashes($row['actividad']) . '",';
    $json .= '"instructor":"' . addslashes($row['instructor']) . '",';
    $json .= '"duracion":"' . addslashes($row['duracion']) . '",';
    $json .= '"modalidad":"' . addslashes($row['modalidad']) . '",';
    $json .= '"fecha":"' . $fecha . '",';
    $json .= '"horario":"' . $row['horario'] . '",';
    $json .= '"participantes":' . intval($row['participantes']) . ',';
    $json .= '"asistidos":' . intval($row['asistidos']) . ',';
    $json .= '"semestre":"' . $semestre . '",';
    $json .= '"anio":"' . $anio . '"';
    $json .= '},';
}

// Elimina la última coma
$json = rtrim($json, ',');
$json .= ']';

echo $json;
?>

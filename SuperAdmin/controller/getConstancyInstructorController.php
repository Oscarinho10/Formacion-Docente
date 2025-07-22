<?php
include_once('../../config/conexion.php');
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

$id_instructor = isset($_GET['id']) ? intval($_GET['id']) : (isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0);

if (!$id_instructor) {
    echo json_encode(array('error' => 'ID de instructor no proporcionado'));
    exit;
}

$query = "
SELECT af.id_actividad, af.nombre AS actividad, af.total_horas AS horas, af.modalidad,
       c.folio, c.fecha_emision, c.id_constancia, sa.id_usuario
FROM sesiones_actividad sa
JOIN actividades_formativas af ON sa.id_actividad = af.id_actividad
LEFT JOIN constancias c 
    ON c.id_actividad = af.id_actividad 
   AND c.id_usuario = sa.id_usuario::integer
WHERE sa.id_usuario::integer = $id_instructor
GROUP BY af.id_actividad, af.nombre, af.total_horas, af.modalidad, 
         c.folio, c.fecha_emision, c.id_constancia, sa.id_usuario
ORDER BY af.fecha_fin DESC;
";



$result = pg_query($conn, $query);

if (!$result) {
    echo json_encode(array('error' => pg_last_error($conn)));
    exit;
}

$constancias = array();

while ($row = pg_fetch_assoc($result)) {
    $constancias[] = array(
        'id_actividad' => $row['id_actividad'],
        'actividad' => $row['actividad'],
        'horas' => $row['horas'],
        'modalidad' => $row['modalidad'],
        'folio' => $row['folio'],
        'fecha_emision' => $row['fecha_emision'],
        'id_constancia' => $row['id_constancia'],
        'id_usuario' => $row['id_usuario']
    );
}

echo json_encode($constancias);

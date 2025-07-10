<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('../../config/conexion.php');

if (!isset($_SESSION['id_usuario'])) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Sesión no iniciada'));
    exit;
}

$id_usuario = intval($_SESSION['id_usuario']);

// Consulta corregida: usa CASE en lugar de COALESCE + IS NOT NULL
$query = "SELECT a.id_actividad, a.nombre, a.descripcion, a.dirigido_a, a.modalidad, a.lugar, 
                 a.clasificacion, a.cupo, a.total_horas, a.estado, a.descripcion_horarios, a.fecha_inicio,
                 a.fecha_fin, a.tipo_evaluacion,
                 COUNT(i.id_inscripcion) AS inscritos,
                 CASE 
                     WHEN EXISTS (
                         SELECT 1 FROM inscripciones i2
                         WHERE i2.id_actividad = a.id_actividad 
                         AND i2.id_usuario = $id_usuario
                         AND i2.estado = 'activo'
                     ) THEN 1 ELSE 0 
                 END AS ya_inscrito
         FROM actividades_formativas a
         LEFT JOIN inscripciones i ON a.id_actividad = i.id_actividad AND i.estado = 'activo'
         GROUP BY a.id_actividad
         ORDER BY a.id_actividad DESC";


$result = pg_query($conn, $query);
$actividades = array();

while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        'id_actividad' => $row['id_actividad'],
        'nombre' => $row['nombre'],
        'descripcion' => $row['descripcion'],
        'dirigido_a' => $row['dirigido_a'],
        'modalidad' => $row['modalidad'],
        'lugar' => $row['lugar'],
        'clasificacion' => $row['clasificacion'],
        'cupo' => $row['cupo'],
        'inscritos' => $row['inscritos'], // nuevo dato
        'total_horas' => $row['total_horas'],
        'estado' => '', // puedes agregar lógica si manejas estado
        'descripcion_horarios' => '', // opcional si lo manejas
        'ya_inscrito' => ($row['ya_inscrito'] == 1 ? "1" : "0")
    );
}

header('Content-Type: application/json');
echo json_encode($actividades);

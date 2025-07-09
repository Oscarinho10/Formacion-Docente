<?php
include('../../config/conexion.php');

$query = "SELECT a.id_actividad, a.nombre, a.descripcion, a.dirigido_a, a.modalidad, a.lugar, 
                    a.clasificacion, a.cupo, a.total_horas, a.estado, a.descripcion_horarios, a.fecha_fin, a.tipo_evaluacion,
                    COUNT(i.id_inscripcion) AS inscritos, a.tipo_evaluacion
            FROM actividades_formativas a
            LEFT JOIN inscripciones i ON a.id_actividad = i.id_actividad AND i.estado = 'activo'
            GROUP BY a.id_actividad
            ORDER BY a.id_actividad DESC";

$result = pg_query($conn, $query);

$actividades = array();

while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        'id' => $row['id_actividad'],
        'nombre' => $row['nombre'],
        'tipo_evaluacion' => $row['tipo_evaluacion'], // nuevo dato
        'descripcion' => $row['descripcion'],
        'dirigido_a' => $row['dirigido_a'],
        'modalidad' => $row['modalidad'],
        'lugar' => $row['lugar'],
        'clasificacion' => $row['clasificacion'],
        'cupo' => $row['cupo'],
        'inscritos' => $row['inscritos'], // nuevo dato
        'total_horas' => $row['total_horas'],
        'estado' => $row['estado'],
        'descripcion_horarios' => $row['descripcion_horarios'],
        'fecha_fin' => $row['fecha_fin']
    );
}

header('Content-Type: application/json');
echo json_encode($actividades);

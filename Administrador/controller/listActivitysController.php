<?php
include('../../config/conexion.php');

$query = "SELECT id_actividad, nombre, descripcion, dirigido_a, modalidad, lugar, clasificacion, 
                 cupo, total_horas, estado, descripcion_horarios, fecha_fin 
          FROM actividades_formativas 
          ORDER BY id_actividad DESC";

$result = pg_query($conn, $query);

$actividades = array();

while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        'id' => $row['id_actividad'],
        'nombre' => $row['nombre'],
        'descripcion' => $row['descripcion'],
        'dirigido_a' => $row['dirigido_a'],
        'modalidad' => $row['modalidad'],
        'lugar' => $row['lugar'],
        'clasificacion' => $row['clasificacion'],
        'cupo' => $row['cupo'],
        'total_horas' => $row['total_horas'],
        'estado' => $row['estado'],
        'descripcion_horarios' => $row['descripcion_horarios'],
        'fecha_fin' => $row['fecha_fin']
    );
}

header('Content-Type: application/json');
echo json_encode($actividades);

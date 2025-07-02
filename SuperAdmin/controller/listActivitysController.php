<?php
include('../../config/conexion.php');

$query = "SELECT id_actividad, nombre, total_horas, estado FROM actividades_formativas ORDER BY id_actividad DESC";
$result = pg_query($conn, $query);

$actividades = array();

while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        'id' => $row['id_actividad'],
        'nombre' => $row['nombre'],
        'horas' => $row['total_horas'],
        'estado' => $row['estado']
    );
}

header('Content-Type: application/json');
echo json_encode($actividades);
?>

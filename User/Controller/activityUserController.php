<?php
include('../config/conexion.php');

// Consulta para obtener las actividades
$query = "SELECT nombre, total_horas, modalidad, cupo, lugar, clasificacion, fecha_inicio, fecha_fin, dirigido_a FROM actividades_formativas";

$result = pg_query($conn, $query);

$actividades = array();
while ($row = pg_fetch_assoc($result)) {
    $actividades[] = array(
        "nombre" => $row["nombre"],
        "horas" => $row["duracion"] . " horas",
        "modalidad" => $row["modalidad"],
        "cupo" => $row["cupo"] . " participantes",
        "lugar" => $row["lugar"],
        "tipo" => $row["tipo"],
        "fecha_inicio" => $row["fecha_inicio"],
        "fecha_fin" => $row["fecha_fin"],
        "dirigido_a" => $row["dirigido_a"],
        "horario" => $row["horario"]
    );
}

// Consulta para obtener las modalidades únicas
$modalidad_query = "SELECT DISTINCT modalidad FROM actividades_formativas";
$modalidad_result = pg_query($conn, $modalidad_query);

$modalidades = array();
while ($row = pg_fetch_assoc($modalidad_result)) {
    $modalidades[] = $row["modalidad"];
}
?>
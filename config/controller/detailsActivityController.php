<?php
include('config/conexion.php');

$idActividad = isset($_GET['id']) ? intval($_GET['id']) : 0;

$actividad = null;

if ($idActividad > 0) {
    $query = "SELECT * FROM actividades_formativas WHERE id_actividad = $1";
    $result = pg_query_params($conn, $query, array($idActividad));

    if ($result && pg_num_rows($result) > 0) {
        $actividad = pg_fetch_assoc($result);
    }
}
?>

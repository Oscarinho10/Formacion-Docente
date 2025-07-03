<?php
include('../../config/conexion.php');

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';

if ($id > 0 && ($estado === 'activo' || $estado === 'inactivo')) {
    $query = "UPDATE actividades_formativas SET estado = '$estado' WHERE id_actividad = $id";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "ok";
    } else {
        echo "Error al actualizar en la base de datos.";
    }
} else {
    echo "Parámetros inválidos.";
}
?>

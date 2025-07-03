<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_actividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
    $nuevoEstado = isset($_POST['estado']) ? $_POST['estado'] : '';

    if ($id_actividad > 0 && ($nuevoEstado === 'activo' || $nuevoEstado === 'inactivo')) {
        $query = "UPDATE actividades_formativas SET estado = '$nuevoEstado' WHERE id_actividad = $id_actividad";
        $result = pg_query($conn, $query);

        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'error' => 'Error al actualizar en la base de datos.'));
        }
    } else {
        echo json_encode(array('success' => false, 'error' => 'Datos inválidos.'));
    }
} else {
    echo json_encode(array('success' => false, 'error' => 'Método no permitido.'));
}
?>

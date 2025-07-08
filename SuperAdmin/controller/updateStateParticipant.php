<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';

    $estado = pg_escape_string($conn, $estado);

    if ($id > 0 && ($estado === 'activo' || $estado === 'inactivo')) {
        $query = "UPDATE usuarios SET estado = '$estado' WHERE id_usuario = $id";
        $resultado = pg_query($conn, $query);

        if ($resultado) {
            echo 'ok';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
}
?>

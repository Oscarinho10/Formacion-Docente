<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $control = $_POST['control'];
    $nuevo_estado = $_POST['activo'] === 'true' ? 'activo' : 'inactivo';

    $control = pg_escape_string($conn, $control);
    $nuevo_estado = pg_escape_string($conn, $nuevo_estado);

    $query = "UPDATE administradores SET estado = '$nuevo_estado' WHERE numero_control_rfc = '$control'";
    $resultado = pg_query($conn, $query);

    if ($resultado) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, "error" => pg_last_error($conn)));
    }
}
?>

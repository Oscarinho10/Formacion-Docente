<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $control = $_POST['control'];
    $estado = $_POST['estado']; // no 'activo' ni booleano, ya viene como texto

    $control = pg_escape_string($conn, $control);
    $estado = pg_escape_string($conn, $estado);

    $query = "UPDATE administradores SET estado = '$estado' WHERE numero_control_rfc = '$control'";
    $resultado = pg_query($conn, $query);

    if ($resultado) {
        echo 'ok'; // ✅ justo lo que espera el fetch
    } else {
        echo 'error';
    }
}
?>

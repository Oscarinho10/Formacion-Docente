<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo_electronico'])) {
    $correo = pg_escape_string($conn, $_POST['correo_electronico']);

    $update = pg_query($conn, "
        UPDATE usuarios
        SET estado = 'inactivo'
        WHERE correo_electronico = '$correo' AND estado = 'reestablecimiento'
    ");

    echo ($update && pg_affected_rows($update) > 0)
        ? "Solicitud denegada. El usuario podrá volver a solicitar recuperación."
        : "No se pudo denegar la solicitud.";
} else {
    echo 'Solicitud inválida.';
}
?>

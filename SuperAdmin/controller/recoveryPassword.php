<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    $correo = pg_escape_string($conn, $_POST['correo']);
    $passDefault = sha1('uaem2025'); // Encriptación compatible con PHP 5.2.0

    $update = pg_query($conn, "
        UPDATE usuarios
        SET estado = 'activo', contrasena = '$passDefault'
        WHERE correo_electronico = '$correo' AND estado = 'reestablecimiento'
    ");

    echo ($update && pg_affected_rows($update) > 0)
        ? "Contraseña restablecida y cuenta activada."
        : "No se pudo restablecer. Verifica el estado del usuario.";
} else {
    echo 'Solicitud inválida.';
}
?>

<?php
include_once('adminController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y asignar variables del formulario
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $numero_control_rfc = $_POST['numero_control'];
    $correo_electronico = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];

    // Llamar al controlador
    $resultado = registrarAdministrador($nombre, $apellido_paterno, $apellido_materno, $numero_control_rfc, $correo_electronico, $fecha_nacimiento, $sexo);

    // Redirigir según resultado
    if ($resultado === "ok") {
        header("Location: ../views/manageAdmin.php?mensaje=registro_exitoso");
        exit();
    } elseif ($resultado === "duplicado") {
        header("Location: ../views/manageAdmin.php?mensaje=duplicado");
        exit();
    } else {
        header("Location: ../views/manageAdmin.php?mensaje=error");
        exit();
    }
} else {
    echo "❌ Acceso no permitido.";
}
?>

<?php
include('../../config/conexion.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$numero_control = $_POST['numero_control'];
$correo = $_POST['correo'];

$query = "UPDATE administradores 
          SET nombre = $1, apellido_paterno = $2, apellido_materno = $3, 
              numero_control_rfc = $4, correo_electronico = $5 
          WHERE id_admin = $6";

$result = pg_query_params($conn, $query, array(
    $nombre,
    $apellido_paterno,
    $apellido_materno,
    $numero_control,
    $correo,
    $id
));

if ($result) {
    // Redirige a manageAdmin con parámetro para mostrar SweetAlert
    header("Location: ../manageAdmin.php?editado=ok");
    exit;
} else {
    // En caso de error, podrías redirigir con error también
    header("Location: ../manageAdmin.php?editado=error");
    exit;
}

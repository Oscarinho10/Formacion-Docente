<?php
include('../../config/conexion.php');

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$ap_paterno = $_POST['apellido_paterno'];
$ap_materno = $_POST['apellido_materno'];
$control = $_POST['numero_control'];
$correo = $_POST['correo'];

$query = "UPDATE administradores SET nombre = $1, apellido_paterno = $2, apellido_materno = $3, numero_control_rfc = $4, correo_electronico = $5 WHERE id_admin = $6";
$result = pg_query_params($conn, $query, array($nombre, $ap_paterno, $ap_materno, $control, $correo, $id));

if ($result) {
    header("Location: manageAdmin.php?editado=ok");
} else {
    echo "Error al actualizar";
}
?>

<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

$query = "SELECT nombre, correo_electronico, numero_control_rfc, estado FROM administradores ORDER BY nombre ASC";
$result = pg_query($conn, $query);

$administradores = array();

while ($row = pg_fetch_assoc($result)) {
    $administradores[] = array(
        "nombre" => $row['nombre'],
        "correo" => $row['correo_electronico'],
        "control" => $row['numero_control_rfc'],
        "activo" => $row['estado'] === 'activo' ? true : false
    );
}

echo json_encode($administradores);
?>

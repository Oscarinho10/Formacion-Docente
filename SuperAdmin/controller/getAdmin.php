<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../config/conexion.php');
header('Content-Type: application/json');

$query = "SELECT id_admin, nombre, correo_electronico, numero_control_rfc, estado FROM administradores ORDER BY nombre ASC";
$result = pg_query($conn, $query);

if (!$result) {
    echo json_encode(array("error" => "Error en la consulta."));
    exit;
}

$administradores = array();

while ($row = pg_fetch_assoc($result)) {
    $administradores[] = array(
        "id" => $row['id_admin'],
        "nombre" => $row['nombre'],
        "correo" => $row['correo_electronico'],
        "control" => $row['numero_control_rfc'],
        "activo" => ($row['estado'] === 'activo')
    );
}

echo json_encode($administradores);
?>

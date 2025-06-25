<?php
include('../../config/conexion.php');
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(array("error" => "ID no proporcionado"));
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM administradores WHERE id_admin = $1";
$result = pg_query_params($conn, $query, array($id));

if (!$result || pg_num_rows($result) === 0) {
    echo json_encode(array("error" => "Administrador no encontrado"));
    exit;
}

$admin = pg_fetch_assoc($result);
echo json_encode($admin);
?>

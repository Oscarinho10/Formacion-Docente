<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../config/conexion.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id)) {
    echo json_encode(array('error' => 'ID no proporcionado'));
    exit;
}

if (!is_numeric($id)) {
    echo json_encode(array('error' => 'ID inválido'));
    exit;
}

$id_escapado = pg_escape_string($conn, $id);

$query = "SELECT nombre, apellido_paterno, apellido_materno, correo, numero_control_rfc 
          FROM usuarios
          WHERE id = $id_escapado";

$result = pg_query($conn, $query);

if (!$result) {
    echo json_encode(array('error' => pg_last_error($conn)));
    exit;
}

$usuario = pg_fetch_assoc($result);

if ($usuario) {
    echo json_encode($usuario);
} else {
    echo json_encode(array('error' => 'Usuario no encontrado'));
}

pg_close($conn);
?>

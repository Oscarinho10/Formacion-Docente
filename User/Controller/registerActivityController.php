<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('../../config/conexion.php');

header('Content-Type: application/json');

// Validaciones
if (!isset($_SESSION['id_usuario']) || !isset($_POST['id_actividad'])) {
    echo json_encode(array('success' => false, 'message' => 'Datos incompletos o sesión no iniciada'));
    exit;
}

$id_usuario = intval($_SESSION['id_usuario']);
$id_actividad = intval($_POST['id_actividad']);
$fecha = date('Y-m-d');

// Verificar si ya está inscrito
$verifica = pg_query($conn, "SELECT 1 FROM inscripciones WHERE id_usuario = $id_usuario AND id_actividad = $id_actividad");

if ($verifica && pg_num_rows($verifica) > 0) {
    echo json_encode(array('success' => false, 'message' => 'Ya estás inscrito en esta actividad'));
    exit;
}

// Insertar nueva inscripción
$query = "INSERT INTO inscripciones (id_usuario, id_actividad, fecha_inscripcion, estado) VALUES ($id_usuario, $id_actividad, '$fecha', 'activo')";

$result = pg_query($conn, $query);

if ($result) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'message' => 'Error al registrar inscripción'));
}

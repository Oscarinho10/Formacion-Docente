<?php
include('../../config/conexion.php');

// Obtener y decodificar JSON
$json = file_get_contents("php://input");
$input = json_decode($json, true);

if (!is_array($input) || !isset($input['id_usuario']) || !isset($input['asistencias'])) {
    echo json_encode(array('status' => 'error', 'mensaje' => 'Datos inválidos.'));
    exit;
}

$id_usuario = intval($input['id_usuario']);
$asistencias = $input['asistencias'];

if (!is_array($asistencias) || count($asistencias) == 0) {
    echo json_encode(array('status' => 'error', 'mensaje' => 'No se proporcionaron asistencias.'));
    exit;
}

pg_query($conn, "BEGIN");

foreach ($asistencias as $item) {
    if (!isset($item['id_sesion']) || !isset($item['presente'])) {
        continue; // saltar si falta algún dato
    }

    $id_sesion = intval($item['id_sesion']);
    $presente = ($item['presente']) ? 'TRUE' : 'FALSE';

    // Verificar si ya existe el registro
    $checkQuery = "SELECT id_asistencia FROM asistencias WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
    $checkResult = pg_query($conn, $checkQuery);

    if ($checkResult && pg_num_rows($checkResult) > 0) {
        // Ya existe: actualizar presente = TRUE/FALSE
        $update = "UPDATE asistencias SET presente = $presente WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
        pg_query($conn, $update);
    } else {
        // No existe: insertar nuevo registro con el estado
        $insert = "INSERT INTO asistencias (id_sesion, id_usuario, presente) VALUES ($id_sesion, $id_usuario, $presente)";
        pg_query($conn, $insert);
    }

    if ($checkResult) {
        pg_free_result($checkResult);
    }
}

pg_query($conn, "COMMIT");

echo json_encode(array('status' => 'ok', 'mensaje' => 'Asistencias actualizadas.'));
?>

<?php
include('../../config/conexion.php');

$input = json_decode(file_get_contents("php://input"), true);

$id_usuario = intval($input['id_usuario']);
$sesiones = $input['sesiones']; // array de id_sesion marcadas como presentes

pg_query($conn, "BEGIN");

foreach ($sesiones as $id_sesion) {
    $id_sesion = intval($id_sesion);

    // Verifica si ya existe el registro
    $checkQuery = "SELECT id_asistencia FROM asistencias WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
    $checkResult = pg_query($conn, $checkQuery);

    if (pg_num_rows($checkResult) > 0) {
        // Si ya existe, actualiza el campo 'presente' a true
        $update = "UPDATE asistencias SET presente = TRUE WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
        pg_query($conn, $update);
    } else {
        // Si no existe, inserta un nuevo registro
        $insert = "INSERT INTO asistencias (id_sesion, id_usuario, presente) VALUES ($id_sesion, $id_usuario, TRUE)";
        pg_query($conn, $insert);
    }
}

pg_query($conn, "COMMIT");

echo json_encode(['status' => 'ok', 'mensaje' => 'Asistencia guardada correctamente.']);
?>

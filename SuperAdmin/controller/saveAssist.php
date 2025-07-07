<?php
include('../../config/conexion.php');

// Obtener el contenido del cuerpo de la petición
$json = file_get_contents("php://input");

// Verificar si el JSON es válido
$input = json_decode($json, true);

if (!is_array($input) || !isset($input['id_usuario']) || !isset($input['sesiones'])) {
    echo json_encode(array('status' => 'error', 'mensaje' => 'Datos inválidos.'));
    exit;
}

$id_usuario = intval($input['id_usuario']);
$sesiones = $input['sesiones']; // array de id_sesion marcadas como presentes

if (!is_array($sesiones) || count($sesiones) == 0) {
    echo json_encode(array('status' => 'error', 'mensaje' => 'No se proporcionaron sesiones.'));
    exit;
}

// Iniciar transacción
pg_query($conn, "BEGIN");

foreach ($sesiones as $id_sesion) {
    $id_sesion = intval($id_sesion);

    // Verificar si ya existe el registro
    $checkQuery = "SELECT id_asistencia FROM asistencias WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
    $checkResult = pg_query($conn, $checkQuery);

    if ($checkResult && pg_num_rows($checkResult) > 0) {
        // Ya existe: actualizar
        $update = "UPDATE asistencias SET presente = TRUE WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
        pg_query($conn, $update);
    } else {
        // No existe: insertar
        $insert = "INSERT INTO asistencias (id_sesion, id_usuario, presente) VALUES ($id_sesion, $id_usuario, TRUE)";
        pg_query($conn, $insert);
    }

    if ($checkResult) {
        pg_free_result($checkResult);
    }
}

// Confirmar transacción
pg_query($conn, "COMMIT");

echo json_encode(array('status' => 'ok', 'mensaje' => 'Asistencia guardada correctamente.'));
?>

<?php
include('../config/conexion.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido_paterno = trim($_POST['apellido_paterno'] ?? '');
    $apellido_materno = trim($_POST['apellido_materno'] ?? '');

    if (!$id || !is_numeric($id) || empty($nombre) || empty($apellido_paterno) || empty($apellido_materno)) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
        exit;
    }

    $id_esc = pg_escape_string($conn, $id);
    $nombre_esc = pg_escape_string($conn, $nombre);
    $ap_p_esc = pg_escape_string($conn, $apellido_paterno);
    $ap_m_esc = pg_escape_string($conn, $apellido_materno);

    $query = "UPDATE usuarios SET nombre = '$nombre_esc', apellido_paterno = '$ap_p_esc', apellido_materno = '$ap_m_esc' WHERE id = $id_esc";

    $result = pg_query($conn, $query);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . pg_last_error($conn)]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>

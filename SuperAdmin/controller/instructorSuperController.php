<?php
include('../../config/conexion.php');
header('Content-Type: application/json');
error_reporting(0);

// GET: obtener instructores
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM usuarios WHERE rol = 'instructor'";
    $result = pg_query($conn, $query);

    if (!$result) {
        echo json_encode(array("error" => "Error al obtener instructores."));
        exit;
    }

    $instructores = array();
    while ($row = pg_fetch_assoc($result)) {
        $instructores[] = $row;
    }

    echo json_encode($instructores);
    exit;
}

// POST: cambiar estado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : '';

    if ($id > 0 && ($estado === 'activo' || $estado === 'inactivo')) {
        $query = "UPDATE usuarios SET estado = '$estado' WHERE id_usuario = $id AND rol = 'instructor'";
        $result = pg_query($conn, $query);

        if ($result) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'error' => 'Error al actualizar en la base de datos.'));
        }
    } else {
        echo json_encode(array('success' => false, 'error' => 'Datos inválidos.'));
    }
    exit;
}

http_response_code(405);
echo json_encode(array('error' => 'Método no permitido.'));
?>

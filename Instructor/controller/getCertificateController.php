<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../config/conexion.php');
header('Content-Type: application/json');

if (!$conn) {
    echo json_encode(array('error' => 'No hay conexión a la base de datos.'));
    exit;
}

$usuarioId = 0;
if (isset($_GET['usuario_id']) && is_numeric($_GET['usuario_id'])) {
    $usuarioId = intval($_GET['usuario_id']);
}

$constancias = array();

if ($usuarioId > 0) {
    $query = "
        SELECT 
            c.id_constancia,
            c.folio,
            c.codigo_verificacion,
            c.fecha_emision,
            c.qr_url,
            a.nombre AS nombre_actividad,
            c.id_actividad
        FROM constancias c
        JOIN actividades_formativas a ON c.id_actividad = a.id_actividad
        WHERE c.id_usuario = $usuarioId
          AND c.tipo = 'instructor'
    ";

    $result = pg_query($conn, $query);

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $constancias[] = $row;
        }
    } else {
        echo json_encode(array('error' => 'Error en la consulta SQL.'));
        exit;
    }
} else {
    echo json_encode(array('error' => 'ID de usuario inválido.'));
    exit;
}

echo json_encode($constancias);
exit;

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// INCLUYE LA CONEXIÓN
include('../../config/conexion.php'); // ajusta ruta si es necesario

// CONTINÚA CON LA CONSULTA
$sql = "SELECT a.fecha, a.hora, ad.nombre, ad.apellido_paterno, ad.apellido_materno, a.movimiento, a.modulo
        FROM auditoria a
        INNER JOIN administradores ad ON a.id_admin = ad.id_admin
        ORDER BY a.fecha DESC, a.hora DESC";


$result = pg_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . pg_last_error($conn));
}

$datos = array();

while ($row = pg_fetch_assoc($result)) {
    $datos[] = array(
        'fecha' => $row['fecha'],
        'hora' => $row['hora'],
        'admin' => $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'],
        'movimiento' => $row['movimiento'],
        'modulo' => $row['modulo']
    );
}

header('Content-Type: application/json');
echo json_encode($datos);

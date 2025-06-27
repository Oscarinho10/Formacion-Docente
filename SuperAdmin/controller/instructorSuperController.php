<?php
include('../../config/conexion.php'); // Ajusta si es necesario

// Encabezado para respuesta JSON
header('Content-Type: application/json');

// Evita mostrar errores como HTML
error_reporting(0);

// Consulta instructores activos
$query = "SELECT * FROM usuarios WHERE rol = 'instructor' AND estado = 'activo'";
$result = pg_query($conn, $query);

if (!$result) {
    echo json_encode(array("error" => "Error al obtener instructores."));
    exit;
}

$instructores = array();
while ($row = pg_fetch_assoc($result)) {
    $instructores[] = $row;
}

// Devuelve JSON
echo json_encode($instructores);
?>

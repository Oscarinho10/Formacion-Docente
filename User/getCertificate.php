<?php
// NO incluir layout.php aquí
include('../config/conexion.php');

// Establecer el tipo de contenido
header('Content-Type: application/json');

// Consulta a la tabla de constancias
$query = "SELECT id, folio FROM constancias";
$result = pg_query($conn, $query);

$constancias = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $constancias[] = $row;
    }
}

echo json_encode($constancias);
exit;
?>





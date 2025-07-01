<?php
include('../../config/conexion.php');

// Cabecera para JSON
header('Content-Type: application/json; charset=utf-8');

$consulta = "SELECT id_usuario, nombre, apellido_paterno, apellido_materno FROM usuarios WHERE rol = 'instructor'";
$resultado = pg_query($conn, $consulta);

$datos = array();

while ($fila = pg_fetch_assoc($resultado)) {
  $nombre = $fila['nombre'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'];
  $datos[] = array('id' => $fila['id_usuario'], 'text' => $nombre);
}

// Compatibilidad con PHP 5.2: convierte a JSON manualmente si falla json_encode
if (function_exists('json_encode')) {
  echo json_encode($datos);
} else {
  // Conversión manual muy básica si json_encode no está disponible
  echo '[';
  for ($i = 0; $i < count($datos); $i++) {
    echo '{';
    echo '"id":"' . $datos[$i]['id'] . '","text":"' . $datos[$i]['text'] . '"';
    echo '}';
    if ($i < count($datos) - 1) echo ',';
  }
  echo ']';
}
?>

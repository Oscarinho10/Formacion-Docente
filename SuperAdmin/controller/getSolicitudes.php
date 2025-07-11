<?php
include('../../config/conexion.php');

// Función para cargar fechas de archivo .log
function cargarFechasSolicitud($archivo) {
    $fechas = array();

    if (file_exists($archivo)) {
        $lineas = file($archivo);
        foreach ($lineas as $linea) {
            $partes = explode('|', $linea);
            if (count($partes) == 2) {
                $fecha = trim($partes[0]);
                $correo = trim($partes[1]);
                $fechas[$correo] = $fecha;
            }
        }
    }

    return $fechas;
}

$fechasSolicitud = cargarFechasSolicitud('../../logs/solicitudes_reestablecimiento.log');

// Consulta usuarios en estado "reestablecimiento"
$query = "SELECT id_usuario, nombre, apellido_paterno, apellido_materno, correo_electronico
          FROM usuarios
          WHERE estado = 'reestablecimiento'
          ORDER BY id_usuario DESC";

$result = pg_query($conn, $query);
$usuarios = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $correo = $row['correo_electronico'];
        $row['fecha_solicitud'] = isset($fechasSolicitud[$correo]) ? $fechasSolicitud[$correo] : null;
        $usuarios[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($usuarios);
?>

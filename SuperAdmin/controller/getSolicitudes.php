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

$solicitudes = array();

// Obtener usuarios con estado "reestablecimiento"
$queryUsuarios = "SELECT id_usuario AS id, nombre, apellido_paterno, apellido_materno, correo_electronico, rol, 'usuario' AS tipo
                  FROM usuarios
                  WHERE estado = 'reestablecimiento'
                  ORDER BY id_usuario DESC";

$resultUsuarios = pg_query($conn, $queryUsuarios);
if ($resultUsuarios) {
    while ($row = pg_fetch_assoc($resultUsuarios)) {
        $correo = $row['correo_electronico'];
        $row['fecha_solicitud'] = isset($fechasSolicitud[$correo]) ? $fechasSolicitud[$correo] : null;
        $solicitudes[] = $row;
    }
}

// Obtener administradores con estado "reestablecimiento"
$queryAdmins = "SELECT id_admin AS id, nombre, apellido_paterno, apellido_materno, correo_electronico, rol, 'administrador' AS tipo
                FROM administradores
                WHERE estado = 'reestablecimiento'
                ORDER BY id_admin DESC";

$resultAdmins = pg_query($conn, $queryAdmins);
if ($resultAdmins) {
    while ($row = pg_fetch_assoc($resultAdmins)) {
        $correo = $row['correo_electronico'];
        $row['fecha_solicitud'] = isset($fechasSolicitud[$correo]) ? $fechasSolicitud[$correo] : null;
        $solicitudes[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($solicitudes);

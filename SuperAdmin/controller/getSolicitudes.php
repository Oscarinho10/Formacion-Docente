<?php
include('../../config/conexion.php');

// Función para cargar fechas de archivo .log
function cargarFechasSolicitud($archivo)
{
    $fechas = array();

    if (!file_exists($archivo)) {
        return $fechas;
    }

    $lineas = file($archivo);
    foreach ($lineas as $linea) {
        // Separar por |
        $partes = explode('|', $linea);
        if (count($partes) < 2) continue;

        // Limpiar correo (quitar paréntesis y espacios)
        $correo_raw = trim($partes[1]);
        $correo_limpio = strtolower(preg_replace('/\s*\(.*?\)\s*/', '', $correo_raw));

        // Validación básica del correo (sin filter_var)
        if (!preg_match('/^[a-z0-9._%-]+@[a-z0-9.-]+\.[a-z]{2,4}$/', $correo_limpio)) {
            continue;
        }

        // Limpiar y extraer la fecha
        $cruda = trim($partes[0]);
        $cruda = str_replace('a las', '', $cruda);
        $cruda = preg_replace('/[^0-9:\-\s]/', '', $cruda); // quitar texto no deseado

        // Validar formato YYYY-MM-DD HH:MM:SS
        if (preg_match('/^\d{4}-\d{2}-\d{2}[\s]+\d{2}:\d{2}:\d{2}$/', $cruda)) {
            $fecha_valida = $cruda;
        } else {
            $fecha_valida = null;
        }

        // Si la fecha es válida, la guardamos
        if ($fecha_valida) {
            $fechas[$correo_limpio] = $fecha_valida;
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

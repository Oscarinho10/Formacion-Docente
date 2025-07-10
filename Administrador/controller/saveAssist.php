<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin'); // O ajusta el rol si también aplica para instructores
include_once('../../config/auditor.php');

// Leer JSON
$json = file_get_contents("php://input");
$input = json_decode($json, true);

// Validaciones básicas
if (!is_array($input) || !isset($input['id_usuario']) || !isset($input['asistencias'])) {
    echo json_encode(array('status' => 'error', 'mensaje' => 'Datos inválidos.'));
    exit;
}

$id_usuario = intval($input['id_usuario']);
$asistencias = $input['asistencias'];

if ($id_usuario <= 0 || !is_array($asistencias) || count($asistencias) === 0) {
    echo json_encode(array('status' => 'error', 'mensaje' => 'Parámetros incompletos o vacíos.'));
    exit;
}

// Obtener nombre del usuario (para auditoría)
$resNombre = pg_query($conn, "SELECT nombre, apellido_paterno, apellido_materno FROM usuarios WHERE id_usuario = $id_usuario");
$nombre_usuario = 'Usuario desconocido';
if ($resNombre && pg_num_rows($resNombre) > 0) {
    $u = pg_fetch_assoc($resNombre);
    $nombre_usuario = trim($u['nombre'] . ' ' . $u['apellido_paterno'] . ' ' . $u['apellido_materno']);
    pg_free_result($resNombre);
}

// Iniciar transacción
pg_query($conn, "BEGIN");

$actualizados = 0;
$nuevos = 0;

foreach ($asistencias as $item) {
    if (!isset($item['id_sesion']) || !isset($item['presente'])) {
        continue;
    }

    $id_sesion = intval($item['id_sesion']);
    $presente = $item['presente'] ? 'TRUE' : 'FALSE';

    if ($id_sesion <= 0) continue;

    // Verificar existencia
    $checkQuery = "SELECT id_asistencia FROM asistencias WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
    $checkResult = pg_query($conn, $checkQuery);

    if ($checkResult && pg_num_rows($checkResult) > 0) {
        // Ya existe: actualizar
        $update = "UPDATE asistencias SET presente = $presente WHERE id_usuario = $id_usuario AND id_sesion = $id_sesion";
        pg_query($conn, $update);
        $actualizados++;
    } else {
        // No existe: insertar
        $insert = "INSERT INTO asistencias (id_sesion, id_usuario, presente) VALUES ($id_sesion, $id_usuario, $presente)";
        pg_query($conn, $insert);
        $nuevos++;
    }

    if ($checkResult) {
        pg_free_result($checkResult);
    }
}

pg_query($conn, "COMMIT");

// Registrar auditoría
$total = $actualizados + $nuevos;
$movimiento = "Registró $total asistencias ($nuevos nuevas, $actualizados actualizadas) para el usuario \"$nombre_usuario\" (ID $id_usuario)";
$modulo = "Asistencias";
registrarAuditoria($conn, $movimiento, $modulo);

echo json_encode(array('status' => 'ok', 'mensaje' => 'Asistencias registradas correctamente.'));
?>

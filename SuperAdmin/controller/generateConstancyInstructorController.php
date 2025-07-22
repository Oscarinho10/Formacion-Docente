<?php
require_once('../../config/conexion.php');
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

if (!isset($_POST['id_usuario']) || !isset($_POST['id_actividad'])) {
    echo json_encode(array('success' => false, 'message' => 'Parámetros inválidos.'));
    exit;
}

$idUsuario = (int)$_POST['id_usuario'];
$idActividad = (int)$_POST['id_actividad'];
$fechaEmision = date('Y-m-d');
$tipo = 'instructor';
$tipoConstancia = 'instructor';
$folio = strtoupper(uniqid('FDI-'));
$codigoVerificacion = strtoupper(md5(uniqid(rand(), true)));
$qrUrl = 'https://docencia.uaem.mx/formacion/PROYECTO/Formacion-Docente/login.php'; // o una URL pública para verificar constancias

// Verificar si ya existe
$queryCheck = "
SELECT id_constancia FROM constancias
WHERE id_usuario = $idUsuario AND id_actividad = $idActividad AND tipo = '$tipo';
";
$resCheck = pg_query($conn, $queryCheck);
if (pg_num_rows($resCheck) > 0) {
    echo json_encode(array('success' => false, 'message' => 'La constancia ya fue emitida.'));
    exit;
}

// Insertar constancia
$queryInsert = "
INSERT INTO constancias (id_usuario, id_actividad, tipo, tipo_constancia, fecha_emision, folio, codigo_verificacion, qr_url)
VALUES ($idUsuario, $idActividad, '$tipo', '$tipoConstancia', '$fechaEmision', '$folio', '$codigoVerificacion', '$qrUrl')
RETURNING id_constancia;
";

$resInsert = pg_query($conn, $queryInsert);
if ($row = pg_fetch_assoc($resInsert)) {
    echo json_encode(array('success' => true, 'id_constancia' => $row['id_constancia']));
} else {
    echo json_encode(array('success' => false, 'message' => 'Error al emitir la constancia.'));
}
?>

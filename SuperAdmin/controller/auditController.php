<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión
include('../../config/conexion.php');

// Consulta
$sql = "SELECT a.fecha, a.hora, ad.nombre, ad.apellido_paterno, ad.apellido_materno, a.movimiento, a.modulo
        FROM auditoria a
        INNER JOIN administradores ad ON a.id_admin = ad.id_admin
        ORDER BY a.fecha DESC, a.hora DESC";

$result = pg_query($conn, $sql);
if (!$result) {
    die("Error en la consulta: " . pg_last_error($conn));
}

// Arrays de traducción (PHP 5.2.0 compatible)
$dias_es = array(
    'Sunday' => 'Domingo', 'Monday' => 'Lunes', 'Tuesday' => 'Martes',
    'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes',
    'Saturday' => 'Sábado'
);
$meses_es = array(
    'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo',
    'April' => 'Abril', 'May' => 'Mayo', 'June' => 'Junio',
    'July' => 'Julio', 'August' => 'Agosto', 'September' => 'Septiembre',
    'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
);

// Datos
$datos = array();
while ($row = pg_fetch_assoc($result)) {
    // Traducir fecha
    $timestamp = strtotime($row['fecha']);
    $dia_en = date('l', $timestamp);
    $mes_en = date('F', $timestamp);
    $dia = date('d', $timestamp);
    $anio = date('Y', $timestamp);

    $fecha_es = $dias_es[$dia_en] . " $dia de " . $meses_es[$mes_en] . " del $anio";

    // Formatear hora
    $hora_raw = strtotime($row['hora']);
    $hora_es = date('g:i A', $hora_raw);
    $hora_es = str_replace('AM', 'a.m.', $hora_es);
    $hora_es = str_replace('PM', 'p.m.', $hora_es);

    // Armar fila
    $datos[] = array(
        'fecha' => $fecha_es,
        'hora' => $hora_es,
        'admin' => $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'],
        'movimiento' => $row['movimiento'],
        'modulo' => $row['modulo']
    );
}

// Retornar JSON
header('Content-Type: application/json');
echo json_encode($datos);
?>

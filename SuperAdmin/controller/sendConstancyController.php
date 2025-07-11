<?php
include('../../config/conexion.php');

$idUsuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
$idActividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;
$tipoConstancia = isset($_POST['tipo']) ? pg_escape_string($conn, $_POST['tipo']) : '';

// 🧹 Limpiar si el archivo debug.log es mayor a 500 KB
if (file_exists('debug.log') && filesize('debug.log') > 500000) {
  file_put_contents('debug.log', ''); // Limpia contenido
}

// Debug para PHP 5.2.0
$fp = fopen("debug.log", "a");
fwrite($fp, date("Y-m-d H:i:s") . " - id_usuario: $idUsuario | id_actividad: $idActividad | tipo: $tipoConstancia\n");
fclose($fp);

if ($idUsuario > 0 && $idActividad > 0 && $tipoConstancia != '') {
    $checkSql = "SELECT 1 FROM constancias WHERE id_usuario = $idUsuario AND id_actividad = $idActividad";
    $checkResult = pg_query($conn, $checkSql);

    if (pg_num_rows($checkResult) === 0) {
        $folio = 'FD-' . strtoupper(uniqid());
        $codigo = strtoupper(bin2hex(pack("H*", sha1(mt_rand()))));
        $fecha = date('Y-m-d');
        $qrUrl = 'https://docencia.uaem.mx/formacion/PROYECTO/Formacion-Docente/login.php';

        $insertSql = "
            INSERT INTO constancias (folio, codigo_verificacion, id_usuario, id_actividad, tipo, fecha_emision, qr_url)
            VALUES ('$folio', '$codigo', $idUsuario, $idActividad, '$tipoConstancia', '$fecha', '$qrUrl')
        ";
        $insertResult = pg_query($conn, $insertSql);

        if ($insertResult) {
            echo '{"success":true}';
        } else {
            echo '{"success":false,"message":"Error al insertar: ' . pg_last_error($conn) . '"}';
        }
    } else {
        echo '{"success":false,"message":"Ya emitida."}';
    }
} else {
    echo '{"success":false,"message":"Datos incompletos o tipo faltante."}';
}
?>

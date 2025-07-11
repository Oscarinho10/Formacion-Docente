<?php
include('../../config/conexion.php');

$idUsuario = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;
$idActividad = isset($_POST['id_actividad']) ? intval($_POST['id_actividad']) : 0;

// Debug para PHP 5.2.0
$fp = fopen("debug.log", "a");
fwrite($fp, date("Y-m-d H:i:s") . " - id_usuario: $idUsuario | id_actividad: $idActividad\n");
fclose($fp);

if ($idUsuario > 0 && $idActividad > 0) {
    $checkSql = "SELECT 1 FROM constancias WHERE id_usuario = $idUsuario AND id_actividad = $idActividad";
    $checkResult = pg_query($conn, $checkSql);

    if (pg_num_rows($checkResult) === 0) {
        $folio = 'FD-' . strtoupper(uniqid());
        $codigo = strtoupper(bin2hex(pack("H*", sha1(mt_rand()))));
        $fecha = date('Y-m-d');
        $qrUrl = 'https://docencia.uaem.mx/formacion/PROYECTO/Formacion-Docente/login.php';

        // OJO: Asegúrate de que la columna se llama así
        $insertSql = "
            INSERT INTO constancias (folio, codigo_verificacion, id_usuario, id_actividad, fecha_emision, qr_url)
            VALUES ('$folio', '$codigo', $idUsuario, $idActividad, '$fecha', '$qrUrl')
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
    echo '{"success":false,"message":"Datos incompletos."}';
}
?>

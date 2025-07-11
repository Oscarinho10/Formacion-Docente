<?php
include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = isset($_POST['correo']) ? pg_escape_string($_POST['correo']) : '';

    if ($correo == '') {
        echo 'Correo no válido.';
        exit;
    }

    $query_check = "SELECT id_usuario FROM usuarios WHERE correo_electronico = '$correo'";
    $result = pg_query($conn, $query_check);

    if ($result && pg_num_rows($result) > 0) {
        $update = "UPDATE usuarios SET estado = 'reestablecimiento' WHERE correo_electronico = '$correo'";
        $res_update = pg_query($conn, $update);

        if ($res_update) {
            // ✅ GUARDAR EN ARCHIVO LOG
            $logDir = dirname(__FILE__) . '/../../logs';
            if (!file_exists($logDir)) {
                mkdir($logDir, 0777, true); // Crear carpeta si no existe
            }

            $fecha = date('Y-m-d', strtotime('-1 hour'));
            $hora = date('H:i:s', strtotime('-1 hour'));
            $log = $fecha . " a las " . $hora . " | " . $correo . "\n";
            file_put_contents($logDir . '/solicitudes_reestablecimiento.log', $log, FILE_APPEND);

            echo 'ok';
        } else {
            echo 'Error al actualizar estado.';
        }
    } else {
        echo 'Correo no encontrado.';
    }
} else {
    echo 'Método no permitido.';
}

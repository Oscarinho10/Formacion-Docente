<?php
include('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = isset($_POST['correo']) ? pg_escape_string($correo = trim($_POST['correo'])) : '';

    if ($correo == '') {
        echo 'Correo no válido.';
        exit;
    }

    // Buscar primero en tabla de usuarios
    $query_check_user = "SELECT id_usuario FROM usuarios WHERE correo_electronico = '$correo'";
    $result_user = pg_query($conn, $query_check_user);

    if ($result_user && pg_num_rows($result_user) > 0) {
        $update = "UPDATE usuarios SET estado = 'reestablecimiento' WHERE correo_electronico = '$correo'";
        $res_update = pg_query($conn, $update);
        $tipo_usuario = 'usuario';
    } else {
        // Buscar en tabla de administradores
        $query_check_admin = "SELECT id_admin FROM administradores WHERE correo_electronico = '$correo'";
        $result_admin = pg_query($conn, $query_check_admin);

        if ($result_admin && pg_num_rows($result_admin) > 0) {
            $update = "UPDATE administradores SET estado = 'reestablecimiento' WHERE correo_electronico = '$correo'";
            $res_update = pg_query($conn, $update);
            $tipo_usuario = 'administrador';
        } else {
            echo 'Correo no encontrado.';
            exit;
        }
    }

    if ($res_update) {
        // ✅ GUARDAR EN ARCHIVO LOG
        $logDir = dirname(__FILE__) . '/../../logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true); // Crear carpeta si no existe
        }

        $fecha = date('Y-m-d', strtotime('-1 hour'));
        $hora = date('H:i:s', strtotime('-1 hour'));
        $log = $fecha . " a las " . $hora . " | $correo ($tipo_usuario)\n";
        file_put_contents($logDir . '/solicitudes_reestablecimiento.log', $log, FILE_APPEND);

        echo 'ok';
    } else {
        echo 'Error al actualizar estado.';
    }
} else {
    echo 'Método no permitido.';
}

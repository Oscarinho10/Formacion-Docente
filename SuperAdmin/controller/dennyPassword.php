<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo_electronico'])) {
    $correo = pg_escape_string($conn, $_POST['correo_electronico']);
    $mensaje = '';
    $logFile = dirname(__FILE__) . '/../../logs/solicitudes_reestablecimiento.log';
    $denegado = false;

    // Intentar actualizar en tabla usuarios
    $sqlUser = "UPDATE usuarios
                SET estado = 'inactivo'
                WHERE correo_electronico = '$correo' AND estado = 'reestablecimiento'";
    $updateUsuario = pg_query($conn, $sqlUser);

    if ($updateUsuario && pg_affected_rows($updateUsuario) > 0) {
        $mensaje = "Solicitud denegada. El usuario podrá volver a solicitar recuperación.";
        $denegado = true;
    } else {
        // Intentar actualizar en tabla administradores
        $sqlAdmin = "UPDATE administradores
                     SET estado = 'inactivo'
                     WHERE correo_electronico = '$correo' AND estado = 'reestablecimiento'";
        $updateAdmin = pg_query($conn, $sqlAdmin);

        if ($updateAdmin && pg_affected_rows($updateAdmin) > 0) {
            $mensaje = "Solicitud denegada. El administrador podrá volver a solicitar recuperación.";
            $denegado = true;
        } else {
            $mensaje = "No se pudo denegar la solicitud.";
        }
    }

    // Eliminar del log si fue denegado
    if ($denegado && file_exists($logFile)) {
        $nuevasLineas = array();
        $archivo = fopen($logFile, 'r');
        if ($archivo) {
            while (!feof($archivo)) {
                $linea = fgets($archivo);
                if (strpos($linea, $correo) === false) {
                    $nuevasLineas[] = $linea;
                }
            }
            fclose($archivo);

            $archivo = fopen($logFile, 'w');
            if ($archivo) {
                foreach ($nuevasLineas as $linea) {
                    fwrite($archivo, $linea);
                }
                fclose($archivo);
            }
        }
    }

    echo $mensaje;
} else {
    echo 'Solicitud inválida.';
}

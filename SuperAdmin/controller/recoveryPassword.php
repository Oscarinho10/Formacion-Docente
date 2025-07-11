<?php
include('../../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    $correo = pg_escape_string($conn, $_POST['correo']);
    $passDefault = sha1('uaem2025'); // Compatible con PHP 5.2.0
    $mensaje = '';
    $logFile = dirname(__FILE__) . '/../../logs/solicitudes_reestablecimiento.log';
    $restablecido = false;

    // Actualizar en tabla usuarios
    $sqlUser = "UPDATE usuarios
                SET estado = 'activo', contrasena = '$passDefault'
                WHERE correo_electronico = '$correo' AND estado = 'reestablecimiento'";
    $updateUsuario = pg_query($conn, $sqlUser);

    if ($updateUsuario && pg_affected_rows($updateUsuario) > 0) {
        $mensaje = "Contraseña restablecida y cuenta de usuario activada.";
        $restablecido = true;
    } else {
        // Actualizar en tabla administradores
        $sqlAdmin = "UPDATE administradores
                     SET estado = 'activo', contrasena = '$passDefault'
                     WHERE correo_electronico = '$correo' AND estado = 'reestablecimiento'";
        $updateAdmin = pg_query($conn, $sqlAdmin);

        if ($updateAdmin && pg_affected_rows($updateAdmin) > 0) {
            $mensaje = "Contraseña restablecida y cuenta de administrador activada.";
            $restablecido = true;
        } else {
            $mensaje = "No se pudo restablecer. Verifica el estado o correo.";
        }
    }

    // Eliminar del log si fue restablecido
    if ($restablecido && file_exists($logFile)) {
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

            // Reescribir archivo sin la línea eliminada
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

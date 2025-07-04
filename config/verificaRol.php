<?php
session_start();

function verificarRol($rolPermitido) {
    // Tiempo máximo de inactividad en segundos (10 minutos)
    $inactividad = 600;

    if (isset($_SESSION['ultimo_acceso'])) {
        $tiempo_inactivo = time() - $_SESSION['ultimo_acceso'];
        if ($tiempo_inactivo > $inactividad) {
            session_unset();
            session_destroy();
            header("Location: ../login.php?exp=1");
            exit;
        }
    }

    // Actualiza tiempo de último acceso
    $_SESSION['ultimo_acceso'] = time();

    // Verifica que el usuario esté autenticado y tenga el rol adecuado
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != $rolPermitido) {
        header("Location: ../login.php");
        exit;
    }

    // Evitar navegación con botón "Atrás" después de logout
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}
?>

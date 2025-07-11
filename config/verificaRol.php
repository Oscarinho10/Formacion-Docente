<?php
session_start();

// Ruta absoluta desde la raíz web (no depende del include)
$loginUrl = '/formacion/PROYECTO/Formacion-Docente/login.php';

function verificarRol($rolPermitido)
{
    global $loginUrl; // Usamos esta variable para evitar problemas de inclusión

    $inactividad = 600;

    if (isset($_SESSION['ultimo_acceso'])) {
        $tiempo_inactivo = time() - $_SESSION['ultimo_acceso'];
        if ($tiempo_inactivo > $inactividad) {
            session_unset();
            session_destroy();
            header("Location: $loginUrl?exp=1");
            exit;
        }
    }

    $_SESSION['ultimo_acceso'] = time();

    if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != $rolPermitido) {
        header("Location: $loginUrl");
        exit;
    }

    // Evitar navegación con botón "Atrás"
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

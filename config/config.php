<?php
$host = $_SERVER['HTTP_HOST'];
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';

// Verifica si estás en localhost (entorno local)
if (strpos($host, 'localhost') !== false) {
    define('RUTA_BASE', '/formacion/PROYECTO/Formacion-Docente');
} else {
    define('RUTA_BASE', '/PROYECTO/Formacion-Docente'); // sin /formacion en el servidor
}

define('BASE_URL', $protocolo . $host . RUTA_BASE);
?>
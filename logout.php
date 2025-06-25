<?php
session_start();
session_unset();    // Limpia todas las variables de sesión
session_destroy();  // Destruye la sesión actual

// Redirige al login (o a la página principal si prefieres)
header("Location: login.php");
exit;
?>

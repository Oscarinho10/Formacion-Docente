<?php
session_start();
include('./config/conexion.php');

if (isset($_POST['login'])) {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);
    $hashed_contrasena = sha1($contrasena); // Encriptar contraseña

    $usuario = null;
    $rol = '';
    $tipo = '';

    // Buscar en tabla administradores
    $query = "SELECT * FROM administradores WHERE correo_electronico = '$correo' AND contrasena = '$hashed_contrasena'";
    $resultado = pg_query($conn, $query);

    if ($resultado && pg_num_rows($resultado) == 1) {
        $usuario = pg_fetch_assoc($resultado);
        $rol = $usuario['rol'];
        $tipo = 'administrador';
    } else {
        // Buscar en tabla usuarios si no fue encontrado en administradores
        $query = "SELECT * FROM usuarios WHERE correo_electronico = '$correo' AND contrasena = '$hashed_contrasena'";
        $resultado = pg_query($conn, $query);

        if ($resultado && pg_num_rows($resultado) == 1) {
            $usuario = pg_fetch_assoc($resultado);
            $rol = $usuario['rol'];
            $tipo = 'usuario';
        }
    }

    if ($usuario) {
        // Guardar datos del usuario en sesión
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol;
        $_SESSION['tipo'] = $tipo;

        // Redirigir según el rol
        switch ($rol) {
            case 'superAdmin':
                header("Location: SuperAdmin/initSuper.php");
                break;
            case 'admin':
                header("Location: Administrador/initAdmin.php");
                break;
            case 'participante':
                header("Location: User/initUser.php");
                break;
            case 'instructor':
                header("Location: Instructor/instructorCertificate.php");
                break;
            default:
                header("Location: inicio.php");
        }
        exit;
    } else {
        echo "<script>alert('Correo o contraseña incorrectos');</script>";
    }
}
?>

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
    $id_usuario = null;

    // Buscar en tabla administradores con estado activo
    $query = "SELECT * FROM administradores 
              WHERE correo_electronico = '$correo' 
              AND contrasena = '$hashed_contrasena' 
              AND estado = 'activo'";
    $resultado = pg_query($conn, $query);

    if ($resultado && pg_num_rows($resultado) == 1) {
        $usuario = pg_fetch_assoc($resultado);
        $rol = $usuario['rol'];
        $tipo = 'administrador';
        $id_usuario = $usuario['id_admin'];
    } else {
        // Buscar en tabla usuarios con estado activo
        $query = "SELECT * FROM usuarios 
                  WHERE correo_electronico = '$correo' 
                  AND contrasena = '$hashed_contrasena' 
                  AND estado = 'activo'";
        $resultado = pg_query($conn, $query);

        if ($resultado && pg_num_rows($resultado) == 1) {
            $usuario = pg_fetch_assoc($resultado);
            $rol = $usuario['rol'];
            $tipo = 'usuario';
            $id_usuario = $usuario['id_usuario'];
        }
    }

    if ($usuario) {
        // Guardar datos del usuario en la sesión
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['usuario'] = $usuario['correo_electronico'];
        $_SESSION['rol'] = $rol;
        $_SESSION['tipo'] = $tipo;

        session_regenerate_id(true); // Seguridad extra

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
        // Login inválido
        header("Location: login.php?error=1");
        exit;
    }
}

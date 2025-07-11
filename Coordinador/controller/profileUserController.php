<?php
session_start();
include('../../config/conexion.php');
include_once('../../config/auditor.php');

// Verificar sesión activa
if (!isset($_SESSION['id_usuario'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo 'Sesión no válida.';
    } else {
        echo '{"error":"Sesión no válida."}';
    }
    exit;
}

$id_admin = intval($_SESSION['id_usuario']); // ID del administrador logueado

// 🔹 Obtener datos del perfil
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT nombre, apellido_paterno, apellido_materno, correo_electronico, numero_control_rfc 
              FROM administradores 
              WHERE id_admin = $id_admin";

    $result = pg_query($conn, $query);

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo '{"error":"Administrador no encontrado."}';
    }
    exit;
}

// 🔸 Actualizar datos del perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombre']) ? pg_escape_string($_POST['nombre']) : '';
    $apellido_paterno = isset($_POST['apellido_paterno']) ? pg_escape_string($_POST['apellido_paterno']) : '';
    $apellido_materno = isset($_POST['apellido_materno']) ? pg_escape_string($_POST['apellido_materno']) : '';
    $nueva_contrasena = isset($_POST['nueva_contrasena']) ? $_POST['nueva_contrasena'] : '';

    if ($nombre == '' || $apellido_paterno == '' || $apellido_materno == '') {
        echo 'Todos los campos son obligatorios.';
        exit;
    }

    // Armar UPDATE con o sin contraseña
    if ($nueva_contrasena != '') {
        $sha1_pass = sha1($nueva_contrasena); // Encriptar
        $query = "UPDATE administradores 
                  SET nombre = '$nombre', apellido_paterno = '$apellido_paterno', 
                      apellido_materno = '$apellido_materno', contrasena = '$sha1_pass' 
                  WHERE id_admin = $id_admin";
    } else {
        $query = "UPDATE administradores 
                  SET nombre = '$nombre', apellido_paterno = '$apellido_paterno', 
                      apellido_materno = '$apellido_materno' 
                  WHERE id_admin = $id_admin";
    }

    $result = pg_query($conn, $query);

    if ($result) {
        $movimiento = $nueva_contrasena != '' 
            ? "Actualizó su perfil y cambió su contraseña." 
            : "Actualizó su perfil sin cambiar la contraseña.";
        registrarAuditoria($conn, $movimiento, 'Usuarios');

        echo 'Perfil actualizado correctamente.';
    } else {
        echo 'Error al actualizar: ' . pg_last_error($conn);
    }
    exit;
}
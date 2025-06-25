<?php
include_once('../../config/conexion.php'); // ✅ Ruta relativa

global $conn;

function administradorExiste($correo_electronico, $numero_control_rfc)
{
    global $conn;

    $correo_electronico = pg_escape_string($conn, $correo_electronico);
    $numero_control_rfc = pg_escape_string($conn, $numero_control_rfc);

    $query = "SELECT 1 FROM administradores 
              WHERE correo_electronico = '$correo_electronico' 
              OR numero_control_rfc = '$numero_control_rfc' 
              LIMIT 1";

    $resultado = pg_query($conn, $query);
    return $resultado && pg_num_rows($resultado) > 0;
}

function registrarAdministrador(
    $nombre,
    $apellido_paterno,
    $apellido_materno,
    $numero_control_rfc,
    $correo_electronico,
    $fecha_nacimiento,
    $sexo
) {
    include('../../config/conexion.php');

    // Verificar duplicados
    $verifica = pg_query_params($conn, "SELECT 1 FROM administradores WHERE correo_electronico = $1 OR numero_control_rfc = $2", array($correo_electronico, $numero_control_rfc));
    if (pg_num_rows($verifica) > 0) {
        return "duplicado";
    }

    // Contraseña por defecto encriptada con SHA1
    $contrasena = sha1("admin123");
    $estado = "activo";
    $rol = "admin";
    $fecha_registro = date('Y-m-d');

    $query = "INSERT INTO administradores (
        nombre, apellido_paterno, apellido_materno,
        numero_control_rfc, correo_electronico, contrasena,
        fecha_nacimiento, sexo, estado, rol, fecha_registro
    ) VALUES (
        $1, $2, $3,
        $4, $5, $6,
        $7, $8, $9, $10, $11
    )";

    $params = array(
        $nombre,
        $apellido_paterno,
        $apellido_materno,
        $numero_control_rfc,
        $correo_electronico,
        $contrasena,
        $fecha_nacimiento,
        $sexo,
        $estado,
        $rol,
        $fecha_registro
    );

    $result = pg_query_params($conn, $query, $params);

    return $result ? "ok" : "error";
}

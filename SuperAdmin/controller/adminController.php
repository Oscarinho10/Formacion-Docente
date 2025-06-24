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

function registrarAdministrador($nombre, $apellido_paterno, $apellido_materno, $numero_control_rfc, $correo_electronico, $fecha_nacimiento, $sexo)
{
    global $conn;

    $nombre = pg_escape_string($conn, $nombre);
    $apellido_paterno = pg_escape_string($conn, $apellido_paterno);
    $apellido_materno = pg_escape_string($conn, $apellido_materno);
    $numero_control_rfc = pg_escape_string($conn, $numero_control_rfc);
    $correo_electronico = pg_escape_string($conn, $correo_electronico);
    $fecha_nacimiento = pg_escape_string($conn, $fecha_nacimiento);
    $sexo = pg_escape_string($conn, $sexo);

    if (administradorExiste($correo_electronico, $numero_control_rfc)) {
        return "duplicado";
    }

    $contrasena = md5("admin123");
    $rol = "admin";
    $estado = "activo";
    $fecha_registro = date("Y-m-d");

    $query = "INSERT INTO administradores 
        (nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo, correo_electronico, contrasena, numero_control_rfc, estado, rol, fecha_registro) 
        VALUES 
        ('$nombre', '$apellido_paterno', '$apellido_materno', '$fecha_nacimiento', '$sexo', '$correo_electronico', '$contrasena', '$numero_control_rfc', '$estado', '$rol', '$fecha_registro')";

    $resultado = pg_query($conn, $query);
    return $resultado ? "ok" : "error";
}

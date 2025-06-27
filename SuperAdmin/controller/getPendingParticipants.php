<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../config/conexion.php');

$query = "SELECT id_usuario, nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo,
                 correo_electronico, numero_control_rfc, unidad_academica, grado_academico, 
                 perfil_academico
          FROM usuarios 
          WHERE estado = 'pendiente' AND rol = 'participante'";

$result = pg_query($conn, $query);

$datos = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $datos[] = array(
            "id_usuario" => $row['id_usuario'],
            "nombre" => $row['nombre'],
            "apellido_paterno" => $row['apellido_paterno'],
            "apellido_materno" => $row['apellido_materno'],
            "fecha_nacimiento" => $row['fecha_nacimiento'],
            "sexo" => $row['sexo'],
            "correo" => $row['correo_electronico'],
            "numero_control_rfc" => $row['numero_control_rfc'],
            "unidad_academica" => $row['unidad_academica'],
            "grado_academico" => $row['grado_academico'],
            "perfil_academico" => $row['perfil_academico']
        );
    }

    echo json_encode($datos);
} else {
    echo json_encode(array("error" => pg_last_error($conn)));
}

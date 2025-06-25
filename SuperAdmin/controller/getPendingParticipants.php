<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../config/conexion.php');

// Solo para PHP 5.2.0
$query = "SELECT nombre, apellido_paterno, apellido_materno, fecha_nacimiento, sexo,
                 numero_control_rfc, correo_electronico, unidad_academica, grado_academico, 
                 perfil_academico
          FROM usuarios 
          WHERE estado = 'pendiente' AND rol = 'participante'";


$result = pg_query($conn, $query);

$datos = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $datos[] = array(
            "nombre" => $row['nombre'],
            "apellido_paterno" => $row['apellido_paterno'],
            "apellido_materno" => $row['apellido_materno'],
            "fecha_nacimiento" => $row['fecha_nacimiento'],
            "sexo" => $row['sexo'],
            "numero_control" => $row['numero_control_rfc'],
            "correo" => $row['correo_electronico'],
            "unidad_academica" => $row['unidad_academica'],
            "grado_academico" => $row['grado_academico'],
            "perfil_academico" => $row['perfil_academico']
        );
    }

    echo json_encode($datos);
} else {
    // Devolver error como JSON para evitar el error "Unexpected token <"
    echo json_encode(array("error" => pg_last_error($conn)));
}

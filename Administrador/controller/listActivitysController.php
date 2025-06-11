<?php
include('../../config/conexion.php');

// Consulta modificada para incluir los nuevos campos -->
$query = "SELECT nombre, apellido_paterno, apellido_materno, numero_control_rfc, correo, 
                 perfil_academico, unidad_academica 
          FROM usuarios 
          WHERE rol = 'participante' AND estado = 'pendiente'";

$result = pg_query($conn, $query);

$usuarios = array();
$unidades = array();
$perfiles = array();

while ($row = pg_fetch_assoc($result)) {
    $usuario = array(
        "nombre" => $row["nombre"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"],
        "numero_control_rfc" => $row["numero_control_rfc"],
        "correo" => $row["correo"],
        "perfil_academico" => $row["perfil_academico"],
        "unidad_academica" => $row["unidad_academica"]
    );
    $usuarios[] = $usuario;

    // Recolectar unidades académicas únicas -->
    if (!empty($row["unidad_academica"]) && !in_array($row["unidad_academica"], $unidades)) {
        $unidades[] = $row["unidad_academica"];
    }

    // Recolectar perfiles académicos únicos -->
    if (!empty($row["perfil_academico"]) && !in_array($row["perfil_academico"], $perfiles)) {
        $perfiles[] = $row["perfil_academico"];
    }
}

// Ordenar las listas --> 
sort($unidades);
sort($perfiles);

?>
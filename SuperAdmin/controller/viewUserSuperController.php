<?php
// Mostrar errores (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a PostgreSQL
$conn = pg_connect("host=172.21.37.83 port=5432 dbname=formacion_docente2 user=jerss password=admin");

header('Content-Type: application/json');

// Validar conexión
if (!$conn) {
    echo json_encode(array("error" => "No se pudo conectar a la base de datos"));
    exit;
}

// Consulta de usuarios activos con fecha_registro
$query = "SELECT 
    id_usuario,
    nombre,
    apellido_paterno,
    apellido_materno,
    numero_control_rfc,
    correo_electronico AS correo,
    perfil_academico,
    fecha_nacimiento,
    sexo,
    unidad_academica,
    grado_academico,
    fecha_registro
    FROM usuarios
    WHERE estado = 'activo'";

$result = pg_query($conn, $query);

if (!$result) {
    echo json_encode(array("error" => "Error en la consulta SQL"));
    exit;
}

$usuarios = array();
while ($row = pg_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);
?>

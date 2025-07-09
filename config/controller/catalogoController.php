<?php
// Consulta solo las actividades activas
$query = "SELECT * FROM actividades_formativas WHERE estado = 'activo'";
$resultado = pg_query($conn, $query);

// Verificamos si hay resultados
$hayActividades = pg_num_rows($resultado) > 0;

?>
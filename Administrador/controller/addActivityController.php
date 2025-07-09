<?php
include('../../config/conexion.php');
include_once('../../config/verificaRol.php');
verificarRol('admin'); // Solo admins pueden registrar

include_once('../../config/auditor.php');

// Rutas relativas desde este script (NO empiezan con /)
$carpetaPDF = '../../uploads/temarios/';
$carpetaIMG = '../../uploads/imagenes/';

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$tipo_evaluacion = $_POST['tipo_evaluacion'];
$descripcion = $_POST['descripcion'];
$dirigido_a = $_POST['dirigido_a'];
$modalidad = $_POST['modalidad'];
$lugar = $_POST['lugar'];
$clasificacion = $_POST['clasificacion'];
$cupo = $_POST['cupo'];
$total_horas = $_POST['total_horas'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

// --------------------
// GUARDAR TEMARIO PDF
// --------------------
$temarioRuta = '';
if (isset($_FILES['temario_pdf']) && $_FILES['temario_pdf']['error'] == 0) {
    $nombrePDF = basename($_FILES['temario_pdf']['name']);
    $rutaDestinoPDF = $carpetaPDF . $nombrePDF;

    if (move_uploaded_file($_FILES['temario_pdf']['tmp_name'], $rutaDestinoPDF)) {
        $temarioRuta = 'uploads/temarios/' . $nombrePDF;
    }
}

// --------------------
// GUARDAR IMAGEN
// --------------------
$imagenRuta = '';
if (isset($_FILES['url_imagen']) && $_FILES['url_imagen']['error'] == 0) {
    $nombreIMG = basename($_FILES['url_imagen']['name']);
    $rutaDestinoIMG = $carpetaIMG . $nombreIMG;

    if (move_uploaded_file($_FILES['url_imagen']['tmp_name'], $rutaDestinoIMG)) {
        $imagenRuta = 'uploads/imagenes/' . $nombreIMG;
    }
}

// --------------------
// INSERTAR EN BD
// --------------------
$query = "INSERT INTO actividades_formativas (
    nombre, descripcion, dirigido_a, modalidad, lugar, clasificacion,
    cupo, total_horas, fecha_inicio, fecha_fin, temario_pdf, url_imagen, estado, tipo_evaluacion
) VALUES (
    '$nombre', '$descripcion', '$dirigido_a', '$modalidad', '$lugar', '$clasificacion',
    '$cupo', '$total_horas', '$fecha_inicio', '$fecha_fin', '$temarioRuta', '$imagenRuta', 'activo', '$tipo_evaluacion'
) RETURNING id_actividad";

$resultado = pg_query($conn, $query);

// Redirigir si se inserta correctamente
if ($resultado && pg_num_rows($resultado) > 0) {
    $row = pg_fetch_assoc($resultado);
    $id_actividad = $row['id_actividad'];

    // ✅ Registrar en auditoría con nombre de la actividad
    $movimiento = "Registró la actividad formativa: " . pg_escape_string($conn, $nombre);
    registrarAuditoria($conn, $movimiento, 'Actividades formativas');

    header("Location: ../addSessions.php?id=" . $id_actividad);
    exit;
} else {
    echo "Error al guardar la actividad.";
}

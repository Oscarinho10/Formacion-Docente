<?php
include('../../config/conexion.php');

header('Content-Type: application/json'); // si editas por fetch()

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo '{"success":false,"error":"Acceso no permitido."}';
    exit;
}

// --- Rutas (iguales a AGREGAR) ---
$carpetaPDF = '../../uploads/temarios/';
$carpetaIMG = '../../uploads/imagenes/';

// --- Helper escape (sugerido con conn) ---
function esc($conn, $s) { return pg_escape_string($conn, $s); }

// --- Datos del formulario ---
$id              = intval($_POST['id']);
$nombre          = esc($conn, $_POST['nombre']);
$tipo_evaluacion = esc($conn, $_POST['tipo_evaluacion']);
$descripcion     = esc($conn, $_POST['descripcion']);
$dirigido_a      = esc($conn, $_POST['dirigido_a']);
$modalidad       = esc($conn, $_POST['modalidad']);
$lugar           = esc($conn, $_POST['lugar']);
$clasificacion   = esc($conn, $_POST['clasificacion']);
$cupo            = intval($_POST['cupo']);
$total_horas     = intval($_POST['total_horas']);
$fecha_inicio    = esc($conn, $_POST['fecha_inicio']);
$fecha_fin       = esc($conn, $_POST['fecha_fin']);

// --- Construye SET base ---
$sets = array();
$sets[] = "nombre = '$nombre'";
$sets[] = "tipo_evaluacion = '$tipo_evaluacion'";
$sets[] = "descripcion = '$descripcion'";
$sets[] = "dirigido_a = '$dirigido_a'";
$sets[] = "modalidad = '$modalidad'";
$sets[] = "lugar = '$lugar'";
$sets[] = "clasificacion = '$clasificacion'";
$sets[] = "cupo = $cupo";
$sets[] = "total_horas = $total_horas";
$sets[] = "fecha_inicio = '$fecha_inicio'";
$sets[] = "fecha_fin = '$fecha_fin'";

// --------------------
// GUARDAR TEMARIO PDF (opcional)
// --------------------
if (isset($_FILES['temario_pdf']) && $_FILES['temario_pdf']['error'] == 0) {
    $nombrePDF = basename($_FILES['temario_pdf']['name']);
    // (Opcional: valida extensión .pdf)
    $rutaDestinoPDF = $carpetaPDF . $nombrePDF;

    // Crea carpeta si no existe
    if (!file_exists($carpetaPDF)) @mkdir($carpetaPDF, 0777, true);

    if (move_uploaded_file($_FILES['temario_pdf']['tmp_name'], $rutaDestinoPDF)) {
        // guarda en BD la ruta web relativa, igual que en AGREGAR
        $temarioRuta = 'uploads/temarios/' . $nombrePDF;
        $sets[] = "temario_pdf = '" . esc($conn, $temarioRuta) . "'";
    }
}

// --------------------
// GUARDAR IMAGEN (opcional)
// --------------------
if (isset($_FILES['url_imagen']) && $_FILES['url_imagen']['error'] == 0) {
    $nombreIMG = basename($_FILES['url_imagen']['name']);
    // (Opcional: valida extensión)
    $rutaDestinoIMG = $carpetaIMG . $nombreIMG;

    // Crea carpeta si no existe
    if (!file_exists($carpetaIMG)) @mkdir($carpetaIMG, 0777, true);

    if (move_uploaded_file($_FILES['url_imagen']['tmp_name'], $rutaDestinoIMG)) {
        // guarda en BD la ruta web relativa, igual que en AGREGAR
        $imagenRuta = 'uploads/imagenes/' . $nombreIMG;
        $sets[] = "url_imagen = '" . esc($conn, $imagenRuta) . "'";
    }
}

// --- Ejecuta UPDATE ---
$setQuery = implode(', ', $sets);
$sql = "UPDATE actividades_formativas SET $setQuery WHERE id_actividad = $id";
$ok = pg_query($conn, $sql);

if ($ok) {
    echo '{"success":true}';
} else {
    echo '{"success":false,"error":"Error al actualizar la actividad."}';
}
exit;

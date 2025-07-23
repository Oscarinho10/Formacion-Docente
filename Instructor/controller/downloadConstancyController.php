<?php
require_once('../../includes/fpdf/fpdf.php');
require_once('../../config/conexion.php');

if (!$conn) {
    echo "Error de conexión a la base de datos.";
    exit;
}

$idConstancia = isset($_POST['id_constancia']) ? intval($_POST['id_constancia']) : 0;
if ($idConstancia <= 0) {
    echo "ID de constancia no proporcionado o inválido.";
    exit;
}

$isDownload = isset($_POST['download']) && $_POST['download'] === 'true';

$sql = "
    SELECT 
        c.folio,
        c.codigo_verificacion,
        c.fecha_emision,
        c.qr_url,
        a.nombre AS nombre_actividad,
        a.id_actividad,
        a.fecha_fin,
        a.total_horas,
        a.lugar,
        u.nombre,
        u.apellido_paterno,
        u.apellido_materno
    FROM constancias c
    JOIN actividades_formativas a ON a.id_actividad = c.id_actividad
    JOIN usuarios u ON u.id_usuario = c.id_usuario
    WHERE c.id_constancia = $idConstancia
      AND c.tipo = 'instructor'
    LIMIT 1;
";

$res = pg_query($conn, $sql);
if (!$res || pg_num_rows($res) === 0) {
    echo "No se encontró la constancia del instructor.";
    exit;
}

$row = pg_fetch_assoc($res);

$nombreCompleto = $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'];
$actividad = $row['nombre_actividad'];
$fechaFin = date("d/m/Y", strtotime($row['fecha_fin']));
$totalHoras = $row['total_horas'];
$lugar = $row['lugar'];
$idActividad = $row['id_actividad'];
$folio = $row['folio'];
$clave = $row['codigo_verificacion'];
$qrLocalRel = $row['qr_url'];

$titulo = 'CONSTANCIA DE INSTRUCTOR';
$descripcion = "Por su destacada participación como instructor(a) en el $actividad, con una duración total de $totalHoras horas.";

// Plantilla y PDF
$nombreImagenFondo = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/plantilla_constancia.jpg';
$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$pdf->Image($nombreImagenFondo, 0, 0, 280, 216);

// Título
$pdf->SetFont('Arial', 'B', 28);
$pdf->SetTextColor(0, 0, 64);
$pdf->SetXY(0, 45);
$pdf->Cell(0, 12, utf8_decode($titulo), 0, 1, 'C');

// Nombre
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(0, 70);
$pdf->Cell(0, 10, utf8_decode($nombreCompleto), 0, 1, 'C');

// Descripción
$pdf->SetFont('Arial', '', 14);
$pdf->SetXY(30, 85);
$pdf->MultiCell(220, 8, utf8_decode($descripcion), 0, 'C');

// Lugar y fecha
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(0, 135);
$pdf->Cell(0, 10, utf8_decode("$lugar, a $fechaFin"), 0, 1, 'C');

// Folio y clave
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(15, 185);
$pdf->Cell(0, 6, 'Folio: ' . $folio, 0, 1, 'L');
$pdf->SetX(15);
$pdf->Cell(0, 6, 'Clave: ' . $clave, 0, 1, 'L');

// Cargar QR local
$qrPath = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/' . $qrLocalRel;
if (file_exists($qrPath)) {
    $pdf->Image($qrPath, 235, 155, 30, 30);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(150);
    $pdf->SetXY(235, 170);
    $pdf->Cell(30, 10, utf8_decode('QR no disponible'), 0, 0, 'C');
}

// Nombre de archivo
$nombreActividad = preg_replace('/[^A-Za-z0-9 ]/', '', $actividad); // Limpia caracteres especiales
$nombrePersona = str_replace(' ', '_', $nombreCompleto);
$nombrepdf = 'Constancia_Instructor_' . $nombrePersona . '_' . $nombreActividad . '.pdf';


if ($isDownload) {
    $pdf->Output($nombrepdf, 'D');
} else {
    $pdf->Output($nombrepdf, 'I');
}
?>

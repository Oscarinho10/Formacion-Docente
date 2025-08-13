<?php
require_once('../../includes/fpdf/fpdf.php');

$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();

// Intenta cargar la imagen sin consulta SQL ni otros elementos
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/plantilla_constancia.jpg';
if (!file_exists($imagePath)) {
    echo "La imagen no se encuentra en la ruta: $imagePath";
    exit;
}
$pdf->Image($imagePath, 0, 0, 280, 216);  // Intenta cargar solo la imagen
$pdf->SetFont('Arial', 'B', 28);
$pdf->SetXY(0, 45);
$pdf->Cell(0, 12, 'CONSTANCIA DE PARTICIPACIÓN', 0, 1, 'C');

$pdf->Output('constancia_prueba.pdf', 'I'); // Forzar descarga
?>

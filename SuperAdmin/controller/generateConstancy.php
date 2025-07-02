<?php
require_once('../../includes/fpdf/fpdf.php');

$correo = 'juan.perez@correo.com'; // nombre o correo que aparecerá
$nombreImagenFondo = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/plantilla_constancia.jpg';

$pdf = new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// --- Fondo con firma y diseño completo ---
$pdf->Image($nombreImagenFondo, 0, 0, 280, 216); // Ancho x Alto para Letter en paisaje (mm)

// --- Título principal ---
$pdf->SetFont('Arial', 'B', 28);
$pdf->SetTextColor(0, 0, 64); // Azul fuerte
$pdf->SetXY(0, 45); // Ajusta vertical
$pdf->Cell(0, 12, utf8_decode('CONSTANCIA DE PARTICIPACIÓN'), 0, 1, 'C');

// --- Nombre del participante ---
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(0, 70);
$pdf->Cell(0, 10, utf8_decode($correo), 0, 1, 'C');

// --- Descripción del curso ---
$pdf->SetFont('Arial', '', 14);
$pdf->SetXY(30, 85);
$pdf->MultiCell(220, 8, utf8_decode("Por su participación como asistente en el Curso-taller de Inteligencia Artificial, impartido del 20 al 24 de enero de 2025, con una duración total de 20 horas."), 0, 'C');

// --- Fecha ---
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(0, 135);
$pdf->Cell(0, 10, utf8_decode("Cuernavaca, Morelos, México, a 24 de enero de 2025"), 0, 1, 'C');

// --- Código QR ---
$qrUrl = 'http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://ejemplo.com/constancia/' . urlencode($correo);
$tempFile = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/temp/temp_qr.png';
if (!file_exists(dirname($tempFile))) mkdir(dirname($tempFile), 0777, true);
file_put_contents($tempFile, file_get_contents($qrUrl));

$pdf->Image($tempFile, 235, 155, 30, 30); // Posicionado en esquina inferior derecha

// --- Folio y clave ---
$pdf->SetFont('Arial', '', 10);
$folio = strtoupper(uniqid('FOLIO_'));
$clave = strtoupper(uniqid('CLAVE_'));

$pdf->SetXY(15, 185);
$pdf->Cell(0, 6, 'Folio: ' . $folio, 0, 1, 'L');
$pdf->SetX(15);
$pdf->Cell(0, 6, 'Clave: ' . $clave, 0, 1, 'L');

// --- Eliminar temporal QR ---
unlink($tempFile);

// Salida
$nombrepdf = 'constancia_' . $correo . '.pdf';
$pdf->Output($nombrepdf, 'I');
?>

<?php
// Ruta absoluta para la imagen
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/img/SIGEM.PNG';

// Incluir la librería FPDF
require_once('../../includes/fpdf/fpdf.php'); 

// Crear el objeto PDF
$pdf = new FPDF();
$pdf->AddPage('L', 'letter');  // Asegúrate de usar la orientación correcta ('L' para paisaje)

// Usar la fuente predeterminada "Arial" para el título
$pdf->SetFont('Arial', 'B', 36);
$pdf->SetTextColor(0, 0, 0);  // Negro
$pdf->Cell(0, 50, 'CONSTANCIA DE PARTICIPACION', 0, 1, 'C');  // Título centrado
$pdf->Ln(10); // Salto de línea después del título

// Usar la fuente predeterminada "Arial" para el resto del texto
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(0, 10, utf8_decode('La Universidad Autónoma del Estado de Morelos,'), 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode('y la Secretaría Académica,'), 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode('a través de la Dirección General Educación Superior'), 0, 1, 'C');
$pdf->Ln(10);

// Añadir la palabra "Otorga la presente"
$pdf->SetFont('Arial', 'I', 18);
$pdf->Cell(0, 10, utf8_decode('Otorga la presente'), 0, 1, 'C');
$pdf->Ln(20);  // Salto de línea para separar

// Nombre del participante
$pdf->SetFont('Arial', 'B', 24);
$pdf->Cell(0, 10, 'A: ' . utf8_decode($correo), 0, 1, 'C');
$pdf->Ln(10);  // Salto de línea para separar

// Información sobre el curso
$pdf->SetFont('Arial', '', 16);
$pdf->MultiCell(0, 10, utf8_decode("Por su participación como asistente en el Curso-taller de Inteligencia Artificial, impartido del 20 al 24 de enero de 2025 con una duración total de 20 horas."), 0, 'C');
$pdf->Ln(20);  // Espacio después de la información del curso

// Fecha de emisión
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 10, utf8_decode("Cuernavaca, Morelos, México, a 24 de enero de 2025"), 0, 1, 'L');
$pdf->Ln(20);  // Espacio después de la fecha

// Descargar la imagen del código QR
$qrUrl = 'http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://ejemplo.com/constancia/' . urlencode($correo);

// Ruta temporal para guardar el QR
$tempFile = $_SERVER['DOCUMENT_ROOT'] . '/formacion/PROYECTO/Formacion-Docente/assets/temp/temp_qr_code.png'; // Nueva carpeta 'temp'

// Verifica si la carpeta 'temp' existe, si no, crea la carpeta
if (!file_exists(dirname($tempFile))) {
    mkdir(dirname($tempFile), 0777, true);
}

// Usar file_get_contents() y file_put_contents() para descargar la imagen y guardarla
file_put_contents($tempFile, file_get_contents($qrUrl));

// Generar código QR desde el archivo temporal
$pdf->SetXY(190, 120);  // Posicionar el código QR a la derecha
$pdf->Image($tempFile, 0, 0, 30, 30);

// Generar un número de folio y clave para la constancia
$folio = strtoupper(uniqid('FOLIO_'));
$clave = strtoupper(uniqid('CLAVE_'));
$pdf->Ln(40);  // Espacio antes del folio y clave
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Folio: ' . $folio, 0, 1, 'L');
$pdf->Cell(0, 10, 'Clave: ' . $clave, 0, 1, 'L');
$pdf->Ln(20);  // Espacio después del folio y clave

// Firma
$pdf->SetFont('Arial', 'I', 14);
$pdf->Cell(0, 10, utf8_decode('Firma del Responsable'), 0, 1, 'C');

// Eliminar el archivo temporal después de usarlo
unlink($tempFile);

// Generar el PDF y mostrarlo al usuario
$nombrepdf = 'constancia_' . $correo . '.pdf';
$pdf->Output($nombrepdf, 'I'); // 'I' para mostrar el PDF en el navegador
?>

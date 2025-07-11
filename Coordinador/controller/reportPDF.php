<?php
while (ob_get_level()) ob_end_clean();
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Reporte_Actividades_SIGEMFD.pdf"');

require_once('../../includes/fpdf/fpdf.php');

// Obtener los datos JSON crudos desde el cuerpo
$input = file_get_contents('php://input');
$data = array();

if ($input) {
    $data = json_decode($input, true);
}

// Fallback si no hay datos válidos
if (!is_array($data) || count($data) == 0) {
    $data[] = array(
        "tipo" => "Curso",
        "actividad" => "Ejemplo",
        "instructor" => "N/A",
        "duracion" => "10h",
        "modalidad" => "Presencial",
        "fecha" => "2023-01-01",
        "horario" => "09:00 - 12:00",
        "participantes" => 10,
        "asistidos" => 8
    );
}

// Obtener encabezados dinámicos
$headers = array_keys($data[0]);

class PDF extends FPDF
{
    var $colHeaders;
    var $rowData;

    function SetData($headers, $rows)
    {
        $this->colHeaders = $headers;
        $this->rowData = $rows;
    }

    function Header()
    {
        if (file_exists('../../assets/img/logo-uaem.png')) {
            $this->Image('../../assets/img/logo-uaem.png', 10, 6, 25);
        }
        if (file_exists('../../assets/img/SIGEM-FD.jpg')) {
            $this->Image('../../assets/img/SIGEM-FD.jpg', 260, 6, 25); // ajustado para landscape
        }

        $this->SetFont('Arial', 'B', 14);
        $this->SetY(20);
        $this->Cell(0, 10, utf8_decode('Departamento de Evaluación y Profesionalización de la Docencia'), 0, 1, 'C');
        $this->Ln(2);
        $this->SetDrawColor(0, 102, 153);
        $this->Line(10, $this->GetY(), 287, $this->GetY()); // ancho de A4 horizontal
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function FancyTable()
    {
        $headers = $this->colHeaders;
        $data = $this->rowData;
        $colCount = count($headers);
        $pageWidth = $this->GetPageWidth() - 20;

        // Asignar ancho específico a columnas largas
        $colWidths = array();
        foreach ($headers as $key) {
            if (in_array(strtolower($key), array('actividad', 'instructor'))) {
                $colWidths[] = 40;
            } elseif (in_array(strtolower($key), array('descripcion', 'observaciones'))) {
                $colWidths[] = 50;
            } else {
                $colWidths[] = max(18, ($pageWidth - 80) / ($colCount - 2));
            }
        }

        // Calcular margen izquierdo para centrar la tabla
        $totalTableWidth = array_sum($colWidths);
        $leftMargin = ($this->GetPageWidth() - $totalTableWidth) / 2;

        // Encabezado
        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255);
        $this->SetFont('Arial', 'B', 8);
        $this->SetX($leftMargin);

        for ($i = 0; $i < $colCount; $i++) {
            $this->Cell($colWidths[$i], 7, utf8_decode(ucwords($headers[$i])), 1, 0, 'C', true);
        }
        $this->Ln();

        // Cuerpo
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 7);
        $fill = false;

        foreach ($data as $row) {
            $this->SetX($leftMargin);
            for ($i = 0; $i < $colCount; $i++) {
                $key = $headers[$i];
                $val = isset($row[$key]) ? utf8_decode($row[$key]) : '-';

                if (is_array($val)) $val = '[array]';
                if (is_bool($val)) $val = $val ? 'Sí' : 'No';

                $align = is_numeric($val) ? 'C' : 'L';
                $this->Cell($colWidths[$i], 6, $val, 1, 0, $align, $fill);
            }
            $this->Ln();
            $fill = !$fill;
        }

        $this->SetX($leftMargin);
        $this->Cell($totalTableWidth, 0, '', 'T');
    }
}

// Crear PDF
$pdf = new PDF('L', 'mm', 'A4'); // landscape
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->MultiCell(0, 10, utf8_decode('Reporte general de actividades del programa SIGEM-FD'), 0, 'C');
$pdf->Ln(2);

// Asignar los datos dinámicos
$pdf->SetData($headers, $data);
$pdf->FancyTable();

// Enviar PDF al navegador
$pdf->Output('I', 'Reporte_Actividades_SIGEMFD.pdf');
exit;

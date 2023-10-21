<?php
require('../../Libraries/fpdf/fpdf.php');
require('../../Libraries/fpdf/fpdf_easytable.php');

class PDF extends FPDF
{
function Header()
{
// Encabezado personalizado
$this->SetFont('Arial', 'B', 12);
$this->Cell(190, 10, 'Informe de Consultas Clinica Veterinaria El Gato', 0, 1, 'C');
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
}

function CreateTable($header, $data)
{
    foreach ($header as $col) {
        $this->Cell(40, 7, $col, 1);
    }
    $this->Ln();

    foreach ($data as $row) {
        $this->Cell(40, 50, $row['Cliente'], 1);
        $this->Cell(40, 50, $row['Mascota'], 1);

        $html = $row['Descripción'];
        $this->WriteHTML($html);

        $this->Cell(40, 50, $row['Fecha'], 1);
        $this->Cell(40, 50, $row['Hora'], 1);
        $this->Ln();
    }
}

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetTextColor(0, 0, 0);

$html = '<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Hora</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Juan Pérez</td>
            <td>Perro</td>
            <td>Mi perro está enfermo</td>
            <td>2023-07-20</td>
            <td>10:00</td>
        </tr>
        <tr>
            <td>María López</td>
            <td>Gato</td>
            <td>Mi gato está comiendo mucho</td>
            <td>2023-07-21</td>
            <td>11:00</td>
        </tr>
    </tbody>
</table>';

$pdf->WriteHTML($html);

$pdf->Output('Informe_Consultas.pdf', 'D');


?>
<?php
require('fpdf/fpdf.php');
require_once("../models/albumes.model.php");

$pdf = new FPDF();
$pdf->AddPage();
$album = new Album();

// Encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Text(30, 10, 'Reporte de Albumes');
$pdf->SetFont('Arial', '', 12);
$pdf->Text(30, 20, 'Listado completo de albumes disponibles en la base de datos');

// Pie de página
$pdf->SetFont('Arial', '', 12);
$pdf->SetY(-15);
$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo(), 0, 0, 'C');

// Usando el método `todos()` de la clase `Album` para obtener la lista de álbumes
$listaAlbumes = $album->todos();
$pdf->Ln(30);

// Encabezado de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, "#", 1);
$pdf->Cell(50, 10, "Titulo", 1);
$pdf->Cell(40, 10, "Genero", 1);
$pdf->Cell(30, 10, "Anio", 1);
$pdf->Cell(60, 10, "Discografica", 1);
$pdf->Ln();

// Relleno de la tabla con los datos de los álbumes
$index = 1;
$pdf->SetFont('Arial', '', 12);
while ($alb = mysqli_fetch_assoc($listaAlbumes)) {
    $pdf->Cell(10, 10, $index, 1);
    $pdf->Cell(50, 10, $alb["titulo"], 1);
    $pdf->Cell(40, 10, $alb["genero"], 1);
    $pdf->Cell(30, 10, $alb["anio_lanzamiento"], 1);
    $pdf->Cell(60, 10, $alb["discografica"], 1);
    $pdf->Ln();
    $index++;
}

// Añadir imagen (opcional)
$pdf->Image('../public/images/logo.png', 10, 10, 20, 20, "PNG");
$pdf->Image('https://www.uniandes.edu.ec/wp-content/uploads/2024/07/2-headerweb-home-2.png', 0, 282, 15, 0, 'PNG');

// Salida del archivo PDF
$pdf->Output();
?>

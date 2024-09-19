<?php
require('fpdf/fpdf.php');
require_once("../models/albumes.model.php");

$pdf = new FPDF();
$pdf->AddPage();
$album = new Album();

// Añadir imagen al encabezado (ajusta la ruta según la ubicación de la imagen)
if (file_exists('../public/images/logo.png')) {
    $pdf->Image('../public/images/logo.png', 10, 10, 20, 20, "PNG");
} else {
    // Establecer la fuente antes de usar Text()
    $pdf->SetFont('Arial', 'I', 12);  // Definir una fuente (Arial, Italic, tamaño 12)
    $pdf->Text(10, 10, 'Logo no encontrado');
}

// Encabezado del documento
$pdf->SetFont('Arial', 'B', 16);
$pdf->Text(40, 10, 'Reporte de Albumes');
$pdf->SetFont('Arial', '', 12);
$pdf->Text(40, 20, 'Listado completo de albumes disponibles en la base de datos');

// Pie de página
$pdf->SetY(-15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo(), 0, 0, 'C');

// Obtener la lista de álbumes
$listaAlbumes = $album->todos();
if ($listaAlbumes) {
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
} else {
    // Mensaje si no hay álbumes disponibles
    $pdf->Ln(30);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'No se encontraron álbumes.', 0, 1, 'C');
}

// Salida del archivo PDF
$pdf->Output();
?>

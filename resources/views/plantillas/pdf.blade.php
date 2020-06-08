<?php

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($factura);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream('FicheroEjemplo.pdf');
$dompdf-> stream("FicheroEjemplo.pdf", array("Attachment" => false));
//exit; // sin esta salida el pdf se carga como html y se ven caracteres extraños, (solo en el servidor, en local anda bien)


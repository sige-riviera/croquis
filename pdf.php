<?php
$file = $_GET["file"];

$path_parts = pathinfo($file);
$output = $path_parts['filename'].".pdf";

$leftMargin = 10;
$topMargin = 10;

$pageWidth  = 210 - 2*$leftMargin;
$pageHeight = 297 - 2*$topMargin;
$pageRatio = $pageWidth/$pageHeight;

require('lib/fpdf/fpdf.php');

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

list($imgWidth, $imgHeight, $type, $attr) = getimagesize("$file");

$imgRatio  = $imgWidth/$imgHeight;
if ( $imgRatio >= $pageRatio ){
    $imgHeight*= $pageWidth/$imgWidth;
    $imgWidth  = $pageWidth;
}else{
    $imgWidth *= $pageHeight/$imgHeight;
    $imgHeight = $pageHeight;
}
$pdf->Image("$file",$leftMargin,$topMargin,$imgWidth,$imgHeight);

$pdf->Output($output,"D");
?>

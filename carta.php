<?php
$id=(isset($_POST['id']))?$_POST['id']:"";
$name=(isset($_POST['name']))?$_POST['name']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


include "authentication.php";
include "config.php";
include('fpdf/fpdf.php');

switch($accion){
  
  
    case "btn_pdf":
        // extend class
       class KodePDF extends FPDF {
           protected $fontName = 'Arial';
       
           function renderTitle($text) {
               $this->SetTextColor(0, 0, 0);
               $this->SetFont($this->fontName, 'B', 24);
               $this->Cell(0, 10, utf8_decode($text), 0, 1);
               $this->Ln();
           }
       
           function renderSubTitle($text) {
               $this->SetTextColor(0, 0, 0);
               $this->SetFont($this->fontName, 'B', 16);
               $this->Cell(0, 10, utf8_decode($text), 0, 1);
               $this->Ln();
           }
       
           function renderText($text) {
               $this->SetTextColor(51, 51, 51);
               $this->SetFont($this->fontName, '', 12);
               $this->MultiCell(0, 7, utf8_decode($text), 0, 1);
               $this->Ln();
           }
       }
       
       // create document
       $pdf = new KodePDF();
       $pdf->AddPage();
       
       // config document
       $pdf->SetTitle( 'Carta De Recomendacion' .  $name);
       $pdf->SetAuthor('KarenSolis,AbrilTun, CarlosGomez');
       $pdf->SetCreator('FPDF Maker');
       
       // add content
       
       $pdf->renderText('Mérida, Yucatán a ' . date("d") .' de ' . date("M") .'. de ' .date("o"));
       $pdf->renderSubTitle('A quien corresponda: ');
       $pdf->renderText('Por medio de la presente y para los fines que pretenda el interesado, hago de su conocimiento que recomiendo ampliamente al
       C.' .  $name . ', ya que es una persona Honesta y Respetable en las actividades que durante el periodo que prestó servicios en nuestra empresa
       le fueron asignadas por tal motivo no tengo ninguna duda en expedir esta recomendacion.');
       $pdf->renderText('Se extiende la presente solicitud del interesado y para los fines que juzgue convenientes.');
       
       $pdf->renderText('Firma');
       $pdf->renderText('____________________');
       $pdf->renderText('Empresa');
       
       // output file
       $pdf->Output('', 'Carta De Recomendacion' .  $name .  '.pdf');
       break;
}


//print_r($empleadoslist);

?>

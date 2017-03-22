<?php
// inclusion de la librairie TCPDF
    require_once ROOT . DS . 'vendor' . DS. 'tcpdf' . DS . 'tcpdf.php'; 
 
// Création d'un document TCPDF avec les variables par défaut
 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Go Tribe');
$pdf->SetTitle($title);
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
define ('PDF_HEADER_STRINGS', "GoTribe - Management System\nwww.gotribe.com");
// set default header data
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRINGS);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// Set some content to print
$html = $this->fetch('content');

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


  //  $pdf->AddPage();
// voilà l'astuce, on récupère la vue HTML créée par CakePHP pour alimenter notre fichier PDF
  //  $pdf->writeHTML($this->fetch('content'), TRUE, FALSE, TRUE, FALSE, '');
// on ferme la page
    $pdf->lastPage();
    //$filename=1;
// On indique à TCPDF que le fichier doit être enregistré sur le serveur ($filename étant une variable que vous aurez pris soin de définir dans l'action de votre controller)
       if($ftype==1){
             $pdf->IncludeJS("print();");
             $pdf->Output(ROOT . DS  . 'webroot' . DS . 'pdf' . DS . $filename . '.pdf', 'I');
        }else{
            $pdf->Output($filename . '.pdf', 'D');
         }      
           // 
             
            // 
	
  
?>

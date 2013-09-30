<?php 
App::import('Vendor','xtcpdf');

$orientacion = 'L';
$tcpdf = new XTCPDF($orientacion, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$textfont = 'times'; 
$tcpdf->SetAuthor("Sanatorio Santa Cristina"); 
$tcpdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$tcpdf->setPrintHeader(false); 

//set margins
$tcpdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// add a page (required with recent versions of tcpdf) 
$tcpdf->AddPage(); 

// Now you position and print your page content 
// example:
$tcpdf->SetTextColor(0, 0, 0); 
$tcpdf->SetFont($textfont,'',10);

//DISEÑO DE LA TABLA DE INFORME
// -------------------------------------------------------------
$imgjunta = '<img src="'.K_BLANK_IMAGE.'" width="650" height="70" />'.'<img src="img/logoSC.png" height="70" width="100" /><br />';

$tcpdf->writeHTML($imgjunta, true, false, true, false, '');

$title = '<p style="font-size: 40px; font-weight: bold; text-align: center; text-decoration: underline;">'.$report_name.'</p><p></p>';
$subtitle = '<p><b>LOCALIDAD:</b> ALBACETE - <b>ZONA DE SALUD</b>: SANATORIO SANTA CRISTINA</p><p></p>';
$titulo = $title;
$tcpdf->xfootertext = 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');


$cabecera = '<tr style="background-color:#ECF6F9;text-align:center;"><th width="140"><b>Apellidos y Nombre</b></th><th width="85"><b>Fecha Nacimiento</b></th><th width="85"><b>Fecha Vacunación</b></th><th width="85"><b>Enfermedad</b></th><th width="85"><b>Dosis</b></th><th width="90"><b>Vacuna</b></th><th width="90"><b>Laboratorio</b></th><th width="90"><b>Lote</b></th></tr>';
$fila = '';

foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $fechan = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $fechav = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $enfermedad = $vaccination['Vaccine']['enfermedad'];
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $dosis = $vaccination['Vaccination']['dosis'];
    $vacuna = $vaccination['Vaccine']['nombre'];

    $fila .= '<tr nobr="true" style="font-size: 7; text-align: center;"><td style="font-size: 8;text-align:left;" width="140"> '.$apellido1.' '.$apellido2.', '.$nombre.' </td><td width="85" style="font-size="8">'.$fechan.'</td><td width="85">'.$fechav.'</td><td width="85">'.$enfermedad.'</td><td width="85">'.$dosis.'</td><td width="90">'.$vacuna.'</td><td width="90">'.$laboratorio.'</td><td width="90">'.$lote.'</td></tr>';
}

$tabla = '<table cellspacing="0" cellpadding="1" border="1"><thead>'.$cabecera.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

$nombrepdf = 'Listado Paciente NCH-'.$thenhc.'.pdf';
echo $tcpdf->Output($nombrepdf, 'D');

?>

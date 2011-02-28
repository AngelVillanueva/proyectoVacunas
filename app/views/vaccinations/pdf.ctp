<?php 
App::import('Vendor','xtcpdf');  
$tcpdf = new XTCPDF('l'); 
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 

$tcpdf->SetAuthor("Clínica Santa Cristina"); 
$tcpdf->SetAutoPageBreak( false ); 


$tcpdf->setHeaderFont(array($textfont,'',10)); 
$tcpdf->xheadercolor = array(0,100,100); 
$tcpdf->xheadertext = $report_name; 
$tcpdf->xfootertext = 'Copyright © %d Clínica Santa Cristina. All rights reserved.'; 

//set margins
$tcpdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// add a page (required with recent versions of tcpdf) 
$tcpdf->AddPage(); 

// Now you position and print your page content 
// example: 


$tcpdf->SetTextColor(0, 0, 0); 
$tcpdf->SetFont($textfont,'',10); 

$local = 'Albacete '.date('d-m-Y');
$tcpdf->writeHTML($local, true, false, false, false, '');

switch($report)

{

case 1:

// INFORME DE TIPO 1
// ---------------------------------------------------------
$tittle = '<b>RELACIÓN DE VACUNACIONES ANTIHEPATITIS B EN RECIEN NACIDOS</b>';
$tcpdf->writeHTML($tittle, true, false, false, false, '');

$cabecera = '<tr><th>Nombre y Apellidos del niño</th><th>Fecha de Nacimiento</th><th>Fecha de Vacunación</th><th>Lab/Lote</th><th>Madre</th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $fecha = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $madre = $vaccination['Patient']['madre'];
    $fila = $fila.'<tr><td>'.$nombre.' '.$apellido1.' '.$apellido2.'</td><td>'.$nacimiento.'</td><td>'.$fecha.'</td><td>'.$laboratorio.'/'.$lote.'</td><td>'.$madre.'</td></tr>';
}
$tabla ='<table cellspacing="0" cellpadding="1" border="1">'.$cabecera.'<tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
// ----------------------------------------------------------
break;


case 2:

//INFORME DE TIPO 2
// -------------------------------------------------------------
$tittle = '<h1><i>Hoja de declaración nominal de vacunaciones (infantil)</i></h1>';
$tcpdf->writeHTML($tittle, true, false, false, false, '');

$cabecera = '<tr><th>Nombre y Apellidos del niño</th><th>Fecha de Nacimiento</th><th>Fecha de Vacunación</th><th>Lote</th><th>Laboratorio</th><th>Residente</th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $fecha = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $residente = $vaccination['Situation']['residente'];
    $fila = $fila.'<tr><td>'.$nombre.' '.$apellido1.' '.$apellido2.'</td><td>'.$nacimiento.'</td><td>'.$fecha.'</td><td>'.$lote.'</td><td>'.$laboratorio.'</td><td>'.$residente.'</td></tr>';
}
$tabla = '<table cellspacing="0" cellpadding="1" border="1">'.$cabecera.'<tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

break;

case 3:

//INFORME DE TIPO 3
// -------------------------------------------------------------
$tittle = '<h1><i>Vacunación Antigripal</i></h1>';
$tcpdf->writeHTML($tittle, true, false, false, false, '');

$cabecera = '<tr><th>Nombre y Apellidos</th><th>Fecha de Nacimiento</th><th>Personal Sanitario</th><th>Contacto con Aves</th><th>Medico de Familia</th><th>Centro de Salud</th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $personal_sanitario = $vaccination['Situation']['personal_sanitario'];
    $contacto_aves = $vaccination['Situation']['contacto_aves'];
    $medico_familia = $vaccination['Situation']['medico_familia'];
    $centro_salud = $vaccination['Situation']['centro_salud'];
    $fila = $fila.'<tr><td>'.$nombre.' '.$apellido1.' '.$apellido2.'</td><td>'.$nacimiento.'</td><td>'.$personal_sanitario.'</td><td>'.$contacto_aves.'</td><td>'.$medico_familia.'</td><td>'.$centro_salud.'</td></tr>';
}
$tabla = '<table cellspacing="0" cellpadding="1" border="1">'.$cabecera.'<tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

break;

case 4:

//INFORME DE TIPO 4
// -------------------------------------------------------------
$tittle = '<h1><i>Declaración nominal de Vacunaciones adultos</i></h1>';
$tcpdf->writeHTML($tittle, true, false, false, false, '');

$cabecera = '<tr><th>Nombre y Apellidos</th><th>Fecha de Vacunacion</th><th>Vacuna</th><th>Dosis</th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $fecha = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $vacuna = $vaccination['Vaccine']['nombre'];
    $dosis = $vaccination['Vaccination']['dosis'];
    $fila = $fila.'<tr><td>'.$nombre.' '.$apellido1.' '.$apellido2.'</td><td>'.$fecha.'</td><td>'.$vacuna.'</td><td>'.$dosis.'</td></tr>';
}
$tabla = '<table cellspacing="0" cellpadding="1" border="1">'.$cabecera.'<tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

break;

case 5:

//INFORME DE TIPO 5
// -------------------------------------------------------------
$tittle = '<h1><i>Vacunación adultos</i></h1>';
$tcpdf->writeHTML($tittle, true, false, false, false, '');

$cabecera = '<tr><th>Nombre y Apellidos</th><th>Fecha de Nacimiento</th><th>Vacuna</th><th>Lote</th><th>Laboratorio</th><th>Fecha de Vacunacion</th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $vacuna = $vaccination['Vaccine']['nombre'];
    $lote = $vaccination['Vaccine']['lote'];
    
    $fecha = $vaccination['Vaccination']['fecha'];
    $fila = $fila.'<tr><td>'.$nombre.' '.$apellido1.' '.$apellido2.'</td><td>'.$nacimiento.'</td><td>'.$vacuna.'</td><td>'.$lote.'</td><td>'.$laboratorio.'</td><td>'.$fecha.'</td></tr>';
}
$tabla = '<table cellspacing="0" cellpadding="1" border="1">'.$cabecera.'<tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

break;

}

// ... 
// etc. 
// see the TCPDF examples  
// Opcion D para imprimir (guardar PDF) y Opcion I para ver por pantalla
echo $tcpdf->Output('informe.pdf', 'D'); 

?>
<?php 
App::import('Vendor','xtcpdf');

if($report == 1) {$orientacion = 'P';}else {$orientacion = 'L';}
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

switch($report)

{

case 1:

// INFORME DE TIPO 1 (Antihepatitis-B neonatos)
// ---------------------------------------------------------
$imgjunta = '<img src="img/LogoJCCCM.jpg" height="70" width="100" />'.'<img src="'.K_BLANK_IMAGE.'" width="320" height="70" />'.'<span>Consejería de Sanidad</span><br />';

$tcpdf->writeHTML($imgjunta, true, false, true, false, '');

$title = '<p style="font-weight: bold; text-align: center; text-decoration: underline;">RELACIÓN DE VACUNACIONES ANTIHEPATITIS B EN RECIEN NACIDOS</p>';
$subtitle = '<p><b>HOSPITAL</b>: SANATORIO SANTA CRISTINA</p>';
if($first_date && $second_date) {
	$periodo = '<p><b>DE</b> '.$first_date.' <b>A</b> '.$second_date.'</p><p></p>';
} else $periodo = '<p></p><p></p>';
$titulo = $title.$subtitle.$periodo;
$tcpdf->xfootertext = 'Delegación Provincial - Avda. de la Guardia Civil, 5 - 02005 ALBACETE - '.'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');


$cabecera = '<tr style="background-color:#ECF6F9;"><th width="160"><b>NOMBRE Y APELLIDOS DEL NIÑO</b></th><th width="75"><b>FECHA DE NACIMIENTO</b></th><th width="75"><b>FECHA DE VACUNACION</b></th><th width="75"><b>LABORATORIO</b></th><th width="75"><b>LOTE</b></th><th width="75"><b>MADRE<br />HbsAg+</b></th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $fecha = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $vacuna = $vaccination['Vaccine']['nombre'];
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $madre = $vaccination['Patient']['madre'];
    $fila = $fila.'<tr nobr="true"><td width="160">'.$nombre.' '.$apellido1.' '.$apellido2.'</td><td width="75">'.$nacimiento.'</td><td width="75">'.$fecha.'</td><td width="75">'.$laboratorio.'</td><td width="75">'.$lote.'</td><td width="75">'.$madre.'</td></tr>';
}
$tabla ='<table cellspacing="0" cellpadding="5" border="1" style="font-size:8;"><thead>'.$cabecera.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//$tcpdf->SetY(300);
//$tcpdf->Cell(0, 10, 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
// ----------------------------------------------------------
break;


case 2:

//INFORME DE TIPO 2 (Calendario Infantil obligatorio) (nuevo oct2013)
// ------------------------------------------------------------------
$imgjunta = '<img src="img/LogoJCCCM.jpg" height="60" width="86" />';
$blankimg = '<img src="'.K_BLANK_IMAGE.'" width="580" height="60" />';
$imgsescam = '<img src="img/LogoSescam.png" height="60" width="70" />';
$tcpdf->writeHTML($imgjunta.$blankimg.$imgsescam, true, false, false, false, '');

$title = '<p style="font-weight: bold; font-size: 40px; text-align: center; text-decoration: underline;">Hoja de declaración nominal de vacunaciones (Infantil)</p>';
if($first_date && $second_date) {
	$periodo = '<p>DE '.$first_date.' A '.$second_date.'</p>';
} else $periodo = '';
$subtitle = '<p><b>ZONA DE SALUD:</b> SANATORIO SANTA CRISTINA - <b>LOCALIDAD:</b> ALBACETE</p>'.$periodo.'<p></p>';
$titulo = $title.$subtitle;
$tcpdf->xfootertext = 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');

$cabecera = '<tr style="background-color:#ECF6F9; font-size:7; font-weight: bold; text-align: center;"><th style="background-color:#FFFFFF" colspan="4" rowspan="2" width="190"></th><th width="35">0 meses</th><th width="35">1 mes</th><th width="84" colspan="2">2 meses</th><th width="84" colspan="2">4 meses</th><th width="84" colspan="2">6 meses</th><th width="56" colspan="2">15 meses</th><th width="84" colspan="2">18 meses</th><th width="72" colspan="2">6 años</th><th width="36">11 años</th></tr>';
$cabecera = $cabecera.'<tr style="background-color:#ECF6F9; font-size:6; text-align: center;"><th>Hepatitis B</th><th>Hepatitis B</th><th>Polio-DTP-HiB</th><th>Meningitis C</th><th>Polio-DTP-HiB</th><th>Meningitis C</th><th>Polio-DTP-HiB</th><th>Hepatitis B</th><th>T. Vírica</th><th>Varicela</th><th>Polio-DTP-HiB</th><th>Meningitis C</th><th>DTP</th><th>Triple Vírica</th><th>Varicela</th></tr>';
$fila = '';
$actualizacionT = 0;

foreach($report_data as $vaccination) {
	//echo 'Normal: ';print_r($report_data);echo '<br />';//Sinapse
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d/m/y', strtotime($vaccination['Patient']['nacimiento']));
    $fecha = date('d/m/y', strtotime($vaccination['Vaccination']['fecha']));
    $actualizacion = $vaccination['Vaccination']['actualizacion'];
    $dosis = $vaccination['Vaccination']['dosis'];
    $enfermedad = $vaccination['Vaccine']['enfermedad'];
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $residente = $vaccination['Situation']['residente'];if($residente == 0) {$residente = '<img src="img/checked.jpg" height="5" width="4" />';} else {$residente = '<img src="img/not-checked.jpg" height="4" width="4" />';}
    $celda1 = ''; $celda2 = ''; $celda3 = ''; $celda4 = ''; $celda5 = ''; $celda6 = ''; $celda7 = ''; $celda8 = ''; $celda9 = ''; $celda9bis = ''; $celda10 = ''; $celda11 = ''; $celda12 = ''; $celda13 = ''; $celda14 = '';
    $celda1b = ''; $celda2b = ''; $celda3b = ''; $celda4b = ''; $celda5b = ''; $celda6b = ''; $celda7b = ''; $celda8b = ''; $celda9b = ''; $celda9bisb = ''; $celda10b = ''; $celda11b = ''; $celda12b = ''; $celda13b = ''; $celda14b = '';
    $celda1c = ''; $celda2c = ''; $celda3c = ''; $celda4c = ''; $celda5c = ''; $celda6c = ''; $celda7c = ''; $celda8c = ''; $celda9c = ''; $celda9bisc = ''; $celda10c = ''; $celda11c = ''; $celda12c = ''; $celda13c = ''; $celda14c = '';
    $incluirFila = true;
    
    if($actualizacion != 1) {
	    if($dosis == '0 meses') {
	    	$celda1 = $lote; $celda1b = $laboratorio; $celda1c = $fecha;
	    } elseif($dosis == '1 mes') {
	    	$celda2 = $lote; $celda2b = $laboratorio; $celda2c = $fecha;
	    } elseif($dosis == '2 meses') {
	    	if($enfermedad == 'Polio-DTP-HiB') {
	    		$celda3 = $lote; $celda3b = $laboratorio; $celda3c = $fecha;
	    	} elseif($enfermedad == 'Meningitis C') {
	    		$celda4 = $lote; $celda4b = $laboratorio; $celda4c = $fecha;
	    	} else $incluirFila = false;
	    } elseif($dosis == '4 meses') {
	    	if($enfermedad == 'Polio-DTP-HiB') {
	    		$celda5 = $lote; $celda5b = $laboratorio; $celda5c = $fecha;
	    	} elseif($enfermedad == 'Meningitis C') {
	    		$celda6 = $lote; $celda6b = $laboratorio; $celda6c = $fecha;
	    	} else $incluirFila = false;
	    } elseif($dosis == '6 meses') {
	    	if($enfermedad == 'Polio-DTP-HiB') {
	    		$celda7 = $lote; $celda7b = $laboratorio; $celda7c = $fecha;
	    	} elseif($enfermedad == 'Hepatitis B') {
	    		$celda8 = $lote; $celda8b = $laboratorio; $celda8c = $fecha;
	    	} else $incluirFila = false;
	    } elseif($dosis == '15 meses') {
	    	if($enfermedad == 'Triple Vírica') {
	    		$celda9 = $lote; $celda9b = $laboratorio; $celda9c = $fecha;
	    		} elseif($enfermedad == 'Varicela') {
	    			$celda9bis = $lote; $celda9bisb = $laboratorio; $celda9bisc = $fecha;
	    		} else $incluirFila = false;
	    } elseif($dosis == '18 meses') {
	    	if($enfermedad == 'Polio-DTP-HiB') {
	    		$celda10 = $lote; $celda10b = $laboratorio; $celda10c = $fecha;
	    	} elseif($enfermedad == 'Meningitis C') {
	    		$celda11 = $lote; $celda11b = $laboratorio; $celda11c = $fecha;
	    	} else $incluirFila = false;
	    } elseif($dosis == '6 años') {
	    	if($enfermedad == 'DTP') {
	    		$celda12 = $lote; $celda12b = $laboratorio; $celda12c = $fecha;
	    	} elseif($enfermedad == 'Triple Vírica') {
	    		$celda13 = $lote; $celda13b = $laboratorio; $celda13c = $fecha;
	    	} else $incluirFila = false;
	    } elseif($dosis == '11 años') {
	    	if($enfermedad == 'Varicela') {$celda14 = $lote; $celda14b = $laboratorio; $celda14c = $fecha;} else $incluirFila = false;
	    } else $incluirFila = false;
    } else {
    	$actualizacionT ++;
    	$incluirFila = false;
    }
    
    if($incluirFila) {
		$fila = $fila.'<tr nobr="true" style="background-color:#F9F9F9; font-size:6;"><td style="font-size:5;text-align:center;" rowspan="3" width="25"><b>No Residente</b><br />'.$residente.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>APELLIDOS</b></td><td width="65">'.$apellido1.' '.$apellido2.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>LOTE</b></td>';
	    $fila = $fila.'<td width="35">'.$celda1.'</td><td width="35">'.$celda2.'</td><td width="42">'.$celda3.'</td><td width="42">'.$celda4.'</td><td width="42">'.$celda5.'</td><td width="42">'.$celda6.'</td><td width="42">'.$celda7.'</td><td width="42">'.$celda8.'</td><td width="28">'.$celda9.'</td><td width="28">'.$celda9bis.'</td><td width="42">'.$celda10.'</td><td width="42">'.$celda11.'</td><td width="36">'.$celda12.'</td><td width="36">'.$celda13.'</td><td width="36">'.$celda14.'</td></tr>';
	    $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:5;"><b>NOMBRE</b></td><td>'.$nombre.'</td><td style="background-color:#ECF6F9;font-size:5;"><b>LABORATORIO</b></td>';
	    $fila = $fila.'<td>'.$celda1b.'</td><td>'.$celda2b.'</td><td>'.$celda3b.'</td><td>'.$celda4b.'</td><td>'.$celda5b.'</td><td>'.$celda6b.'</td><td>'.$celda7b.'</td><td>'.$celda8b.'</td><td>'.$celda9b.'</td><td>'.$celda9bisb.'</td><td>'.$celda10b.'</td><td>'.$celda11b.'</td><td>'.$celda12b.'</td><td>'.$celda13b.'</td><td>'.$celda14b.'</td></tr>';
	    $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA NACIMIENTO</b></td><td>'.$nacimiento.'</td><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA VACUNACIÓN</b></td>';
	    $fila = $fila.'<td>'.$celda1c.'</td><td>'.$celda2c.'</td><td>'.$celda3c.'</td><td>'.$celda4c.'</td><td>'.$celda5c.'</td><td>'.$celda6c.'</td><td>'.$celda7c.'</td><td>'.$celda8c.'</td><td>'.$celda9c.'</td><td>'.$celda9bisc.'</td><td>'.$celda10c.'</td><td>'.$celda11c.'</td><td>'.$celda12c.'</td><td>'.$celda13c.'</td><td>'.$celda14c.'</td></tr>';
	    }
}

$tabla = '<table style="font-size:8;" cellspacing="0" cellpadding="1" border="1"><thead>'.$cabecera.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
//$html2 = $cabecera.'<br />f: '.$fila; echo $html2.'<br />';//Sinapse
if($fila!='') {
	$tcpdf->writeHTML($html, true, false, false, false, '');
}

if($actualizacionT > 0) {
	$cabecera2 = '<tr style="background-color:#ECF6F9; font-size:7; font-weight: bold; text-align: center;"><th style="background-color:#FFFFFF" colspan="4" rowspan="2" width="190">ACTUALIZACIONES DE CALENDARIO</th><th width="189" colspan="7">1ª Dosis</th><th width="189" colspan="7">2ª Dosis</th><th width="96" colspan="4">3ª Dosis</th><th width="60" colspan="3">4ª Dosis</th><th width="36">5ª Dosis</th></tr>';
	$cabecera2 = $cabecera2.'<tr style="background-color:#ECF6F9; font-size:6; text-align: center;"><th>Polio</th><th>DTP/Td</th><th>HiB</th><th>Hepatitis B</th><th style="font-size:5;">Meningitis C</th><th>T.Vírica</th><th>Varicela G. Riesgo</th><th>Polio</th><th>DTP/Td</th><th>HiB</th><th>Hepatitis B</th><th style="font-size:5;">Meningitis C</th><th>T.Vírica</th><th>Varicela G. Riesgo</th><th>Polio</th><th>DTP/Td</th><th>HiB</th><th>Hepatitis B</th><th>Polio</th><th>DTP</th><th>HiB</th><th>DTP</th></tr>';
	$fila = '';
	
	foreach($report_data as $vaccination) {
		//echo 'Act('.$actualizacionT.'): ';print_r($report_data);echo '<br />';//Sinapse
	    $nombre = $vaccination['Patient']['nombre'];
	    $apellido1 = $vaccination['Patient']['apellido1'];
	    $apellido2 = $vaccination['Patient']['apellido2'];
	    $nacimiento = date('d/m/y', strtotime($vaccination['Patient']['nacimiento']));
	    $fecha = date('d/m/y', strtotime($vaccination['Vaccination']['fecha']));
	    $actualizacion = $vaccination['Vaccination']['actualizacion'];
	    $dosis = $vaccination['Vaccination']['dosis'];
	    $enfermedad = $vaccination['Vaccine']['enfermedad'];
	    $laboratorio = $vaccination['Vaccine']['laboratorio'];
	    $lote = $vaccination['Vaccine']['lote'];
	    $residente = $vaccination['Situation']['residente'];if($residente == 0) {$residente = '<img src="img/checked.jpg" height="5" width="4" />';} else {$residente = '<img src="img/not-checked.jpg" height="4" width="4" />';}
	    $celda1 = ''; $celda2 = ''; $celda3 = ''; $celda4 = ''; $celda5 = ''; $celda6 = ''; $celda7 = ''; $celda8 = ''; $celda9 = ''; $celda10 = ''; $celda11 = ''; $celda12 = ''; $celda13 = ''; $celda14 = ''; $celda15 = ''; $celda16 = ''; $celda17 = ''; $celda18 = ''; $celda19 = ''; $celda20 = ''; $celda21 = ''; $celda22 = '';
	    $celda1b = ''; $celda2b = ''; $celda3b = ''; $celda4b = ''; $celda5b = ''; $celda6b = ''; $celda7b = ''; $celda8b = ''; $celda9b = ''; $celda10b = ''; $celda11b = ''; $celda12b = ''; $celda13b = ''; $celda14b = ''; $celda15b = ''; $celda16b = ''; $celda17b = ''; $celda18b = ''; $celda19b = ''; $celda20b = ''; $celda21b = ''; $celda22b = '';
	    $celda1c = ''; $celda2c = ''; $celda3c = ''; $celda4c = ''; $celda5c = ''; $celda6c = ''; $celda7c = ''; $celda8c = ''; $celda9c = ''; $celda10c = ''; $celda11c = ''; $celda12c = ''; $celda13c = ''; $celda14c = ''; $celda15c = ''; $celda16c = ''; $celda17c = ''; $celda18c = ''; $celda19c = ''; $celda20c = ''; $celda21c = ''; $celda22c = '';
	    $incluirFila = true;
	    
	    if($actualizacion == 1) {
		    if($dosis == '1ª dosis') {
		    	//echo '<p>yes: '.$enfermedad.'</p>';//Sinapse
		    	if($enfermedad == 'Polio') {
		    		$celda1 = $lote; $celda1b = $laboratorio; $celda1c = $fecha;
		    	} elseif($enfermedad == 'DTP/Td') {
		    		$celda2 = $lote; $celda2b = $laboratorio; $celda2c = $fecha;
		    	} elseif($enfermedad == 'HiB') {
		    		$celda3 = $lote; $celda3b = $laboratorio; $celda3c = $fecha;
		    	} elseif($enfermedad == 'Hepatitis B') {
		    		//echo '<p>yes: '.$lote.'</p>';//Sinapse
		    		$celda4 = $lote; $celda4b = $laboratorio; $celda4c = $fecha;
		    	} elseif($enfermedad == 'Meningitis C') {
		    		$celda5 = $lote; $celda5b = $laboratorio; $celda5c = $fecha;
		    	} elseif($enfermedad == 'Triple Vírica') {
		    		$celda6 = $lote; $celda6b = $laboratorio; $celda6c = $fecha;
		    	} elseif($enfermedad == 'Varicela') {
		    		$celda7 = $lote; $celda7b = $laboratorio; $celda7c = $fecha;
		    	} else $incluirFila = false;
		    } elseif($dosis == '2ª dosis') {
		    	if($enfermedad == 'Polio') {
		    		$celda8 = $lote; $celda8b = $laboratorio; $celda8c = $fecha;
		    	} elseif($enfermedad == 'DTP/Td') {
		    		$celda9 = $lote; $celda9b = $laboratorio; $celda9c = $fecha;
		    	} elseif($enfermedad == 'HiB') {
		    		$celda10 = $lote; $celda10b = $laboratorio; $celda10c = $fecha;
		    	} elseif($enfermedad == 'Hepatitis B') {
		    		$celda11 = $lote; $celda11b = $laboratorio; $celda11c = $fecha;
		    	} elseif($enfermedad == 'Meningitis C') {
		    		$celda12 = $lote; $celda12b = $laboratorio; $celda12c = $fecha;
		    	} elseif($enfermedad == 'Triple Vírica') {
		    		$celda13 = $lote; $celda13b = $laboratorio; $celda13c = $fecha;
		    	} elseif($enfermedad == 'Varicela') {
		    		$celda14 = $lote; $celda14b = $laboratorio; $celda14c = $fecha;
		    	} else $incluirFila = false;
		    } elseif($dosis == '3ª dosis') {
		    	if($enfermedad == 'Polio') {
		    		$celda15 = $lote; $celda15b = $laboratorio; $celda15c = $fecha;
		    	} elseif($enfermedad == 'DTP/Td') {
		    		$celda16 = $lote; $celda16b = $laboratorio; $celda16c = $fecha;
		    	} elseif($enfermedad == 'HiB') {
		    		$celda17 = $lote; $celda17b = $laboratorio; $celda17c = $fecha;
		    	} elseif($enfermedad == 'Hepatitis B') {
		    		$celda18 = $lote; $celda18b = $laboratorio; $celda18c = $fecha;
		    	}  else $incluirFila = false;
		    } elseif($dosis == '4ª dosis') {
		    	if($enfermedad == 'Polio') {
		    		$celda19 = $lote; $celda19b = $laboratorio; $celda19c = $fecha;
		    	} elseif($enfermedad == 'DTP') {
		    		$celda20 = $lote; $celda20b = $laboratorio; $celda20c = $fecha;
		    	} elseif($enfermedad == 'HiB') {
		    		$celda21 = $lote; $celda21b = $laboratorio; $celda21c = $fecha;
		    	} else $incluirFila = false;
		    } elseif($dosis == '5ª dosis') {
		    	if($enfermedad == 'DTP') {
		    		$celda22 = $lote; $celda22b = $laboratorio; $celda22c = $fecha;
		    	} else $incluirFila = false;
		    } else $incluirFila = false;
	    } else {
	    	$incluirFila = false;
	    }
	    
	    //echo '<p>yes: '.$incluirFila.'</p>';//Sinapse
	    
	    if($incluirFila) {
		    $fila = $fila.'<tr nobr="true" style="background-color:#F9F9F9; font-size:6;"><td style="font-size:5;text-align:center;" rowspan="3" width="25"><b>No Residente</b><br />'.$residente.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>APELLIDOS</b></td><td width="65">'.$apellido1.' '.$apellido2.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>LOTE</b></td>';
		    $fila = $fila.'<td width="27">'.$celda1.'</td><td width="27">'.$celda2.'</td><td width="27">'.$celda3.'</td><td width="27">'.$celda4.'</td><td width="27">'.$celda5.'</td><td width="27">'.$celda6.'</td><td width="27">'.$celda7.'</td><td width="27">'.$celda8.'</td><td width="27">'.$celda9.'</td><td width="27">'.$celda10.'</td><td width="27">'.$celda11.'</td><td width="27">'.$celda12.'</td><td width="27">'.$celda13.'</td><td width="27">'.$celda14.'</td><td width="24">'.$celda15.'</td><td width="24">'.$celda16.'</td><td width="24">'.$celda17.'</td><td width="24">'.$celda18.'</td><td width="20">'.$celda19.'</td><td width="20">'.$celda20.'</td><td width="20">'.$celda21.'</td><td width="36">'.$celda22.'</td></tr>';
		    $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:5;"><b>NOMBRE</b></td><td>'.$nombre.'</td><td style="background-color:#ECF6F9;font-size:5;"><b>LABORATORIO</b></td>';
		    $fila = $fila.'<td>'.$celda1b.'</td><td>'.$celda2b.'</td><td>'.$celda3b.'</td><td>'.$celda4b.'</td><td>'.$celda5b.'</td><td>'.$celda6b.'</td><td>'.$celda7b.'</td><td>'.$celda8b.'</td><td>'.$celda9b.'</td><td>'.$celda10b.'</td><td>'.$celda11b.'</td><td>'.$celda12b.'</td><td>'.$celda13b.'</td><td>'.$celda14b.'</td><td>'.$celda15b.'</td><td>'.$celda16b.'</td><td>'.$celda17b.'</td><td>'.$celda18b.'</td><td>'.$celda19b.'</td><td>'.$celda20b.'</td><td>'.$celda21b.'</td><td>'.$celda22b.'</td></tr>';
		    $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA NACIMIENTO</b></td><td>'.$nacimiento.'</td><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA VACUNACIÓN</b></td>';
		    $fila = $fila.'<td>'.$celda1c.'</td><td>'.$celda2c.'</td><td>'.$celda3c.'</td><td>'.$celda4c.'</td><td>'.$celda5c.'</td><td>'.$celda6c.'</td><td>'.$celda7c.'</td><td>'.$celda8c.'</td><td>'.$celda9c.'</td><td>'.$celda10c.'</td><td>'.$celda11c.'</td><td>'.$celda12c.'</td><td>'.$celda13c.'</td><td>'.$celda14c.'</td><td>'.$celda15c.'</td><td>'.$celda16c.'</td><td>'.$celda17c.'</td><td>'.$celda18c.'</td><td>'.$celda19c.'</td><td>'.$celda20c.'</td><td>'.$celda21c.'</td><td>'.$celda22c.'</td></tr>';
	    }
	}

	$tabla2 = '<table nobr="true" style="font-size:8;" cellspacing="0" cellpadding="1" border="1"><thead>'.$cabecera2.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla2
EOD;
//$html3 = $cabecera.'<br />f: '.$fila; echo $html3.'<br />';//Sinapse
	if($fila!='') {
		$tcpdf->writeHTML($html, true, false, false, false, '');
	}
}
//--------------------------------------------------------------

break;

case 3:

//INFORME DE TIPO 3 (Antigripal)
// -------------------------------------------------------------
$imgatencion = '<img src="img/LogoAtencion.png" />';
$blankimg = '<img src="'.K_BLANK_IMAGE.'" width="580" height="60" />';
$imgsescam = '<img src="img/LogoSescam.png" height="60" width="70" />';
$tcpdf->writeHTML($imgatencion.$blankimg.$imgsescam, true, false, false, false, '');

$title = '<p style="font-weight: bold; font-size: 40px; text-align: center; text-decoration: underline;">VACUNACIÓN ANTIGRIPAL</p>';
if($first_date && $second_date) {
	$periodo = '<p>DE '.$first_date.' A '.$second_date.'</p>';
} else $periodo = '';
$subtitle = '<p><b>ZONA DE SALUD:</b> SANATORIO SANTA CRISTINA - <b>LOCALIDAD:</b> ALBACETE</p>'.$periodo.'<p></p>';
$titulo = $title.$subtitle;
$tcpdf->xfootertext = 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');



$cabecera = '<tr style="background-color:#ECF6F9;text-align:center;"><th style="text-align:left;" rowspan="2" width="150"><b>NOMBRE Y APELLIDOS</b></th><th  rowspan="2"width="70"><b>Fecha vacunación</b></th><th  rowspan="2"width="70"><b>Mayores de 65 años</b></th><th colspan="2" width="60"><b>Menores de 65 años</b></th><th rowspan="2" width="50"><b>Personal Sanitario</b></th><th rowspan="2" width="60"><b>Personal Parasanitario</b></th><th rowspan="2" width="50"><b>Contacto con Aves</b></th><th style="text-align:left;" rowspan="2" width="140"><b>MÉDICO DE FAMILIA</b></th><th style="text-align:left;" rowspan="2" width="100"><b>CENTRO DE SALUD</b></th></tr>';
$cabecera .= '<tr style="background-color:#ECF6F9;text-align:center;"><th>Con riesgo</th><th>Sin riesgo</th></tr>';
$fila = '';
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('Y-m-d', strtotime($vaccination['Patient']['nacimiento']));
    $fecha = date('Y-m-d', strtotime($vaccination['Vaccination']['fecha'])); $edad = edad($nacimiento,$fecha);
    if($edad>=65) {
    	$mayor = 'X'; $menor = '';
    } else { $mayor = ''; $menor = 'X'; }
    $riesgo = $vaccination['Situation']['riesgo']; if($riesgo == '1') $riesgo = "X"; else $riesgo = '';
    $sanitario = $vaccination['Situation']['personal_sanitario']; if($sanitario == '1') $sanitario = "X"; else $sanitario = '';
    $paras = $vaccination['Situation']['personal_parasanitario']; if($paras == '1') $paras = "X"; else $paras = '';
    $aves = $vaccination['Situation']['contacto_aves']; if($aves == '1') $aves = "X"; else $aves = '';
    $medico = $vaccination['Situation']['medico_familia'];
    $centro = $vaccination['Situation']['centro_salud'];
    if($riesgo || $sanitario || $paras || $aves) { $sriesgo = 'X'; } else { $sriesgo = '';}
    if($menor && $sriesgo) {$conriesgo = 'X'; $sinriesgo = '';} elseif($menor && !$sriesgo) {$conriesgo = ''; $sinriesgo = 'X';} else {$conriesgo = ''; $sinriesgo = '';}
    $fila = $fila.'<tr nobr="true" style="text-align:center"><td width="150" style="text-align:left;"> '.$nombre.' '.$apellido1.' '.$apellido2.'</td><td width="70">'.$fecha.'</td><td width="70">'.$mayor.'</td><td width="30">'.$conriesgo.'</td><td width="30">'.$sinriesgo.'</td><td width="50">'.$sanitario.'</td><td width="60">'.$paras.'</td><td width="50">'.$aves.'</td><td width="140" style="text-align:left;"> '.$medico.'</td><td width="100" style="text-align:left;"> '.$centro.'</td></tr>';
}
$tabla ='<table cellspacing="0" cellpadding="5" border="1" style="font-size:8;"><thead>'.$cabecera.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

break;

case 4:

//INFORME DE TIPO 4 (Adultos no antigripal)
// -------------------------------------------------------------
$imgjunta = '<img src="img/LogoJCCCM.jpg" height="70" width="100" />'.'<img src="'.K_BLANK_IMAGE.'" width="550" height="70" />'.'<img src="img/logoSC.png" height="70" width="100" /><br />';

$tcpdf->writeHTML($imgjunta, true, false, true, false, '');

$title = '<p style="font-size: 40px; font-weight: bold; text-align: center;">DECLARACIÓN NOMINAL DE VACUNACIONES<br />(ADULTOS)</p>';
$subtitle = '<p><b>LOCALIDAD:</b> ALBACETE - <b>ZONA DE SALUD</b>: SANATORIO SANTA CRISTINA</p>';
if($first_date && $second_date) {
	$periodo = '<p><b>DE</b> '.$first_date.' <b>A</b> '.$second_date.'</p><p></p>';
} else $periodo = '<p></p><p></p>';
$titulo = $title.$subtitle.$periodo;
$tcpdf->xfootertext = 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');

$cabecera = '<tr style="background-color:#ECF6F9;text-align:center;"><th rowspan="2" width="140"><b>Apellidos y Nombre</b></th><th  rowspan="2" width="60"><b>Fecha Vacunación</b></th><th colspan="3" width="111"><b>HVB grupos de riesgo</b></th><th colspan="4" width="140"><b>Td</b></th><th colspan="4" width="140"><b>Tétanos</b></th><th rowspan="2" width="50"><b>RUB</b></th><th rowspan="2" width="50"><b>Gamma-</b><br/><b>globulina</b></th><th rowspan="2" width="60"><b>Otras</b></th></tr>';
$cabecera .= '<tr style="background-color:#ECF6F9;text-align:center;"><th>1ª</th><th>2ª</th><th>3ª</th><th>1ª</th><th>2ª</th><th>3ª</th><th>R</th><th>1ª</th><th>2ª</th><th>3ª</th><th>R</th></tr>';
$fila = '';
$celda1T = 0; $celda2T = 0; $celda3T = 0; $celda4T = 0; $celda5T = 0; $celda6T = 0; $celda7T = 0; $celda8T = 0; $celda9T = 0; $celda10T = 0; $celda11T = 0; $celda12T = 0; $celda13T = 0; $celda14T = 0;
foreach($report_data as $vaccination) {
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $fecha = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $enfermedad = $vaccination['Vaccine']['enfermedad'];
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $dosis = $vaccination['Vaccination']['dosis'];
    $vacuna = $vaccination['Vaccine']['nombre'];
    $celda1 = ''; $celda2 = ''; $celda3 = ''; $celda4 = ''; $celda5 = ''; $celda6 = ''; $celda7 = ''; $celda8 = ''; $celda9 = ''; $celda10 = ''; $celda11 = ''; $celda12 = ''; $celda13 = ''; $celda14 = '';
    $contenidocelda = $laboratorio.' /<br />'.$lote;
    if($enfermedad == 'HVB') {
    	if($dosis == '1ª dosis') {$celda1 = $contenidocelda; $celda1T ++;}
    	if($dosis == '2ª dosis') {$celda2 = $contenidocelda; $celda2T ++;}
    	if($dosis == '3ª dosis') {$celda3 = $contenidocelda; $celda3T ++;}
    } elseif($enfermedad == 'Td') {
    	if($dosis == '1ª dosis') {$celda4 = $contenidocelda; $celda4T ++;}
    	if($dosis == '2ª dosis') {$celda5 = $contenidocelda; $celda5T ++;}
    	if($dosis == '3ª dosis') {$celda6 = $contenidocelda; $celda6T ++;}
    	if($dosis == 'Recordatorio') {$celda7 = $contenidocelda; $celda7T ++;}
    } elseif($enfermedad == 'Tétanos') {
    	if($dosis == '1ª dosis') {$celda8 = $contenidocelda; $celda8T ++;}
    	if($dosis == '2ª dosis') {$celda9 = $contenidocelda; $celda9T ++;}
    	if($dosis == '3ª dosis') {$celda10 = $contenidocelda; $celda10T ++;}
    	if($dosis == 'Recordatorio') {$celda11 = $contenidocelda; $celda11T ++;}
    } elseif($enfermedad == 'Rubeola') {
    	$celda12 = $contenidocelda; $celda12T ++;
    } elseif($enfermedad == 'Gammaglobulina') {
    	$celda13 = $contenidocelda; $celda13T ++;
    } else {
    	$celda14 = $enfermedad.'<br />'.$vacuna.'<br />'.$contenidocelda; $celda14T ++;
    }
    
    $fila = $fila.'<tr nobr="true" style="font-size: 7; text-align: center;"><td style="font-size: 8;text-align:left;" width="140"> '.$apellido1.' '.$apellido2.', '.$nombre.' </td><td width="60" style="font-size="8">'.$fecha.'</td><td width="37">'.$celda1.'</td><td width="37">'.$celda2.'</td><td width="37">'.$celda3.'</td><td width="35">'.$celda4.'</td><td width="35">'.$celda5.'</td><td width="35">'.$celda6.'</td><td width="35">'.$celda7.'</td><td width="35">'.$celda8.'</td><td width="35">'.$celda9.'</td><td width="35">'.$celda10.'</td><td width="35">'.$celda11.'</td><td width="50">'.$celda12.'</td><td width="50">'.$celda13.'</td><td width="60">'.$celda14.'</td></tr>';
}
$totalN = '<tr nobr="true" style="text-align: center;"><td colspan="2"><b>TOTAL NUMÉRICO</b></td><td><b>'.$celda1T.'</b></td><td><b>'.$celda2T.'</b></td><td><b>'.$celda3T.'</b></td><td><b>'.$celda4T.'</b></td><td><b>'.$celda5T.'</b></td><td><b>'.$celda6T.'</b></td><td><b>'.$celda7T.'</b></td><td><b>'.$celda8T.'</b></td><td><b>'.$celda9T.'</b></td><td><b>'.$celda10T.'</b></td><td><b>'.$celda11T.'</b></td><td><b>'.$celda12T.'</b></td><td><b>'.$celda13T.'</b></td><td><b>'.$celda14T.'</b></td></tr>';
$tabla = '<table cellspacing="0" cellpadding="1" border="1"><thead>'.$cabecera.'</thead><tbody>'.$fila.$totalN.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
$tcpdf->writeHTML($html, true, false, false, false, '');
//--------------------------------------------------------------

break;

case 5:

//INFORME DE TIPO 5 (Infantiles fuera de calendario)
// -------------------------------------------------------------
$imgjunta = '<img src="img/logoSC.png" height="70" width="100" /><br />';

$tcpdf->writeHTML($imgjunta, true, false, true, false, '');

$title = '<p style="font-size: 40px; font-weight: bold; text-align: center;">VACUNAS INFANTILES NO INCLUIDAS EN CALENDARIO VACUNAL</p>';
$subtitle = '';
if($first_date && $second_date) {
	$periodo = '<p><b>DE</b> '.$first_date.' <b>A</b> '.$second_date.'</p><p></p>';
} else $periodo = '<p></p><p></p>';
$titulo = $title.$subtitle.$periodo;
$tcpdf->xfootertext = 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');

foreach($report_data as $vaccination) {
	$cabecera = '<tr><th>Col 1</th><th>Col 2</th<th>Col 3</th></tr>';
	$fila = '';
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d-m-Y', strtotime($vaccination['Patient']['nacimiento']));
    $vacuna = $vaccination['Vaccine']['nombre'];
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $fecha = date('d-m-Y', strtotime($vaccination['Vaccination']['fecha']));
    $dosis = $vaccination['Vaccination']['dosis']; 
    
    $fila = $fila.'<tr><td rowspan="2"><b> Apellidos:</b><br/>'.$apellido1.' '.$apellido2.'</td><td><b> Nombre Vacuna: </b></td><td>'.$vacuna.'</td></tr><tr><td><b> Lote: </b></td><td>'.$lote.'</td></tr>';
    $fila = $fila.'<tr><td><b> Nombre: </b>'.$nombre.'</td><td><b> Laboratorio: </b></td><td>'.$laboratorio.'</td></tr>';
    $fila = $fila.'<tr><td><b> Fecha Nacimiento: </b>'.$nacimiento.'</td><td><b> Fecha Vacunación y Dosis: </b></td><td>'.$fecha.' / '.$dosis.'</td></tr>';


	$tabla = '<table nobr="true" cellspacing="0" cellpadding="1" border="1"><tbody>'.$fila.'</tbody></table>';
	$html = <<<EOD
$tabla
EOD;
	$tcpdf->writeHTML($html, true, false, false, false, '');
}
//--------------------------------------------------------------

break;

case 6:

//INFORME DE TIPO 6 (Calendario Infantil obligatorio)[antiguo]
// -------------------------------------------------------------
$imgjunta = '<img src="img/LogoJCCCM.jpg" height="60" width="86" />';
$blankimg = '<img src="'.K_BLANK_IMAGE.'" width="580" height="60" />';
$imgsescam = '<img src="img/LogoSescam.png" height="60" width="70" />';
$tcpdf->writeHTML($imgjunta.$blankimg.$imgsescam, true, false, false, false, '');

$title = '<p style="font-weight: bold; font-size: 40px; text-align: center; text-decoration: underline;">Hoja de declaración nominal de vacunaciones (Infantil)</p>';
if($first_date && $second_date) {
  $periodo = '<p>DE '.$first_date.' A '.$second_date.'</p>';
} else $periodo = '';
$subtitle = '<p><b>ZONA DE SALUD:</b> SANATORIO SANTA CRISTINA - <b>LOCALIDAD:</b> ALBACETE</p>'.$periodo.'<p></p>';
$titulo = $title.$subtitle;
$tcpdf->xfootertext = 'Página '.$tcpdf->getAliasNumPage().'/'.$tcpdf->getAliasNbPages();
$tcpdf->writeHTML($titulo, true, false, false, false, '');

$cabecera = '<tr style="background-color:#ECF6F9; font-size:7; font-weight: bold; text-align: center;"><th style="background-color:#FFFFFF" colspan="4" rowspan="2" width="190"></th><th width="35">0 meses</th><th width="35">1 mes</th><th width="84" colspan="2">2 meses</th><th width="84" colspan="2">4 meses</th><th width="84" colspan="2">6 meses</th><th width="56" colspan="2">15 meses</th><th width="84" colspan="2">18 meses</th><th width="72" colspan="2">6 años</th><th width="36">11 años</th></tr>';
$cabecera = $cabecera.'<tr style="background-color:#ECF6F9; font-size:6; text-align: center;"><th>Hepatitis B</th><th>Hepatitis B</th><th>Polio-DTP-HiB</th><th>Meningitis C</th><th>Polio-DTP-HiB</th><th>Meningitis C</th><th>Polio-DTP-HiB</th><th>Hepatitis B</th><th>T. Vírica</th><th>Varicela</th><th>Polio-DTP-HiB</th><th>Meningitis C</th><th>DTP</th><th>Triple Vírica</th><th>Varicela</th></tr>';
$fila = '';
$actualizacionT = 0;

foreach($report_data as $vaccination) {
  //echo 'Normal: ';print_r($report_data);echo '<br />';//Sinapse
    $nombre = $vaccination['Patient']['nombre'];
    $apellido1 = $vaccination['Patient']['apellido1'];
    $apellido2 = $vaccination['Patient']['apellido2'];
    $nacimiento = date('d/m/y', strtotime($vaccination['Patient']['nacimiento']));
    $fecha = date('d/m/y', strtotime($vaccination['Vaccination']['fecha']));
    $actualizacion = $vaccination['Vaccination']['actualizacion'];
    $dosis = $vaccination['Vaccination']['dosis'];
    $enfermedad = $vaccination['Vaccine']['enfermedad'];
    $laboratorio = $vaccination['Vaccine']['laboratorio'];
    $lote = $vaccination['Vaccine']['lote'];
    $residente = $vaccination['Situation']['residente'];if($residente == 0) {$residente = '<img src="img/checked.jpg" height="5" width="4" />';} else {$residente = '<img src="img/not-checked.jpg" height="4" width="4" />';}
    $celda1 = ''; $celda2 = ''; $celda3 = ''; $celda4 = ''; $celda5 = ''; $celda6 = ''; $celda7 = ''; $celda8 = ''; $celda9 = ''; $celda9bis = ''; $celda10 = ''; $celda11 = ''; $celda12 = ''; $celda13 = ''; $celda14 = '';
    $celda1b = ''; $celda2b = ''; $celda3b = ''; $celda4b = ''; $celda5b = ''; $celda6b = ''; $celda7b = ''; $celda8b = ''; $celda9b = ''; $celda9bisb = ''; $celda10b = ''; $celda11b = ''; $celda12b = ''; $celda13b = ''; $celda14b = '';
    $celda1c = ''; $celda2c = ''; $celda3c = ''; $celda4c = ''; $celda5c = ''; $celda6c = ''; $celda7c = ''; $celda8c = ''; $celda9c = ''; $celda9bisc = ''; $celda10c = ''; $celda11c = ''; $celda12c = ''; $celda13c = ''; $celda14c = '';
    $incluirFila = true;
    
    if($actualizacion != 1) {
      if($dosis == '0 meses') {
        $celda1 = $lote; $celda1b = $laboratorio; $celda1c = $fecha;
      } elseif($dosis == '1 mes') {
        $celda2 = $lote; $celda2b = $laboratorio; $celda2c = $fecha;
      } elseif($dosis == '2 meses') {
        if($enfermedad == 'Polio-DTP-HiB') {
          $celda3 = $lote; $celda3b = $laboratorio; $celda3c = $fecha;
        } elseif($enfermedad == 'Meningitis C') {
          $celda4 = $lote; $celda4b = $laboratorio; $celda4c = $fecha;
        } else $incluirFila = false;
      } elseif($dosis == '4 meses') {
        if($enfermedad == 'Polio-DTP-HiB') {
          $celda5 = $lote; $celda5b = $laboratorio; $celda5c = $fecha;
        } elseif($enfermedad == 'Meningitis C') {
          $celda6 = $lote; $celda6b = $laboratorio; $celda6c = $fecha;
        } else $incluirFila = false;
      } elseif($dosis == '6 meses') {
        if($enfermedad == 'Polio-DTP-HiB') {
          $celda7 = $lote; $celda7b = $laboratorio; $celda7c = $fecha;
        } elseif($enfermedad == 'Hepatitis B') {
          $celda8 = $lote; $celda8b = $laboratorio; $celda8c = $fecha;
        } else $incluirFila = false;
      } elseif($dosis == '15 meses') {
        if($enfermedad == 'Triple Vírica') {
          $celda9 = $lote; $celda9b = $laboratorio; $celda9c = $fecha;
          } elseif($enfermedad == 'Varicela') {
            $celda9bis = $lote; $celda9bisb = $laboratorio; $celda9bisc = $fecha;
          } else $incluirFila = false;
      } elseif($dosis == '18 meses') {
        if($enfermedad == 'Polio-DTP-HiB') {
          $celda10 = $lote; $celda10b = $laboratorio; $celda10c = $fecha;
        } elseif($enfermedad == 'Meningitis C') {
          $celda11 = $lote; $celda11b = $laboratorio; $celda11c = $fecha;
        } else $incluirFila = false;
      } elseif($dosis == '6 años') {
        if($enfermedad == 'DTP') {
          $celda12 = $lote; $celda12b = $laboratorio; $celda12c = $fecha;
        } elseif($enfermedad == 'Triple Vírica') {
          $celda13 = $lote; $celda13b = $laboratorio; $celda13c = $fecha;
        } else $incluirFila = false;
      } elseif($dosis == '11 años') {
        if($enfermedad == 'Varicela') {$celda14 = $lote; $celda14b = $laboratorio; $celda14c = $fecha;} else $incluirFila = false;
      } else $incluirFila = false;
    } else {
      $actualizacionT ++;
      $incluirFila = false;
    }
    
    if($incluirFila) {
    $fila = $fila.'<tr nobr="true" style="background-color:#F9F9F9; font-size:6;"><td style="font-size:5;text-align:center;" rowspan="3" width="25"><b>No Residente</b><br />'.$residente.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>APELLIDOS</b></td><td width="65">'.$apellido1.' '.$apellido2.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>LOTE</b></td>';
      $fila = $fila.'<td width="35">'.$celda1.'</td><td width="35">'.$celda2.'</td><td width="42">'.$celda3.'</td><td width="42">'.$celda4.'</td><td width="42">'.$celda5.'</td><td width="42">'.$celda6.'</td><td width="42">'.$celda7.'</td><td width="42">'.$celda8.'</td><td width="28">'.$celda9.'</td><td width="28">'.$celda9bis.'</td><td width="42">'.$celda10.'</td><td width="42">'.$celda11.'</td><td width="36">'.$celda12.'</td><td width="36">'.$celda13.'</td><td width="36">'.$celda14.'</td></tr>';
      $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:5;"><b>NOMBRE</b></td><td>'.$nombre.'</td><td style="background-color:#ECF6F9;font-size:5;"><b>LABORATORIO</b></td>';
      $fila = $fila.'<td>'.$celda1b.'</td><td>'.$celda2b.'</td><td>'.$celda3b.'</td><td>'.$celda4b.'</td><td>'.$celda5b.'</td><td>'.$celda6b.'</td><td>'.$celda7b.'</td><td>'.$celda8b.'</td><td>'.$celda9b.'</td><td>'.$celda9bisb.'</td><td>'.$celda10b.'</td><td>'.$celda11b.'</td><td>'.$celda12b.'</td><td>'.$celda13b.'</td><td>'.$celda14b.'</td></tr>';
      $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA NACIMIENTO</b></td><td>'.$nacimiento.'</td><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA VACUNACIÓN</b></td>';
      $fila = $fila.'<td>'.$celda1c.'</td><td>'.$celda2c.'</td><td>'.$celda3c.'</td><td>'.$celda4c.'</td><td>'.$celda5c.'</td><td>'.$celda6c.'</td><td>'.$celda7c.'</td><td>'.$celda8c.'</td><td>'.$celda9c.'</td><td>'.$celda9bisc.'</td><td>'.$celda10c.'</td><td>'.$celda11c.'</td><td>'.$celda12c.'</td><td>'.$celda13c.'</td><td>'.$celda14c.'</td></tr>';
      }
}

$tabla = '<table style="font-size:8;" cellspacing="0" cellpadding="1" border="1"><thead>'.$cabecera.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla
EOD;
//$html2 = $cabecera.'<br />f: '.$fila; echo $html2.'<br />';//Sinapse
if($fila!='') {
  $tcpdf->writeHTML($html, true, false, false, false, '');
}

if($actualizacionT > 0) {
  $cabecera2 = '<tr style="background-color:#ECF6F9; font-size:7; font-weight: bold; text-align: center;"><th style="background-color:#FFFFFF" colspan="4" rowspan="2" width="190">ACTUALIZACIONES DE CALENDARIO</th><th width="189" colspan="7">1ª Dosis</th><th width="189" colspan="7">2ª Dosis</th><th width="96" colspan="4">3ª Dosis</th><th width="60" colspan="3">4ª Dosis</th><th width="36">5ª Dosis</th></tr>';
  $cabecera2 = $cabecera2.'<tr style="background-color:#ECF6F9; font-size:6; text-align: center;"><th>Polio</th><th>DTP/Td</th><th>HiB</th><th>Hepatitis B</th><th style="font-size:5;">Meningitis C</th><th>T.Vírica</th><th>Varicela G. Riesgo</th><th>Polio</th><th>DTP/Td</th><th>HiB</th><th>Hepatitis B</th><th style="font-size:5;">Meningitis C</th><th>T.Vírica</th><th>Varicela G. Riesgo</th><th>Polio</th><th>DTP/Td</th><th>HiB</th><th>Hepatitis B</th><th>Polio</th><th>DTP</th><th>HiB</th><th>DTP</th></tr>';
  $fila = '';
  
  foreach($report_data as $vaccination) {
    //echo 'Act('.$actualizacionT.'): ';print_r($report_data);echo '<br />';//Sinapse
      $nombre = $vaccination['Patient']['nombre'];
      $apellido1 = $vaccination['Patient']['apellido1'];
      $apellido2 = $vaccination['Patient']['apellido2'];
      $nacimiento = date('d/m/y', strtotime($vaccination['Patient']['nacimiento']));
      $fecha = date('d/m/y', strtotime($vaccination['Vaccination']['fecha']));
      $actualizacion = $vaccination['Vaccination']['actualizacion'];
      $dosis = $vaccination['Vaccination']['dosis'];
      $enfermedad = $vaccination['Vaccine']['enfermedad'];
      $laboratorio = $vaccination['Vaccine']['laboratorio'];
      $lote = $vaccination['Vaccine']['lote'];
      $residente = $vaccination['Situation']['residente'];if($residente == 0) {$residente = '<img src="img/checked.jpg" height="5" width="4" />';} else {$residente = '<img src="img/not-checked.jpg" height="4" width="4" />';}
      $celda1 = ''; $celda2 = ''; $celda3 = ''; $celda4 = ''; $celda5 = ''; $celda6 = ''; $celda7 = ''; $celda8 = ''; $celda9 = ''; $celda10 = ''; $celda11 = ''; $celda12 = ''; $celda13 = ''; $celda14 = ''; $celda15 = ''; $celda16 = ''; $celda17 = ''; $celda18 = ''; $celda19 = ''; $celda20 = ''; $celda21 = ''; $celda22 = '';
      $celda1b = ''; $celda2b = ''; $celda3b = ''; $celda4b = ''; $celda5b = ''; $celda6b = ''; $celda7b = ''; $celda8b = ''; $celda9b = ''; $celda10b = ''; $celda11b = ''; $celda12b = ''; $celda13b = ''; $celda14b = ''; $celda15b = ''; $celda16b = ''; $celda17b = ''; $celda18b = ''; $celda19b = ''; $celda20b = ''; $celda21b = ''; $celda22b = '';
      $celda1c = ''; $celda2c = ''; $celda3c = ''; $celda4c = ''; $celda5c = ''; $celda6c = ''; $celda7c = ''; $celda8c = ''; $celda9c = ''; $celda10c = ''; $celda11c = ''; $celda12c = ''; $celda13c = ''; $celda14c = ''; $celda15c = ''; $celda16c = ''; $celda17c = ''; $celda18c = ''; $celda19c = ''; $celda20c = ''; $celda21c = ''; $celda22c = '';
      $incluirFila = true;
      
      if($actualizacion == 1) {
        if($dosis == '1ª dosis') {
          //echo '<p>yes: '.$enfermedad.'</p>';//Sinapse
          if($enfermedad == 'Polio') {
            $celda1 = $lote; $celda1b = $laboratorio; $celda1c = $fecha;
          } elseif($enfermedad == 'DTP/Td') {
            $celda2 = $lote; $celda2b = $laboratorio; $celda2c = $fecha;
          } elseif($enfermedad == 'HiB') {
            $celda3 = $lote; $celda3b = $laboratorio; $celda3c = $fecha;
          } elseif($enfermedad == 'Hepatitis B') {
            //echo '<p>yes: '.$lote.'</p>';//Sinapse
            $celda4 = $lote; $celda4b = $laboratorio; $celda4c = $fecha;
          } elseif($enfermedad == 'Meningitis C') {
            $celda5 = $lote; $celda5b = $laboratorio; $celda5c = $fecha;
          } elseif($enfermedad == 'Triple Vírica') {
            $celda6 = $lote; $celda6b = $laboratorio; $celda6c = $fecha;
          } elseif($enfermedad == 'Varicela') {
            $celda7 = $lote; $celda7b = $laboratorio; $celda7c = $fecha;
          } else $incluirFila = false;
        } elseif($dosis == '2ª dosis') {
          if($enfermedad == 'Polio') {
            $celda8 = $lote; $celda8b = $laboratorio; $celda8c = $fecha;
          } elseif($enfermedad == 'DTP/Td') {
            $celda9 = $lote; $celda9b = $laboratorio; $celda9c = $fecha;
          } elseif($enfermedad == 'HiB') {
            $celda10 = $lote; $celda10b = $laboratorio; $celda10c = $fecha;
          } elseif($enfermedad == 'Hepatitis B') {
            $celda11 = $lote; $celda11b = $laboratorio; $celda11c = $fecha;
          } elseif($enfermedad == 'Meningitis C') {
            $celda12 = $lote; $celda12b = $laboratorio; $celda12c = $fecha;
          } elseif($enfermedad == 'Triple Vírica') {
            $celda13 = $lote; $celda13b = $laboratorio; $celda13c = $fecha;
          } elseif($enfermedad == 'Varicela') {
            $celda14 = $lote; $celda14b = $laboratorio; $celda14c = $fecha;
          } else $incluirFila = false;
        } elseif($dosis == '3ª dosis') {
          if($enfermedad == 'Polio') {
            $celda15 = $lote; $celda15b = $laboratorio; $celda15c = $fecha;
          } elseif($enfermedad == 'DTP/Td') {
            $celda16 = $lote; $celda16b = $laboratorio; $celda16c = $fecha;
          } elseif($enfermedad == 'HiB') {
            $celda17 = $lote; $celda17b = $laboratorio; $celda17c = $fecha;
          } elseif($enfermedad == 'Hepatitis B') {
            $celda18 = $lote; $celda18b = $laboratorio; $celda18c = $fecha;
          }  else $incluirFila = false;
        } elseif($dosis == '4ª dosis') {
          if($enfermedad == 'Polio') {
            $celda19 = $lote; $celda19b = $laboratorio; $celda19c = $fecha;
          } elseif($enfermedad == 'DTP') {
            $celda20 = $lote; $celda20b = $laboratorio; $celda20c = $fecha;
          } elseif($enfermedad == 'HiB') {
            $celda21 = $lote; $celda21b = $laboratorio; $celda21c = $fecha;
          } else $incluirFila = false;
        } elseif($dosis == '5ª dosis') {
          if($enfermedad == 'DTP') {
            $celda22 = $lote; $celda22b = $laboratorio; $celda22c = $fecha;
          } else $incluirFila = false;
        } else $incluirFila = false;
      } else {
        $incluirFila = false;
      }
      
      //echo '<p>yes: '.$incluirFila.'</p>';//Sinapse
      
      if($incluirFila) {
        $fila = $fila.'<tr nobr="true" style="background-color:#F9F9F9; font-size:6;"><td style="font-size:5;text-align:center;" rowspan="3" width="25"><b>No Residente</b><br />'.$residente.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>APELLIDOS</b></td><td width="65">'.$apellido1.' '.$apellido2.'</td><td style="background-color:#ECF6F9;font-size:5;" width="50"><b>LOTE</b></td>';
        $fila = $fila.'<td width="27">'.$celda1.'</td><td width="27">'.$celda2.'</td><td width="27">'.$celda3.'</td><td width="27">'.$celda4.'</td><td width="27">'.$celda5.'</td><td width="27">'.$celda6.'</td><td width="27">'.$celda7.'</td><td width="27">'.$celda8.'</td><td width="27">'.$celda9.'</td><td width="27">'.$celda10.'</td><td width="27">'.$celda11.'</td><td width="27">'.$celda12.'</td><td width="27">'.$celda13.'</td><td width="27">'.$celda14.'</td><td width="24">'.$celda15.'</td><td width="24">'.$celda16.'</td><td width="24">'.$celda17.'</td><td width="24">'.$celda18.'</td><td width="20">'.$celda19.'</td><td width="20">'.$celda20.'</td><td width="20">'.$celda21.'</td><td width="36">'.$celda22.'</td></tr>';
        $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:5;"><b>NOMBRE</b></td><td>'.$nombre.'</td><td style="background-color:#ECF6F9;font-size:5;"><b>LABORATORIO</b></td>';
        $fila = $fila.'<td>'.$celda1b.'</td><td>'.$celda2b.'</td><td>'.$celda3b.'</td><td>'.$celda4b.'</td><td>'.$celda5b.'</td><td>'.$celda6b.'</td><td>'.$celda7b.'</td><td>'.$celda8b.'</td><td>'.$celda9b.'</td><td>'.$celda10b.'</td><td>'.$celda11b.'</td><td>'.$celda12b.'</td><td>'.$celda13b.'</td><td>'.$celda14b.'</td><td>'.$celda15b.'</td><td>'.$celda16b.'</td><td>'.$celda17b.'</td><td>'.$celda18b.'</td><td>'.$celda19b.'</td><td>'.$celda20b.'</td><td>'.$celda21b.'</td><td>'.$celda22b.'</td></tr>';
        $fila = $fila.'<tr style="font-size:6;"><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA NACIMIENTO</b></td><td>'.$nacimiento.'</td><td style="background-color:#ECF6F9;font-size:4;"><b>FECHA VACUNACIÓN</b></td>';
        $fila = $fila.'<td>'.$celda1c.'</td><td>'.$celda2c.'</td><td>'.$celda3c.'</td><td>'.$celda4c.'</td><td>'.$celda5c.'</td><td>'.$celda6c.'</td><td>'.$celda7c.'</td><td>'.$celda8c.'</td><td>'.$celda9c.'</td><td>'.$celda10c.'</td><td>'.$celda11c.'</td><td>'.$celda12c.'</td><td>'.$celda13c.'</td><td>'.$celda14c.'</td><td>'.$celda15c.'</td><td>'.$celda16c.'</td><td>'.$celda17c.'</td><td>'.$celda18c.'</td><td>'.$celda19c.'</td><td>'.$celda20c.'</td><td>'.$celda21c.'</td><td>'.$celda22c.'</td></tr>';
      }
  }

  $tabla2 = '<table nobr="true" style="font-size:8;" cellspacing="0" cellpadding="1" border="1"><thead>'.$cabecera2.'</thead><tbody>'.$fila.'</tbody></table>';
$html = <<<EOD
$tabla2
EOD;
//$html3 = $cabecera.'<br />f: '.$fila; echo $html3.'<br />';//Sinapse
  if($fila!='') {
    $tcpdf->writeHTML($html, true, false, false, false, '');
  }
}
//--------------------------------------------------------------

break;

}

// ... 
// etc. 
// see the TCPDF examples  
// Opcion D para imprimir (guardar PDF) y Opcion I para ver por pantalla
echo $tcpdf->Output('informe.pdf', 'D'); 

?>

<?php

// Calcula la edad (formato: año/mes/dia)
function edad($nacimiento, $vacunacion){
list($anioN,$mesN,$diaN) = explode("-",$nacimiento);
list($anioV,$mesV,$diaV) = explode("-",$vacunacion);
$anio_dif = $anioV - $anioN;
$mes_dif = $mesV - $mesN;
$dia_dif = $diaV - $diaN;
if ($dia_dif < 0 || $mes_dif < 0)
$anio_dif--;
return $anio_dif;
}

?>
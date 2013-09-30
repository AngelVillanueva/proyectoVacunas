<cake:nocache>
<?php $this->Html->script('/js/tipTip-min', array('inline'=>false)); ?>

<h2>Vacunas de <?php echo $patient." ".$nhcstr; ?></h2>

<div id="links">
<div class="export">
<?php
echo $html->link('Exportar el informe a PDF', array('controller' => 'vaccinations', 'action' => 'show_pdf',$thenhc),array('class'=>'export'));
echo $this->Html->para(null, 'Exporte el resultado de su selección a PDF para su archivo, impresión o envío');
?>
</div>

<?php

	//if(is_array($data)) print_r($data); else echo "<p>$data</p>";
	$matrizHeadings = array(
		'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'F. vacunación'=>'fecha', 'Enfermedad'=>'enfermedad', 'Dosis' => 'dosis', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote'
	);
	$matrizModelos = array(
		'Patient', 'Patient', 'Patient', 'Vaccination', 'Vaccine', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine'
	);
	$matrizFechas = array(2, 3); // qué campos son Fechas para cambiar el formato; el índice comienza por 0

?>

<table id="datos">
	<thead>
		<tr>
			<?php
				$contadorh = 0;
				echo '<th class="hidden">ID</th>';
				foreach($matrizHeadings as $heading=>$sortHeading) {
					echo $this->Html->tag('th',
						$this->Paginator->link($heading, array('sort' => $matrizModelos[$contadorh].'.'.$sortHeading),
					array('escape'=>false))
					);
					$contadorh ++;
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($data as $vaccination) {
				if($vaccination['Vaccination']['antihepatitisB'] == 1) $form_id = 1;
				elseif($vaccination['Vaccination']['infantil'] == 1) $form_id = 2;
				elseif($vaccination['Vaccination']['antigripal'] == 1) $form_id = 3;
				elseif($vaccination['Vaccination']['adultos_dosis'] == 1) $form_id = 4;
				elseif($vaccination['Vaccination']['adultos_sin_dosis'] == 1) $form_id = 5;
				echo '<tr>';
				echo $this->Html->tag('td', $vaccination['Vaccination']['id'], array('class'=>'hidden'));
					$contador = 0;
					foreach ($matrizHeadings as $heading=>$field) {
						
						$celda = $vaccination[$matrizModelos[$contador]][$field];
						if($contador == 0) {
							$celda = $celda.' '.$vaccination['Patient']['apellido2'];
						}
						if(in_array($contador, $matrizFechas)) {
							$celda = date('d-m-Y', strtotime($celda));
						}
						if($field == 'riesgo') {
							if($vaccination['Situation']['contacto_aves']) {$aves = '/ Contacto con aves ';} else {$aves = '';}
							if($vaccination['Situation']['personal_sanitario']) {$personals = '/ Personal Sanitario ';} else {$personals = '';}
							if($vaccination['Situation']['personal_parasanitario']) {$personalps = '/ Personal Parasanitario ';} else {$personalps = '';}
							if($vaccination['Situation']['riesgo']) {$riesgo = '/ Otra situación de riesgo ';} else {$riesgo = '';}
							$titlecelda = $aves.$personals.$personalps.$riesgo;
							if($titlecelda != '') {
								$celda = 'Sí';
							} else $celda = 'No';
						} else {
							if($celda == '1') $celda = 'Sí';
							if($celda == '0') $celda = 'No';
							$titlecelda = $celda;
						}
						
						echo $this->Html->tag('td', $this->Text->truncate($celda, 20, array('ending'=>'...', 'exact'=>true)), array('title'=>$titlecelda));
						$contador ++;
					}
				if($role == 1)
				{
					$theid = $vaccination['Vaccination']['id'];
					echo '<td class="tableaction delete">'.
					$this->Html->link('Borrar', array('controller' => 'vaccinations', 'action' => 'delete/'.$theid.'/'.$vaccination['Patient']['nhc'])).
					'</td><td class="tableaction edit">'.
					$this->Html->link('Editar', array('controller' => 'vaccinations', 'action' => 'edit/'.$theid.'/'.$form_id))
					.'</td>';
				}
				echo '</tr>';
			}
		?>
	</tbody>
</table>

<?php
	if(!$data) {
		echo $this->Html->para('message', 'No existen registros para este número de historia clínica');
	}
?>

<?php
	echo $this->Html->div('', $this->Paginator->numbers(), array('id'=>'paginator', 'escape'=>false));
?>
</cake:nocache>
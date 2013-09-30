<cake:nocache>
<?php $this->Html->script('/js/tipTip-min', array('inline'=>false)); ?>

<?php if($apellido != '') $encabezado = 'apellido '.$apellido; elseif($fechanac != '') $encabezado = 'fecha de nacimiento '.$fechanac; ?>
<h2>Pacientes con <?php echo $encabezado; ?></h2>


<?php

	//if(is_array($data)) print_r($data); else echo "<p>$data</p>";
	$matrizHeadings = array(
		'Número de Historia Clínica'=>'nhc', 'Primer apellido'=>'apellido1', 'Segundo apellido'=>'apellido2', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento'
	);
	$matrizModelos = array(
		'Patient', 'Patient', 'Patient', 'Patient', 'Patient'
	);
	$matrizFechas = array(4); // qué campos son Fechas para cambiar el formato; el índice comienza por 0

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
			foreach ($data as $patient) {
				//if($vaccination['Vaccination']['antihepatitisB'] == 1) $form_id = 1;
				//elseif($vaccination['Vaccination']['infantil'] == 1) $form_id = 2;
				//elseif($vaccination['Vaccination']['antigripal'] == 1) $form_id = 3;
				//elseif($vaccination['Vaccination']['adultos_dosis'] == 1) $form_id = 4;
				//elseif($vaccination['Vaccination']['adultos_sin_dosis'] == 1) $form_id = 5;
				echo '<tr>';
				echo $this->Html->tag('td', $patient['Patient']['id'], array('class'=>'hidden'));
					$contador = 0;
					foreach ($matrizHeadings as $heading=>$field) {
						
						$celda = $patient[$matrizModelos[$contador]][$field];
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
					$theid = $patient['Patient']['id'];
					echo '<td class="tableaction delete">'.
					$this->Html->link('Borrar', array('controller' => 'patients', 'action' => 'delete/'.$theid)).
					'</td><td class="tableaction edit">'.
					$this->Html->link('Editar', array('controller' => 'patients', 'action' => 'edit/'.$theid)).
					'</td><td class="tableaction vacs">'.
					$this->Html->link('Vacunas', array('controller' => 'vaccinations', 'action' => 'show/'.$patient['Patient']['nhc']))
					.'</td>';
				}
				echo '</tr>';
			}
		?>
	</tbody>
</table>

<?php
	if(!$data) {
		echo $this->Html->para('message', 'No existen registros para estos datos');
	}
?>

<?php
	echo $this->Html->div('', $this->Paginator->numbers(), array('id'=>'paginator', 'escape'=>false));
?>
</cake:nocache>
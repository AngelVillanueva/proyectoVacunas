<!-- Archivo: /app/views/vaccination/report.ctp -->

<?php $this->Html->script('/js/tipTip-min', array('inline'=>false)); ?>


<h2><?php echo $report_name;?></h2>

<div id="links">
<div class="export">
<?php
echo $html->link('Exportar el informe a PDF', array('controller' => 'vaccinations', 'action' => 'pdf',$id, $f_date, $s_date),array('class'=>'export'));
if($id==2) {
	echo $html->link('Exportar versión antigua', array('controller' => 'vaccinations', 'action' => 'pdf',6, $f_date, $s_date),array('style'=>'top:75%;'));
	echo $html->link('Nuevo', array('controller' => 'vaccinations', 'action' => 'pdf',7, $f_date, $s_date),array('style'=>'top:75%;left: 0;'));
}
echo $this->Html->para(null, 'Exporte el resultado de su selección a PDF para su archivo, impresión o envío');
?>
</div>

<?php
	echo $form->create('Vaccination', array('class'=>'filtro'), array('controller' => 'vaccionations', 'action' => 'report',$id));
	echo $this->Html->para(null, 'Puede filtrar los resultados del informe eligiendo fechas de inicio y final (fecha de vacunación)');
?>

<?php
	echo $form->input('date1', array( 'label' => __('Inicio', true),'type' => 'date', 'dateFormat' => 'DMY', 'div'=>'input text jhidden'));
	echo $form->input('', array( 'label' => __('Inicio', true),'div'=>'input text jshow', 'class'=>'datepicker'));
	echo $form->input('date2', array( 'label' => __('Final', true),'type' => 'date', 'dateFormat' => 'DMY', 'div'=>'input text jhidden'));
	echo $form->input('', array( 'label' => __('Final', true),'div'=>'input text jshow', 'class'=>'datepicker'));
	echo $form->hidden('id', array('value' => $id));
	echo $form->end(__('Filtrar', true));
?>
</div>

<!--<div>
<input type="text" id="datepicker" style="clear:both;" />
</div>-->

<?php
	switch($id) {
		
		case 1:
			$matrizHeadings = array(
				'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'HbsAg+ Madre'=>'madre', 'F. vacunación'=>'fecha', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote'
			);
			$matrizModelos = array(
				'Patient', 'Patient', 'Patient', 'Patient', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine'
			);
			$matrizFechas = array(2, 4); // qué campos son Fechas para cambiar el formato; el índice comienza por 0
		break;
		
		case 2:
			$matrizHeadings = array(
				'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'Enfermedad'=>'enfermedad', 'F. vacunación'=>'fecha', 'Dosis'=>'dosis', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote', 'Residente'=>'residente'
			);
			$matrizModelos = array(
				'Patient', 'Patient', 'Patient', 'Vaccine', 'Vaccination', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine', 'Situation'
			);
			$matrizFechas = array(2, 4);
		break;
		
		case 3:
			$matrizHeadings = array(
				'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'Médico Familia'=>'medico_familia', 'Centro Salud'=>'centro_salud', 'F. vacunación'=>'fecha', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote', 'Riesgo'=>'riesgo'
			);
			$matrizModelos = array(
				'Patient', 'Patient', 'Patient', 'Situation', 'Situation', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine', 'Situation'
			);
			$matrizFechas = array(2, 5);
		break;
		
		case 4:
			$matrizHeadings = array(
				'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'Enfermedad'=>'enfermedad', 'F. vacunación'=>'fecha', 'Dosis'=>'dosis', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote'
			);
			$matrizModelos = array(
				'Patient', 'Patient', 'Patient', 'Vaccine', 'Vaccination', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine'
			);
			$matrizFechas = array(2, 4);
		break;
		
		case 5:
			$matrizHeadings = array(
				'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'Enfermedad'=>'enfermedad', 'F. vacunación'=>'fecha', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote'
			);
			$matrizModelos = array(
				'Patient', 'Patient', 'Patient', 'Vaccine', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine'
			);
			$matrizFechas = array(2, 4);
		break;

		case 6:
			$matrizHeadings = array(
				'Apellidos'=>'apellido1', 'Nombre'=>'nombre', 'F. nacimiento'=>'nacimiento', 'Enfermedad'=>'enfermedad', 'F. vacunación'=>'fecha', 'Dosis'=>'dosis', 'Vacuna'=>'nombre', 'Laboratorio'=>'laboratorio', 'Lote'=>'lote', 'Residente'=>'residente'
			);
			$matrizModelos = array(
				'Patient', 'Patient', 'Patient', 'Vaccine', 'Vaccination', 'Vaccination', 'Vaccine', 'Vaccine', 'Vaccine', 'Situation'
			);
			$matrizFechas = array(2, 4);
		break;
		
	}

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
				echo '</tr>';
			}
		?>
	</tbody>
</table>

<?php
	if(!$data) {
		echo $this->Html->para('message', 'No existen registros para esta vacuna');
	}
?>

<?php
	echo $this->Html->div('', $this->Paginator->numbers(), array('id'=>'paginator', 'escape'=>false));
?>
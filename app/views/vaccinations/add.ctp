<!-- Archivo: /app/views/vaccinations/form.ctp -->

<?php
	// definición de enfermedades listadas en el selector dependiendo del tipo de vacuna
	if($form_id == 2) {					// enfermedades y dosis del calendario infantil obligatorio
		$enfermedades = array(
		'Hepatitis B'=>'Hepatitis B', 'Polio-DTP-HiB'=>'Polio-DTP-HiB', 'Meningitis C'=>'Meningitis C', 'Triple Vírica'=>'Triple Vírica', 'DTP'=>'DTP', 'Varicela'=>'Varicela', 'Polio'=>'Polio', 'DTP/Td'=>'DTP/Td', 'Hib'=>'Hib'
		);
		$dosis = array(
		'0 meses'=>'0 meses', '1 mes'=>'1 mes', '2 meses'=>'2 meses', '4 meses'=>'4 meses', '6 meses'=>'6 meses', '15 meses'=>'15 meses', '18 meses'=>'18 meses', '6 años'=>'6 años', '11 años'=>'11 años', '1ª dosis'=>'1ª dosis', '2ª dosis'=>'2ª dosis', '3ª dosis'=>'3ª dosis', '4ª dosis'=>'4ª dosis', '5ª dosis'=>'5ª dosis', 'Dosis única'=>'Dosis única'
		);
	} else if($form_id == 4) {			// enfermedades adultos
		$enfermedades = array(
		'HVB'=>'HVB', 'Td'=>'Td', 'Tétanos'=>'Tétanos', 'Rubeola'=>'Rubeola', 'Gammaglobulina'=>'Gammaglobulina', 'Otras'=>'Otras'
		);
		$dosis = array(
		'1ª dosis'=>'1ª dosis', '2ª dosis'=>'2ª dosis', '3ª dosis'=>'3ª dosis', 'Recordatorio'=>'Recordatorio', 'Dosis única'=>'Dosis única'
		);
	}
	else if($form_id == 5) {			// enfermedades infantiles fuera del calendario infantil obligatorio
		$enfermedades = array(
		'Neumococo'=>'Neumococo', 'Rotavirus'=>'Rotavirus', 'Cáncer de Cérvix'=>'Cáncer de Cérvix', 'Otras'=>'Otras'
		);
		$dosis = array(
		'1ª dosis'=>'1ª dosis', '2ª dosis'=>'2ª dosis', '3ª dosis'=>'3ª dosis', '4ª dosis'=>'4ª dosis', 'Dosis única'=>'Dosis única'
		);
	}

?>

<p id="form_id" class="hidden"><?php echo $form_id;?></p>

<?php
	echo '<h2>Datos de la Vacunación: <span>'.$form_name.'</span></h2>';
	echo $session->flash('auth');
	    
	echo $this->Form->create('Vaccination', array('autocomplete'=>'off'), array('controller' => 'vaccination', 'action' => 'add'));
	echo $this->Form->hidden('Vaccination.form_id', array('value' => $form_id));    
	echo $this->Form->hidden('Vaccination.id');
	echo $this->Form->hidden('Vaccination.patient_id', array('value' => $patient_id));
?>

<div id="tipoVacuna">
<?php
	echo $this->Form->input('Vaccination.antihepatitisB');
	echo $this->Form->input('Vaccination.infantil');
	echo $this->Form->input('Vaccination.antigripal');
	echo $this->Form->input('Vaccination.adultos_dosis');
	echo $this->Form->input('Vaccination.adultos_sin_dosis');
?>
</div>

<?php
	if($form_id == 1) {
		echo $this->Form->hidden('Vaccine.enfermedad', array('value' => 'Antihepatitis-B Neonatos'));
	} else if($form_id == 3) {
		echo $this->Form->hidden('Vaccine.enfermedad', array('value' => 'Gripe'));
		
	}
	else {
		echo $this->Form->input('Vaccine.enfermedad', array('options' => $enfermedades));
		echo $this->Form->input(null, array('label' => 'Especifique la enfermedad no listada, por favor'));
	}
	echo $form->input('Vaccination.fecha', array('div'=> 'input date jhidden', 'type' => 'date', 'label' => 'Fecha de Vacunación', 'minYear' => 1900, 'maxYear' => date('Y') + 3, 'dateFormat' => 'DMY'));
	echo $form->input('Vaccination.fecha', array('type' => 'text', 'label' => 'Fecha de Vacunación' , 'div'=>'input text jshow', 'class'=>'datepicker'));
	
?>
<?php
	if($form_id == 2 || $form_id == 4 || $form_id == 5) {
		if($form_id == 2) {
			echo $this->Form->input('Vaccination.actualizacion', array('label'=>'¿Es una actualización del calendario?','options'=>array('No', 'Sí')));
		}
		echo $this->Form->input('Vaccination.dosis', array('options'=>$dosis));
		echo $this->Form->input('VaccinationDosisCopia', array('div' => 'hidden', 'options' => $dosis));
	}
?>
<?php
	echo '<h2>Información de la Vacuna</h2>';
	echo $this->Form->input('Vaccine.nombre');
	echo $this->Html->para('reco', 'Indique aquí el nombre comercial de la vacuna');
	echo $this->Form->input('Vaccine.laboratorio');
	echo $this->Html->para('reco', 'Indique aquí el laboratorio que comercializa la vacuna');
	echo $this->Form->input('Vaccine.lote');
	echo $this->Html->para('reco', 'Indique aquí el lote de la vacuna según la etiqueta');
?>

<?php
	if($form_id == 2 || $form_id == 3) {
		echo '<h2>Situación personal del paciente</h2>';
	}
	if($form_id == 2) {
		echo $this->Form->input('Situation.residente', array('checked' => 'checked'));
		echo $this->Form->input(null, array('label' => 'Marque la casilla si el paciente es No Residente', 'type'=>'checkbox'));
	}
	if($form_id == 3) {
		echo $this->Form->input('Situation.medico_familia');
		echo $this->Form->hidden('Situation.centro_salud', array('value'=>'Sanatorio Santa Cristina'));
		echo $this->Form->input('Situation.contacto_aves', array('label'=>'¿Tiene el paciente Contacto con Aves?'));
		echo $this->Form->input('Situation.personal_sanitario', array('label'=>'¿Es el paciente Personal Sanitario?'));
		echo $this->Form->input('Situation.personal_parasanitario', array('label'=>'¿Es el paciente Personal Parasanitario?'));
		echo $this->Form->input('Situation.riesgo', array('label'=>'¿Está el paciente en otra Situación de Riesgo?'));
	}
?>

<?php
	echo $this->Form->end('Guardar');
?>
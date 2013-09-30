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
	echo '<h2>Edición de la Vacunación: <span>'.$form_name.'</span></h2>';
	echo $session->flash('auth');
	    
	echo $this->Form->create('Vaccination', array('autocomplete'=>'off'), array('controller' => 'vaccination', 'action' => 'add'));
	echo $this->Form->hidden('Vaccination.form_id', array('value' => $form_id));    
	echo $this->Form->hidden('Vaccination.id', array('value' => $vaccination['Vaccination']['id']));
	echo $this->Form->hidden('Patient.id', array('value' => $vaccination['Patient']['id']));
	echo $this->Form->hidden('Patient.nhc', array('value' => $vaccination['Patient']['nhc']));
	echo $this->Form->hidden('Vaccine.id', array('value' => $vaccination['Vaccine']['id']));
	echo $this->Form->hidden('Situation.id', array('value' => $vaccination['Situation']['id']));
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
		$laenfermedad = $vaccination['Vaccine']['enfermedad']; if(in_array($laenfermedad, $enfermedades)) {
		echo $this->Form->input('Vaccine.enfermedad', array('options' => $enfermedades, 'selected' => $laenfermedad));
		echo $this->Form->input(null, array('label' => 'Especifique la enfermedad no listada, por favor'));
		} else {
		echo $this->Form->input('Vaccine.enfermedad', array('options' => $enfermedades, 'selected' => 'Otras'));
		echo $this->Form->input(null, array('label' => 'Especifique la enfermedad no listada, por favor', 'value' => $laenfermedad));
		}
	}
	$lafecha = $vaccination['Vaccination']['fecha']; $lafecha = explode("-", $lafecha); $lafecha = $lafecha[2]."-".$lafecha[1]."-".$lafecha[0];
	echo $form->input('Vaccination.fecha', array('div'=> 'input date jhidden', 'type' => 'date', 'label' => 'Fecha de Vacunación', 'minYear' => 1900, 'maxYear' => date('Y') + 3, 'dateFormat' => 'DMY', 'value' => $lafecha));
	echo $form->input('Vaccination.fecha', array('type' => 'text', 'label' => 'Fecha de Vacunación' , 'div'=>'input text jshow', 'class'=>'datepicker', 'value' => $lafecha));
	
?>
<?php
	if($form_id == 2 || $form_id == 4 || $form_id == 5) {
		if($form_id == 2) {
			echo $this->Form->input('Vaccination.actualizacion', array('label'=>'¿Es una actualización del calendario?','options'=>array('No', 'Sí'), 'value' => $vaccination['Vaccination']['actualizacion']));
		}
		echo $this->Form->input('Vaccination.dosis', array('options'=>$dosis, 'value' => $vaccination['Vaccination']['dosis'], 'selected' => $vaccination['Vaccination']['dosis']));
		echo $this->Form->input('VaccinationDosisCopia', array('div' => 'hidden', 'options' => $dosis, 'value' => $vaccination['Vaccination']['dosis']));
	}
?>
<?php
	echo '<h2>Información de la Vacuna</h2>';
	echo $this->Form->input('Vaccine.nombre', array('value' => $vaccination['Vaccine']['nombre']));
	echo $this->Html->para('reco', 'Indique aquí el nombre comercial de la vacuna');
	echo $this->Form->input('Vaccine.laboratorio', array('value' => $vaccination['Vaccine']['laboratorio']));
	echo $this->Html->para('reco', 'Indique aquí el laboratorio que comercializa la vacuna');
	echo $this->Form->input('Vaccine.lote', array('value' => $vaccination['Vaccine']['lote']));
	echo $this->Html->para('reco', 'Indique aquí el lote de la vacuna según la etiqueta');
?>

<?php
	if($form_id == 2 || $form_id == 3) {
		echo '<h2>Situación personal del paciente</h2>';
	}
	if($form_id == 2) {
//		$residente = $vaccination['Situation']['residente'];
//		if($residente) {
//		echo $this->Form->input('Situation.residente', array('checked' => 'checked'));
//		echo $this->Form->input(null, array('label' => 'Marque la casilla si el paciente es No Residente', 'type'=>'checkbox'));
//		}
//		else {
//		echo $this->Form->input('Situation.residente');
//		echo $this->Form->input(null, array('label' => 'Marque la casilla si el paciente es No Residente', 'type'=>'checkbox', 'checked'=>'checked'));
//		}
	echo $this->Form->input('Situation.residente', array('label'=>'¿El paciente es Residente en España?','options'=>array('No', 'Sí'), 'value' => $vaccination['Situation']['residente']));
	}
	if($form_id == 3) {
		echo $this->Form->input('Situation.medico_familia', array('value' => $vaccination['Situation']['medico_familia']));
		echo $this->Form->hidden('Situation.centro_salud', array('value'=>'Sanatorio Santa Cristina'));
		$cheqa = ''; $cheqp = ''; $cheqps = ''; $cheqr = '';
		$aves = $vaccination['Situation']['contacto_aves']; if($aves) $cheqa = 'checked';
		$personal = $vaccination['Situation']['personal_sanitario']; if($personal) $cheqp = 'checked';
		$paras = $vaccination['Situation']['personal_parasanitario']; if($paras) $cheqps = 'checked';
		$riesgov = $vaccination['Situation']['riesgo']; if($riesgov) $cheqr = 'checked';
		echo $this->Form->input('Situation.contacto_aves', array('label'=>'¿Tiene el paciente Contacto con Aves?', 'checked' => $cheqa));
		echo $this->Form->input('Situation.personal_sanitario', array('label'=>'¿Es el paciente Personal Sanitario?', 'checked' => $cheqp));
		echo $this->Form->input('Situation.personal_parasanitario', array('label'=>'¿Es el paciente Personal Parasanitario?', 'checked' => $cheqps));
		echo $this->Form->input('Situation.riesgo', array('label'=>'¿Está el paciente en otra Situación de Riesgo?', 'checked' => $cheqr));
	}
?>

<?php
	echo $this->Form->end('Guardar Cambios');
?>
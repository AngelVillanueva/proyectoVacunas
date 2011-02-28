<!-- Archivo: /app/views/vaccinations/form.ctp -->

<?php if(empty($user))
{
echo $html->link('Login', array('controller' => 'users', 'action' => 'login')); 
}
else
{
	echo $session->read('Auth.User.username'); 
	echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
}
?>

<br/>
<br/>

<br/>

<h2><?php echo $form_name;?></h2>

<?php
echo '<h2>Datos Vacunación</h2>';
echo $session->flash('auth');    
echo $this->Form->create('Vaccination', array('controller' => 'vaccination', 'action' => 'add'));    
echo $this->Form->hidden('Vaccination.id');
echo $this->Form->hidden('Vaccination.patient_id', array('value' => $patient_id));
echo $this->Form->input('Vaccination.antihepatitisB');
echo $this->Form->input('Vaccination.infantil');
echo $this->Form->input('Vaccination.antigripal');
echo $this->Form->input('Vaccination.adultos_dosis');
echo $this->Form->input('Vaccination.adultos_sin_dosis');
echo $form->input('Vaccination.fecha', array('type' => 'datetime', 'label' => 'Fecha de Vacunación', 'minYear' => 1900, 'maxYear' => date('Y') + 3, 'dateFormat' => 'DMY', 'timeFormat' => 'NONE') );  
echo $this->Form->input('Vaccination.dosis');
echo '<h2>Datos Vacuna</h2>';
echo $this->Form->input('Vaccine.nombre');
echo $this->Form->input('Vaccine.enfermedad');
echo $this->Form->input('Vaccine.laboratorio');
echo $this->Form->input('Vaccine.lote');
echo '<h2>Situación personal</h2>';
echo $this->Form->input('Situation.residente');
echo $this->Form->input('Situation.medico_familia');
echo $this->Form->input('Situation.centro_salud');
echo $this->Form->input('Situation.contacto_aves');
echo $this->Form->input('Situation.personal_sanitario');
echo $this->Form->input('Situation.riesgo');
echo $this->Form->end('Guardar');

?>
<?php
?>
<h2>Datos Paciente</h2>

<?php    
echo $session->flash('auth');    
echo $this->Form->create('Patient', array('controller' => 'patient', 'action' => 'add')); 
echo $this->Form->hidden('form_id', array('value' => $form_id));   
echo $this->Form->input('nhc');
echo $this->Form->input('nombre');
echo $this->Form->input('apellido1');
echo $this->Form->input('apellido2'); 
echo $form->input('nacimiento', array('type' => 'datetime', 'label' => 'Fecha de Nacimiento', 'minYear' => 1900, 'maxYear' => date('Y') + 3, 'dateFormat' => 'DMY', 'timeFormat' => 'NONE') );
echo $this->Form->input('madre');
echo $this->Form->end('Añadir');
?>
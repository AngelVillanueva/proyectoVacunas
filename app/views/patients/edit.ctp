<h2>Datos del Paciente a editar</h2>
<cake:nocache>

<?php echo $session->flash('auth'); ?>

<?php    
	echo $this->Form->create('Patient', array('autocomplete'=>'off'), array('action' => 'edit'));
?>

<p id="mensaje"></p>
<div id="panel">
	<?php
		echo $this->Form->input('id', array('value' => $patient['Patient']['id'],'label' => 'Id'));
		echo $this->Form->input('nhc', array('value' => $patient['Patient']['nhc'],'label' => 'Número de Historia Clínica'));
		echo $this->Form->input('nombre', array('value' => $patient['Patient']['nombre']));
		echo $this->Form->input('apellido1', array('value' => $patient['Patient']['apellido1'], 'label'=>'Primer apellido'));
		echo $this->Form->input('apellido2', array('value' => $patient['Patient']['apellido2'], 'label'=>'Segundo apellido')); 
		echo $this->Form->input('nacimiento', array('type' => 'date', 'label' => 'Fecha de Nacimiento', 'minYear' => 1900, 'maxYear' => date('Y') + 3, 'dateFormat' => 'DMY', 'div' => 'input date jhidden'));
		echo $this->Form->input('nacimiento', array('value'=>$patient['Patient']['nacimiento'], 'type'=>'text', 'label' => 'Fecha de nacimiento', 'div'=>'input text jshow', 'class'=>'datepicker'));
		echo $this->Form->end('Confirmar');
	?>
</div>

<?php
	echo $this->Html->div('hidden','',array('id'=>'responseDiv'));	
?>
</cake:nocache>


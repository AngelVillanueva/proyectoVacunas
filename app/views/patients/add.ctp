<h2>Datos del Paciente</h2>

<?php echo $session->flash('auth'); ?>

<?php    
	echo $this->Form->create('Patient', array('class'=>'form'.$form_num, 'autocomplete'=>'off'), array('action' => 'add')); 
	echo $this->Form->hidden('form_id', array('value' => $form_id));
	echo $this->Form->input('nhc', array('value' => '', 'label'=>'Número de Historia Clínica', 'div'=>'input text elnhc'));
	echo $this->Html->div('submit', $this->Html->tag('input', '', array('type'=>'button', 'value'=>'Comprobar')), array('id'=>'falso', 'escape'=>false));
	echo $this->Html->div('', $this->Html->div('bg','').$this->Html->div('img', $this->Html->image('ajax-loader1.gif'), array('escape'=>false)), array('id'=>'loading', 'style' => 'display:none;'), array('escape'=>false));
?>

<p id="mensaje"></p>
<div id="panel">
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('apellido1', array('label'=>'Primer apellido'));
		echo $this->Form->input('apellido2', array('label'=>'Segundo apellido')); 
		echo $this->Form->input('nacimiento', array('type' => 'date', 'label' => 'Fecha de Nacimiento', 'minYear' => 1900, 'maxYear' => date('Y') + 3, 'dateFormat' => 'DMY', 'div' => 'input date jhidden'));
		echo $this->Form->input('nacimiento', array('type'=>'text', 'label' => 'Fecha de nacimiento', 'div'=>'input text jshow', 'class'=>'datepicker'));
		echo $this->Form->input('madre', array('label'=>'¿Antígeno de Superficie positivo en la madre (HbsAg)?', 'options' => array('No'=>'No', 'Sí'=>'Sí')));
		echo $this->Form->end('Continuar');
	?>
</div>

<?php
	echo $this->Html->div('hidden','',array('id'=>'responseDiv'));
	echo $this->Html->link('anchorshow', '/vaccinations/show/', array('id' => 'anchorshow', 'class' => 'hidden'));
	
?>


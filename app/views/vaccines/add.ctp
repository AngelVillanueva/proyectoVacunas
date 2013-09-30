<?php
?>
<h2>Añadir Vacuna</h2>
<?php    
echo $session->flash('auth');    
echo $this->Form->create('Vaccine', array('autocomplete'=>'off'), array('controller' => 'vaccine', 'action' => 'add'));    
echo $this->Form->input('nombre');    
echo $this->Form->input('enfermedad');
echo $this->Form->input('laboratorio');
echo $this->Form->input('lote');  
echo $this->Form->end('Añadir');

?>
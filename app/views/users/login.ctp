<?php
	echo $this->Html->tag('h2',"Acceso restringido, introduzca sus datos por favor");
?>

<?php    

	echo $session->flash('auth');    
	echo $this->Form->create('User', array('action' => 'login'));    
	echo $this->Form->input('username', array('label'=>'Nombre de usuario'));    
	echo $this->Form->input('password', array('label'=>'Contraseña'));    
	echo $this->Form->end('Acceder');

?>
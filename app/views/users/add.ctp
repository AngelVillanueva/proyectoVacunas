<?php
?>
<h2>Registrar Usuario</h2>
<?php    
echo $session->flash('auth');    
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'add'));    
echo $this->Form->input('username', array('label'=>'Nombre de usuario'));    
echo $this->Form->input('password', array('label'=>'Contraseña'));
$options=array('1'=>'Administrador','2'=>'Usuario');
//echo $form->select('role',$options,2);
echo $this->Form->input('role', array('type'=>'select', 'label'=>'Privilegios', 'options'=>$options, 'selected'=>3));    
echo $this->Form->end('Crear usuario');

?>
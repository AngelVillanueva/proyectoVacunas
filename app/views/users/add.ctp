<?php
?>
<h2>Registrar Usuario</h2>
<?php    
echo $session->flash('auth');    
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'add'));    
echo $this->Form->input('username');    
echo $this->Form->input('password');
$options=array('1'=>'Admin','2'=>'Registered');
echo $form->select('role',$options);    
echo $this->Form->end('Add User');

?>
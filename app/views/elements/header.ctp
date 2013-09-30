<div id="headerwrapper">

	<h1><?php echo $this->Html->link($this->Html->image('logoSC.png').'Aplicación Vacunas', array('controller'=>'vaccinations', 'action'=>'index'), array('escape'=>false)); ?></h1>
	
	<div id="welcome">
	<?php
		$pagina = $this->params['controller'].$this->params['action'];
	
		if($pagina == 'userslogin') {
			echo '';
		}
		else if(empty($user)) {
			echo $html->link('Login'.$pagina, array('controller' => 'users', 'action' => 'login')); 
		}
		else
		{
			echo '<ul>';
			echo '<li>Hola, <span class="user">'.$session->read('Auth.User.username').'</span></li>';
			if($role == '1') echo '<li>'.$html->link('Añadir usuario', array('controller' => 'users', 'action' => 'add')).'</li>';
			if($role == '1') echo '<li class="editv">'.$html->link('Editar vacuna', array('controller' => 'vaccinations', 'action' => 'show')).'</li>';
			if($role == '1') echo '<li class="edit">'.$html->link('Editar paciente', array('controller' => 'patients', 'action' => 'checkN')).'</li>';
			echo '<li>'.$html->link('Desconectarse', array('controller' => 'users', 'action' => 'logout')).'</li>'; 
			echo '</ul>';
			if($role == '1') echo '<div class="go"><input type="text" name="nhc" value="NHC ó Apellido ó Fecha nc." /><a href="#">Ir</a></div>';
			if($role == '1') echo '<div class="gov"><input type="text" name="nhc" value="NHC ó Fecha vacuna" /><a href="#">Ir</a></div>';
		}
	?>
	</div>

</div>
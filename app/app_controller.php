<?php

class AppController extends Controller {

	var $components = array('Auth', 'Session');
	
	function inicializarAuth()
	{
	
	$this->Auth->authorize = 'controller';
	$this->Auth->userModel = 'User';
	$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
	$this->Auth->loginRedirect = array('controller' => 'vaccinations', 'action' => 'index');
	$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
	$this->Auth->loginError = 'El nombre de usuario y/o la contraseña no son correctos';
	$this->Auth->authError = 'No tienes permiso para entrar en esta zona';
	
	}
	
	function beforeFilter(){
	
	$this->inicializarAuth();
	
	
	}
	



}

?>
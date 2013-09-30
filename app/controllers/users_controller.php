<?php

class UsersController extends AppController {

	var $name = 'Users';
	
	function index(){
	
	}
	
	function beforeFilter() {
		
		$this->Auth->loginError = 'El nombre de usuario y/o la contraseña no son correctos';
	    $this->Auth->authError = 'La sesión ha caducado. Por favor, identifíquese para acceder';
	    $this->Auth->loginRedirect = array('controller' => 'vaccinations', 'action' => 'index');
	    $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
		$this->Auth->allow('login', 'logout');
	      
	    }
	
	
	function login(){
	}
	
	function logout(){
	
		$this->redirect($this->Auth->logout());
	}


	function add(){
	
		$user = $this->Session->read('Auth.User.username');
		$role = $user = $this->Session->read('Auth.User.role');
		$this->set('user',$user);
		
		if($role != 1)
		{
		
		$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
		$this->redirect(array('controller' => 'vaccinations', 'action' => 'index'));
		
		}
		
		if (!empty($this->data)) { 
		
		if(empty($this->data['User']['username']) || empty($this->data['User']['password']) || empty($this->data['User']['role'])){
		
		$this->Session->setFlash('Debe rellenar todos los campos!', 'flash_failure');
		
		}
		
		else
		{
		$this->User->save($this->data);
		$this->Session->setFlash('¡Usuario guardado!', 'flash_success');
		$this->redirect(array('controller' => 'users', 'action' => 'add')); 
		
		}
		
		}
		
		
	
	}

}


?>
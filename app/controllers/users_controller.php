<?php

class UsersController extends AppController {

	var $name = 'Users';
	
	function index(){}
	
	function beforeFilter() {
	
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
		
		$this->Session->setFlash('Debe rellenar todos los campos!');
		
		}
		
		else
		{
		$this->User->save($this->data);
		$this->Session->setFlash('Usuario guardado!');
		$this->redirect(array('controller' => 'users', 'action' => 'add')); 
		
		}
		
		}
		
		
	
	}

}


?>
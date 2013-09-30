<?php

class AppController extends Controller {

	var $components = array('Auth', 'Session');
	
		
	function beforeRender() {
		
		$user = $this->Session->read('Auth.User.username');
		$role = $this->Session->read('Auth.User.role');
		$this->set('user',$user);
		$this->set('role',$role);
	
	
	}
	



}

?>
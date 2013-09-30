<?php 

class SituationsController extends AppController {

var $name = 'Situations';

var $paginate = array('fields' => array('Situation.id', 'Situation.vaccination_id', 'Situation.residente', 'Situation.medico_familia', 'Situation.centro_salud', 'Situation.contacto_aves', 'Situation.personal_sanitario', 'Situation.riesgo'), 'limit' => 10, 'order' => array('Situation.id' => 'asc'));


function beforeFilter() {
	
    $this->Auth->loginError = 'El nombre de usuario y/o la contraseña no son correctos';
    $this->Auth->authError = 'La sesión ha caducado. Por favor, identifíquese para acceder';
    $this->Auth->loginRedirect = array('controller' => 'vaccinations', 'action' => 'index');
    $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    $this->Auth->allow('');
     
     }



function index()
{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Situations->recursive = 0;

$data = $this->paginate('Situation');
$this->set(compact('data'));

}







}


?>
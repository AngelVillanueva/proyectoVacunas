<?php 

class VaccinesController extends AppController {

var $name = 'Vaccines';

var $paginate = array('fields' => array('Vaccine.id', 'Vaccine.vaccination_id', 'Vaccine.nombre', 'Vaccine.enfermedad', 'Vaccine.laboratorio', 'Vaccine.lote'), 'limit' => 10, 'order' => array('Vaccine.id' => 'asc'));


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

$this->Vaccines->recursive = 0;

$data = $this->paginate('Vaccine');
$this->set(compact('data'));


}

function add()
{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);

if (!empty($this->data)) { 

	if(empty($this->data['Vaccine']['nombre']) || empty($this->data['Vaccine']['enfermedad']) || empty($this->data['Vaccine']['laboratorio']) || empty($this->data['Vaccine']['lote'])){
	
		$this->Session->setFlash('Debe rellenar todos los campos!');
		
		}
	
	else
	{
	
	$this->Vaccine->save($this->data);
	$id = $this->Vaccine->id;              
	$this->redirect(array('controller' => 'vaccines', 'action' => 'view/'.$id)); 
	
	}


}

}



function view($id = null)
{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Vaccine->id = $id;
$this->set('vaccine', $this->Vaccine->read());
$this->set('id', $id);


}






}


?>
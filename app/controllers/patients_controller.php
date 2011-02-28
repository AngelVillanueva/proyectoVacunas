<?php 

class PatientsController extends AppController {

var $name = 'Patients';

var $helpers = array('Js' => array('Jquery'),'Ajax');




function beforeFilter() {
    
     $this->Auth->allow('index');
     
     }



function index()
{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Patients->recursive = 0;

$data = $this->paginate('Patient');
$this->set(compact('data'));

}


function add($form_id = null)
{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);

$this->set('form_id', $form_id);

if (!empty($this->data)) { 

	
	$nhc = $this->data['Patient']['nhc'];
	$check_nhc = $this->Patient->find('count', array('conditions' => array('Patient.nhc' => $nhc)));
	 
	
	
	if($check_nhc != 0 && $nhc != 0)
	{
	
	$patient_id = $this->Patient->field('id', array('Patient.nhc' => $nhc));
	$this->Patient->id = $patient_id;
	$patient_name = $this->Patient->field('nombre');
	$this->set('patient_name', $patient_name);
	$patient_apellido = $this->Patient->field('apellido1');
	
	$form_id = $this->data['Patient']['form_id'];
	$this->Session->setFlash('Vacunación para paciente '.$patient_name.' '.$patient_apellido);
	$this->redirect(array('controller' => 'vaccinations', 'action' => 'add/'.$form_id.'/'.$patient_id));
	}
	
	else
	{
	if($this->Patient->save($this->data))
	{
	$patient_id = $this->Patient->id; 
	$form_id = $this->data['Patient']['form_id'];             
	$this->redirect(array('controller' => 'vaccinations', 'action' => 'add/'.$form_id.'/'.$patient_id)); 
	}
	}
	
	


}

}

function view($id = null)
{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Patient->id = $id;
$this->set('patient', $this->Patient->read());
$this->set('id', $id);


}



}


?>
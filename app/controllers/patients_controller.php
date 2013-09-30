<?php 

class PatientsController extends AppController {

var $name = 'Patients';

var $helpers = array('Js' => array('Jquery'),'Ajax', 'Text');




function beforeFilter() {
	
    $this->Auth->loginError = 'El nombre de usuario y/o la contraseña no son correctos';
    $this->Auth->authError = 'La sesión ha caducado. Por favor, identifíquese para acceder';
    $this->Auth->loginRedirect = array('controller' => 'vaccinations', 'action' => 'index');
    $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    $this->Auth->allow('');
    $this->disableCache();
     
     }
     
     

function delete($id = null)
{	
	if($id)
	{
		$this->Patient->delete($id, false);
		$this->Session->setFlash('Paciente borrado correctamente', 'flash_success');
		$this->redirect(array('controller' => 'vaccinations', 'action' => 'index'));
	}
}

function index()
{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Patients->recursive = 0;

$data = $this->paginate('Patient');
$this->set(compact('data'));

}


function add($form_id = null, $form_num = null)
{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);

$this->set('form_id', $form_id);
$this->set('form_num', $form_num);

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
	$this->Session->setFlash('Está introduciendo una nueva vacunación para el paciente '.$patient_name.' '.$patient_apellido, 'flash_success');
	$this->redirect(array('controller' => 'vaccinations', 'action' => 'add/'.$form_id.'/'.$patient_id));
	}
	
	else
	{
	if($this->Patient->save($this->data))
	{
	$patient_id = $this->Patient->id; 
	$form_id = $this->data['Patient']['form_id'];             
	$this->redirect(array('controller' => 'vaccinations', 'action' => 'add/'.$form_id.'/'.$patient_id)); 
	} else {
		$this->Session->setFlash('Por favor, complete todos los campos obligatorios', 'flash_failure');
	}
	}
	
	


}

}

function add_ajax()
{
$this->layout = 'ajax';

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);

if (!empty($this->data)) { 

	
	$nhc = $this->data['Patient']['nhc'];
	$check_nhc = $this->Patient->find('count', array('conditions' => array('Patient.nhc' => $nhc)));
	 
	
	
	if($check_nhc != 0 && $nhc != 0)
	{
	
	$patient_id = $this->Patient->field('id', array('Patient.nhc' => $nhc));
	$this->Patient->id = $patient_id;
		$pid = $this->Patient->field('id');
	$patient_name = $this->Patient->field('nombre');
	$patient_apellido1 = $this->Patient->field('apellido1');
	$patient_apellido2 = $this->Patient->field('apellido2');
	$patient_nacimiento = $this->Patient->field('nacimiento');
	$patient_madre = $this->Patient->field('madre');
	
	$this->set('newpatient', 0);
	$this->set('patient_id', $patient_id);
		$this->set('pid', $pid);
	$this->set('patient_name', $patient_name);
	$this->set('patient_apellido1', $patient_apellido1);
	$this->set('patient_apellido2', $patient_apellido2);
	$this->set('patient_nacimiento', $patient_nacimiento);
	$this->set('patient_madre', $patient_madre);
	
	
	}
	
	else
	{
	$this->set('newpatient', 1);
	}
	
	


}


}

function edit($id = null)
{
	clearCache();
	
	$this->Patient->id = $id;
	$patient = $this->Patient->findById($id);
	
	$this->set('patient', $patient);
	
	if(!empty($this->data))
	{
		
		if($this->Patient->save($this->data))
		{
			$this->Session->setFlash('El paciente se ha actualizado correctamente', 'flash_success');
		}
		else
			$this->Session->setFlash('Por favor, complete todos los campos obligatorios', 'flash_failure');
	}
}

function checkN($nhc = null)
{
	$this->disableCache();
	if($nhc)
	{
		if(is_numeric($nhc))
		{
			$patient = $this->Patient->find('all', array('conditions' => array('Patient.nhc' => $nhc)));
			if($patient)
			{	
				$this->Session->setFlash('Editando al NHC '.$nhc, 'flash_success');
				$this->redirect(array('controller' => 'patients', 'action' => 'edit/'.$patient[0]['Patient']['id']));
			}
			else
			{
				$this->Session->setFlash('No existen pacientes con el Número de Historia Clínica "'.$nhc.'"<br />Si introdujo una fecha de nacimiento utilice el formato "dd-mm-aaaa"', 'flash_failure');
				$this->redirect(array('controller' => 'vaccinations'));
			}
		}
		elseif(strstr($nhc, '-') || strstr($nhc, '/'))
		{
			if(strstr($nhc, '/')) $nhc = str_replace('/', '-', $nhc);
			$fechanac = split('-', $nhc);
			if(count($fechanac)==3)
			{
				$fechanac2 = $fechanac[2].'-'.$fechanac[1].'-'.$fechanac[0];
				$patient = $this->Patient->find('all', array('conditions'=> array('Patient.nacimiento' => $fechanac2)));
				if($patient)
				{
					$this->Session->setFlash('Se han encontrado coincidencias', 'flash_success');
					$this->set('apellido', '');
					$this->set('fechanac', $nhc);
					$this->paginate = array('conditions' => array('Patient.nacimiento' => $fechanac2), 'limit' => 10, 'order' => 'Patient.apellido1 DESC');
					$data = $this->paginate('Patient');
					$this->set(compact('data'));
				}
				else {
					$this->Session->setFlash('No hay pacientes con esta fecha de nacimiento: "'.$nhc.'"');
					$this->redirect(array('controller' => 'vaccinations'));
				}
			}
			else {
				$this->Session->setFlash('Formato de fecha incorrecto, utilice dd-mm-aaaa');
				$this->redirect(array('controller' => 'vaccinations'));
			}
		}
		else
		{
			$patient = $nhc;
			$patient2 = $this->Patient->find('all', array('conditions'=>array("OR" => array('Patient.apellido1 LIKE' => $patient, 'Patient.apellido2 LIKE' => $patient))));
			if($patient2)
			{	
				$this->Session->setFlash('Se han encontrado coincidencias', 'flash_success');
				$this->set('apellido', $patient); $this->set('fechanac', '');
				$this->paginate = array('conditions' => array("OR" => array('Patient.apellido1 LIKE' => $patient, 'Patient.apellido2 LIKE' => $patient)), 'limit' => 10, 'order' => 'Patient.apellido1 DESC');
				$data = $this->paginate('Patient');
				$this->set(compact('data'));
			}
			else
			{
				$this->Session->setFlash('No existen pacientes con este apellido "'.$nhc.'"', 'flash_failure');
				$this->redirect(array('controller' => 'vaccinations'));
			}	
		}
	}
	else
	{
		$this->Session->setFlash('Es necesario introducir un Número de Historia Clínica o un Apellido', 'flash_failure');
	}
}

function checkN_Old2($nhc = null)
{
	$this->disableCache();
	if($nhc)
	{
		if(is_numeric($nhc))
		{
			$patient = $this->Patient->find('all', array('conditions' => array('Patient.nhc' => $nhc)));
			if($patient)
			{	
				$this->Session->setFlash('Editando al NHC '.$nhc, 'flash_success');
				$this->redirect(array('controller' => 'patients', 'action' => 'edit/'.$patient[0]['Patient']['id']));
			}
			else
			{
				$this->Session->setFlash('No existen pacientes con el Número de Historia Clínica '.$nhc, 'flash_failure');
			}
		}
		else
		{
			//$patient = $this->Patient->find('all', array('conditions' => array('Patient.apellido1 LIKE' => "%".$nhc."%")));
			$patient = $nhc;
			if($patient)
			{	
				$this->Session->setFlash('Se han encontrado coincidencias', 'flash_success');
				$this->set('apellido', $patient);
				$this->paginate = array('conditions' => array("OR" => array('Patient.apellido1 LIKE' => $patient, 'Patient.apellido2 LIKE' => $patient)), 'limit' => 10, 'order' => 'Patient.apellido1 DESC');
				$data = $this->paginate('Patient');
				$this->set(compact('data'));
			}
			else
			{
				$this->Session->setFlash('No existen pacientes con este apellido '.$nhc, 'flash_failure');
			}	
		}
	}
	else
	{
		$this->Session->setFlash('Es necesario introducir un Número de Historia Clínica o un Apellido', 'flash_failure');
	}
}

function checkN_Old($nhc = null)
{
	if($nhc)
	{
		$patient = $this->Patient->find('all', array('conditions' => array('Patient.nhc' => $nhc)));
		if($patient)
		{	
			$this->Session->setFlash('Editando al NHC '.$nhc, 'flash_success');
			$this->redirect(array('controller' => 'patients', 'action' => 'edit/'.$patient[0]['Patient']['id']));
		}
		else
		{
			$this->Session->setFlash('No existen pacientes con el Número de Historia Clínica '.$nhc, 'flash_failure');
		}
	}
	else
	{
		$this->Session->setFlash('Es necesario introducir un Número de Historia Clínica', 'flash_failure');
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
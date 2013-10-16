<?php 

class VaccinationsController extends AppController {

var $name = 'Vaccinations';

var $helpers = array('Js' => array('Jquery'),'Ajax', 'Text');


var $paginate = array('fields' => array('Vaccination.id', 'Vaccination.fecha', 'Vaccination.dosis', 'Vaccination.antihepatitisB', 'Vaccination.infantil', 'Vaccination.antigripal', 'Vaccination.adultos_dosis', 'Vaccination.adultos_sin_dosis'), 'limit' => 10, 'order' => array('Vaccination.id' => 'asc'));


function beforeFilter() {
	
	$this->Auth->loginError = 'El nombre de usuario y/o la contraseña no son correctos';
    $this->Auth->authError = 'La sesión ha caducado. Por favor, identifíquese para acceder';
    $this->Auth->loginRedirect = array('controller' => 'vaccinations', 'action' => 'index');
    $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    $this->Auth->allow('');
    $this->disableCache();
     
     }



function index()
{




}


function add($form_id = null, $patient_id)
{
$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Vaccination->recursive = 0;

$this->set('patient_id', $patient_id);
$this->set('form_id', $form_id);

switch($form_id)
{
	case 1:
		$form_name = 'Antihepatitis-B neonatos';
		$this->set('form_name', $form_name);
		break;
	case 2:
		$form_name = 'Calendario infantil obligatorio';
		$this->set('form_name', $form_name);
		break;
	case 3:
		$form_name = 'Campaña Antigripal';
		$this->set('form_name', $form_name);
		break;
	case 4:
		$form_name = 'Adultos';
		$this->set('form_name', $form_name);
		break;
	case 5:
		$form_name = 'Infantiles fuera del calendario vacunal';
		$this->set('form_name', $form_name);
		break;

}

	if(!empty($this->data)) { 

	 	
     $this->Vaccination->saveAll($this->data);
     $vaccination_id = $this->Vaccination->id;
     $this->Session->setFlash('Vacuna guardada correctamente', 'flash_success');
     $elform_id = $this->data['Vaccination']['form_id'];
     $this->redirect(array('controller' => 'vaccinations', 'action' => 'report/'.$elform_id));
        }
      
   

}

function delete($id = null, $nhc = null)
{	
	$this->disableCache();
	if($id)
	{
		$this->Vaccination->delete($id, false);
		$this->Session->setFlash('Vacuna borrada correctamente', 'flash_success');
		$this->redirect(array('controller' => 'vaccinations', 'action' => 'show/'.$nhc));
	}
}

function edit($id = null, $form_id = null)
{
	$this->disableCache();
	$vaccination = $this->Vaccination->findById($id);
	$patient_nhc = $vaccination['Patient']['nhc'];
	
	switch($form_id)
	{
		case 1:
			$form_name = 'Antihepatitis-B neonatos';
			$this->set('form_name', $form_name);
			break;
		case 2:
			$form_name = 'Calendario infantil obligatorio';
			$this->set('form_name', $form_name);
			break;
		case 3:
			$form_name = 'Campaña Antigripal';
			$this->set('form_name', $form_name);
			break;
		case 4:
			$form_name = 'Adultos';
			$this->set('form_name', $form_name);
			break;
		case 5:
			$form_name = 'Infantiles fuera del calendario vacunal';
			$this->set('form_name', $form_name);
			break;
		case 6:
			$form_name = 'Calendario infantil obligatorio (antiguo)';
			$this->set('form_name', $form_name);
			break;
	
	}
	
	$this->set('vaccination', $vaccination);
	$this->set('form_id', $form_id);
	
	if(!empty($this->data)) { 	
	     if($this->Vaccination->saveAll($this->data)){
		     $vaccination_id = $this->Vaccination->id;
		     $patient_id = $this->Vaccination->Patient->id;
		     $vaccine_id = $this->Vaccination->Vaccine->id;
		     $situation_id = $this->Vaccination->Situation->id;
		     $this->Session->setFlash('Vacuna editada correctamente', 'flash_success');
		     $elform_id = $this->data['Vaccination']['form_id'];
		     $this->redirect(array('controller' => 'vaccinations', 'action' => 'show/'.$this->data['Patient']['nhc']));
		  } else {
		  	$this->Session->setFlash('La vacuna no pudo editarse', 'flash_failure');
		  	$this->redirect(array('controller' => 'vaccinations', 'action' => 'edit/'.$vaccination_id.'/'.$elform_id));
		  }
	}
}


function report($id = null)
{
$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);
$this->set('id', $id);

$f_date = '';
$this->set('f_date', $f_date);
$s_date = '';
$this->set('s_date', $s_date);

if(!empty($this->data))

{

$f_date = $this->data['Vaccination']['date1'];
if(!is_array($f_date)) { $f_date = explode('-', $f_date); }
$first_date = implode("-", array_reverse($f_date));
$this->set('f_date', $first_date);
$s_date = $this->data['Vaccination']['date2'];
if(!is_array($s_date)) { $s_date = explode('-', $s_date); }
$second_date = implode("-", array_reverse($s_date));
$this->set('s_date', $second_date);

$filter_date = $this->Vaccination->find('all', array('conditions' => array('Vaccination.fecha BETWEEN ? AND ?' => array($first_date,$second_date)), 'fields' => array('Vaccination.id')));

$list = array();

foreach($filter_date as $vaccinations)

{


array_push($list, $vaccinations['Vaccination']['id']);

}

$id = $this->data['Vaccination']['id'];
$this->set('id', $id);
}

//Si no se pasa la fecha, busca todas las vacunas independientemente de la fecha.
else
{

$filter_date = $this->Vaccination->find('all', array('fields' => array('Vaccination.id')));

$list = array();

foreach($filter_date as $vaccinations)

{

array_push($list, $vaccinations['Vaccination']['id']);

}

}

switch($id)
{
	case 1:
		$report_name = 'Antihepatitis-B neonatos';
		$this->set('report_name', $report_name);
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.antihepatitisB ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;
	case 2:
		$report_name = 'Calendario infantil obligatorio';
		$this->set('report_name', $report_name);
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.infantil ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;
	case 3:
		$report_name = 'Campaña Antigripal';
		$this->set('report_name', $report_name);
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.antigripal ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;
	case 4:
		$report_name = 'Adultos (dosis)';
		$this->set('report_name', $report_name);
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_dosis ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;
	case 5:
		$report_name = 'Adultos (sin dosis)';
		$this->set('report_name', $report_name);
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_sin_dosis ' => 1), 'limit' => 10, 'order' => 'Patient.apellido1 ASC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;
	case 6:
		$report_name = 'Calendario infantil obligatorio (antiguo)';
		$this->set('report_name', $report_name);
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.infantil ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;

}

}

function show($id = null)
{
	$this->disableCache();
	$listnhc = array();
	// si en la cadena de búsqueda están los caracteres '-' ó '/' suponemos que buscan una fecha
	if(strstr($id, '-') || strstr($id, '/'))
	{
		if(strstr($id, '/')) $id = str_replace('/', '-', $id);
		$fechavac = split('-', $id);
		if(count($fechavac)==3)
		{
			$fechavac2 = $fechavac[2].'-'.$fechavac[1].'-'.$fechavac[0];
			$VaccData = $this->Vaccination->find('all', array('conditions'=> array('Vaccination.fecha' => $fechavac2)));
			foreach($VaccData as $patientData) $listnhc[] = $patientData['Patient']['nhc'];
			if(count($listnhc))
			{
				$this->Session->setFlash('Se han encontrado coincidencias', 'flash_success');
				$this->redirect(array('controller' => 'vaccinations', 'action' => 'showfecha/'.$id));
			}
			else
			{
				$this->Session->setFlash('No hay vacunas con esta fecha de vacunación: "'.$id.'"', 'flash_failure');
				$this->redirect(array('controller' => 'vaccinations', 'action' => 'index'));
			}
		}
		else
		{
			$this->Session->setFlash('No existen pacientes con el Número de Historia Clínica "'.$id.'"<br />Si introdujo una fecha de vacunación utilice el formato "dd-mm-aaaa"', 'flash_failure');
			$this->redirect(array('controller' => 'vaccinations', 'action' => 'index'));
		}
	}
	else {
		// recuperar datos del paciente a partir del número de historia clínica (NHC)
		$patientData = $this->Vaccination->Patient->find('all', array('conditions' => array('Patient.nhc' => $id), 'fields' => array('Patient.id', 'Patient.nombre', 'Patient.apellido1')));
	}
	if($patientData)
	{
		$patientid = $patientData[0]['Patient']['id'];
		$patientn = $patientData[0]['Patient']['nombre']; $patientap = $patientData[0]['Patient']['apellido1']; $patient = $patientn." ".$patientap;
	}
	else
	{
		$patientn = ''; $patientap = ''; $patient = '';
	}
	// si hay vacunas para ese paciente, crear una lista de los ids de vacunación y pasar el array de vacunaciones a $data
	$list = array();
	if($patientData && $patientData[0]['Vaccinations'])
	{
		foreach($patientData[0]['Vaccinations'] as $vacc)
		{
			$vaccid = $vacc['id'];
			$list[] = $vaccid;
		}
	}
	$this->paginate = array('conditions' => array('Vaccination.id' => $list), 'limit' => 10, 'order' => 'Vaccination.fecha ASC');
	$data = $this->paginate('Vaccination');
	
	$this->set('patientD', $patientData);
	$this->set('patient', $patient);
	$this->set('nhcstr', "(NHC: ".$id.")");
	$this->set('thenhc', $id);
	$this->set(compact('data'));
}

function showfecha($id = null)
{
	$this->disableCache();
	// recuperar datos del paciente a partir del número de historia clínica (NHC)
	$listnhc = array();
	// si en la cadena de búsqueda están los caracteres '-' ó '/' suponemos que buscan una fecha
	if(strstr($id, '-') || strstr($id, '/'))
	{
		if(strstr($id, '/')) $id = str_replace('/', '-', $id);
		$fechavac = split('-', $id);
		if(count($fechavac)==3)
		{
			$fechavac2 = $fechavac[2].'-'.$fechavac[1].'-'.$fechavac[0];
			$VaccData = $this->Vaccination->find('all', array('conditions'=> array('Vaccination.fecha' => $fechavac2)));
			foreach($VaccData as $patientData) $listnhc[] = $patientData['Patient']['nhc'];
			if(count($listnhc) < 1)
			{
				$this->Session->setFlash('No hay vacunas con esta fecha de vacunación: "'.$id.'"', 'flash_failure');
				$this->redirect(array('controller' => 'vaccinations', 'action' => 'index'));
			}
		}
		else
		{
			$this->Session->setFlash('No existen pacientes con el Número de Historia Clínica "'.$id.'"<br />Si introdujo una fecha de vacunación utilice el formato "dd-mm-aaaa"', 'flash_failure');
			$this->redirect(array('controller' => 'vaccinations', 'action' => 'index'));
		}
	}
	$list = array();
	foreach($listnhc as $nhc)
	{
		$patientData = $this->Vaccination->Patient->find('all', array('conditions' => array('Patient.nhc' => $nhc), 'fields' => array('Patient.id', 'Patient.nombre', 'Patient.apellido1')));
		if($patientData)
		{
			$patientid = $patientData[0]['Patient']['id'];
			$patientn = $patientData[0]['Patient']['nombre']; $patientap = $patientData[0]['Patient']['apellido1']; $patient = $patientn." ".$patientap;
		}
		else
		{
			$patientn = ''; $patientap = ''; $patient = '';
		}
		// si hay vacunas para ese paciente, crear una lista de los ids de vacunación y pasar el array de vacunaciones a $data
		if($patientData && $patientData[0]['Vaccinations'])
		{
			foreach($patientData[0]['Vaccinations'] as $vacc)
			{
				if($vacc['fecha'] == $fechavac2)
				{
					$vaccid = $vacc['id'];
					$list[] = $vaccid;
				}
			}
		}
	}
		$this->paginate = array('conditions' => array('Vaccination.id' => $list), 'limit' => 10, 'order' => 'Vaccination.fecha ASC');
		$data = $this->paginate('Vaccination');
		
		//$this->set('patientD', $patientData);
		//$this->set('patient', $patient);
		//$this->set('nhcstr', "(NHC: ".$id.")");
		//$this->set('thenhc', $id);
		$this->set('fechavac', $id);
		$this->set(compact('data'));
}

function show_Old($id = null)
{
	$this->disableCache();
	// recuperar datos del paciente a partir del número de historia clínica (NHC)
	$patientData = $this->Vaccination->Patient->find('all', array('conditions' => array('Patient.nhc' => $id), 'fields' => array('Patient.id', 'Patient.nombre', 'Patient.apellido1')));
	if($patientData)
	{
		$patientid = $patientData[0]['Patient']['id'];
		$patientn = $patientData[0]['Patient']['nombre']; $patientap = $patientData[0]['Patient']['apellido1']; $patient = $patientn." ".$patientap;
	}
	else
	{
		$patientn = ''; $patientap = ''; $patient = '';
	}
	// si hay vacunas para ese paciente, crear una lista de los ids de vacunación y pasar el array de vacunaciones a $data
	$list = array();
	if($patientData && $patientData[0]['Vaccinations'])
	{
		foreach($patientData[0]['Vaccinations'] as $vacc)
		{
			$vaccid = $vacc['id'];
			$list[] = $vaccid;
		}
	}
	$this->paginate = array('conditions' => array('Vaccination.id' => $list), 'limit' => 10, 'order' => 'Vaccination.fecha ASC');
	$data = $this->paginate('Vaccination');
	
	$this->set('patientD', $patientData);
	$this->set('patient', $patient);
	$this->set('nhcstr', "(NHC: ".$id.")");
	$this->set('thenhc', $id);
	$this->set(compact('data'));
}

function show_pdf($id = null)
{
	$this->disableCache();
	$patientData = $this->Vaccination->Patient->find('all', array('conditions' => array('Patient.nhc' => $id), 'fields' => array('Patient.id', 'Patient.nombre', 'Patient.apellido1')));
	if($patientData && $patientData[0]['Vaccinations'])
	{
		$patientn = $patientData[0]['Patient']['nombre']; $patientap = $patientData[0]['Patient']['apellido1']; $patient = $patientn." ".$patientap;
		foreach($patientData[0]['Vaccinations'] as $vacc)
		{
			$vaccid = $vacc['id'];
			$list[] = $vaccid;
		}
	}
	
	$report_name = 'Listado de vacunas de '.$patient.' (NHC: '.$id.')';
	$this->set('report_name', $report_name);
	$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list), 'order' => 'Patient.apellido1 ASC')));
	$this->set('thenhc', $id);
	
	$this->layout = 'pdf';
	$this->render();
	
}


function view($id = null)
{
$this->Vaccination->recursive = 0;

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);

$this->Vaccination->id = $id;
$patient_id = $this->Vaccination->field('patient_id');
$this->set('vaccinations', $this->Vaccination->read());
$this->set('id', $id);




}

function pdf($id = null, $first_date = null, $second_date = null)

{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);
$this->set('report',$id);



if (!$id)
{
$this->Session->setFlash('no has seleccionado ningun pdf.');
$this->redirect(array('action'=>'index'));

}

if($first_date && $second_date) {
$filter_date = $this->Vaccination->find('all', array('conditions' => array('Vaccination.fecha BETWEEN ? AND ?' => array($first_date,$second_date)), 'fields' => array('Vaccination.id')));

$list = array();

foreach($filter_date as $vaccinations)

{


array_push($list, $vaccinations['Vaccination']['id']);

}
}
//Si no se pasa la fecha, busca todas las vacunas independientemente de la fecha.
else
{

$filter_date = $this->Vaccination->find('all', array('fields' => array('Vaccination.id')));

$list = array();

foreach($filter_date as $vaccinations)

{

array_push($list, $vaccinations['Vaccination']['id']);

}

}


switch($id)
{
	case 1:
		$report_name = 'Antihepatitis-B neonatos';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.antihepatitisB' => 1), 'order' => 'Vaccination.id DESC')));
		if($first_date && $second_date) {
			$firstp_date = explode('-',$first_date); $firstp_date = implode('-', array_reverse($firstp_date));
			$secondp_date = explode('-',$second_date); $secondp_date = implode('-', array_reverse($secondp_date));
		} else {$firstp_date = ''; $secondp_date = '';}
		$this->set('first_date', $firstp_date);
		$this->set('second_date', $secondp_date);
		break;
		
	case 2:
		$report_name = 'Calendario infantil obligatorio';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.infantil' => 1), 'order' => 'Vaccination.id DESC')));
		if($first_date && $second_date) {
			$firstp_date = explode('-',$first_date); $firstp_date = implode('-', array_reverse($firstp_date));
			$secondp_date = explode('-',$second_date); $secondp_date = implode('-', array_reverse($secondp_date));
		} else {$firstp_date = ''; $secondp_date = '';}
		$this->set('first_date', $firstp_date);
		$this->set('second_date', $secondp_date);
		break;
		
	case 3:
		$report_name = 'Campaña Antigripal';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.antigripal' => 1), 'order' => 'Vaccination.id DESC')));
		if($first_date && $second_date) {
			$firstp_date = explode('-',$first_date); $firstp_date = implode('-', array_reverse($firstp_date));
			$secondp_date = explode('-',$second_date); $secondp_date = implode('-', array_reverse($secondp_date));
		} else {$firstp_date = ''; $secondp_date = '';}
		$this->set('first_date', $firstp_date);
		$this->set('second_date', $secondp_date);
		break;
		
	case 4:
		$report_name = 'Adultos (dosis)';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_dosis' => 1), 'order' => 'Vaccination.id DESC')));
		if($first_date && $second_date) {
			$firstp_date = explode('-',$first_date); $firstp_date = implode('-', array_reverse($firstp_date));
			$secondp_date = explode('-',$second_date); $secondp_date = implode('-', array_reverse($secondp_date));
		} else {$firstp_date = ''; $secondp_date = '';}
		$this->set('first_date', $firstp_date);
		$this->set('second_date', $secondp_date);
		break;
		
	case 5:
		$report_name = 'Adultos (sin dosis)';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_sin_dosis' => 1), 'order' => 'Patient.apellido1 ASC')));
		if($first_date && $second_date) {
			$firstp_date = explode('-',$first_date); $firstp_date = implode('-', array_reverse($firstp_date));
			$secondp_date = explode('-',$second_date); $secondp_date = implode('-', array_reverse($secondp_date));
		} else {$firstp_date = ''; $secondp_date = '';}
		$this->set('first_date', $firstp_date);
		$this->set('second_date', $secondp_date);
		break;

	case 6:
		$report_name = 'Calendario infantil obligatorio (antiguo)';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.infantil' => 1), 'order' => 'Vaccination.patient_id DESC')));
		if($first_date && $second_date) {
			$firstp_date = explode('-',$first_date); $firstp_date = implode('-', array_reverse($firstp_date));
			$secondp_date = explode('-',$second_date); $secondp_date = implode('-', array_reverse($secondp_date));
		} else {$firstp_date = ''; $secondp_date = '';}
		$this->set('first_date', $firstp_date);
		$this->set('second_date', $secondp_date);
		break;

}


	
	//Configure::write('debug',0);
	$this->layout = 'pdf';
	$this->render();
	
	

}




}


?>
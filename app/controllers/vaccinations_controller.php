<?php 

class VaccinationsController extends AppController {

var $name = 'Vaccinations';

var $helpers = array('Js' => array('Jquery'),'Ajax');


var $paginate = array('fields' => array('Vaccination.id', 'Vaccination.fecha', 'Vaccination.dosis', 'Vaccination.antihepatitisB', 'Vaccination.infantil', 'Vaccination.antigripal', 'Vaccination.adultos_dosis', 'Vaccination.adultos_sin_dosis'), 'limit' => 10, 'order' => array('Vaccination.id' => 'asc'));


function beforeFilter() {
    
     $this->Auth->allow('index');
     
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
		$form_name = 'Adultos (dosis)';
		$this->set('form_name', $form_name);
		break;
	case 5:
		$form_name = 'Adultos (sin dosis)';
		$this->set('form_name', $form_name);
		break;

}

	if(!empty($this->data)) { 

	 	
     $this->Vaccination->saveAll($this->data);
     $vaccination_id = $this->Vaccination->id;
     $this->redirect(array('controller' => 'vaccinations', 'action' => 'view/'.$vaccination_id));
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
$first_date = implode("-", $f_date);
$this->set('f_date', $first_date);
$s_date = $this->data['Vaccination']['date2'];
$second_date = implode("-", $s_date);
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
		$this->paginate = array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_sin_dosis ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		$data = $this->paginate('Vaccination');
		$this->set(compact('data'));
		break;

}

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


$filter_date = $this->Vaccination->find('all', array('conditions' => array('Vaccination.fecha BETWEEN ? AND ?' => array($first_date,$second_date)), 'fields' => array('Vaccination.id')));

$list = array();

foreach($filter_date as $vaccinations)

{


array_push($list, $vaccinations['Vaccination']['id']);

}


switch($id)
{
	case 1:
		$report_name = 'Antihepatitis-B neonatos';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.antihepatitisB' => 1), 'order' => 'Vaccination.id DESC')));
		//$this->paginate = array('conditions' => array('Vaccination.antihepatitisB ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		//$data = $this->paginate('Vaccination');
		//$this->set(compact('data'));
		
		break;
	case 2:
		$report_name = 'Calendario infantil obligatorio';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.infantil' => 1), 'order' => 'Vaccination.id DESC')));
		//$this->paginate = array('conditions' => array('Vaccination.infantil ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		//$data = $this->paginate('Vaccination');
		//$this->set(compact('data'));
		break;
	case 3:
		$report_name = 'Campaña Antigripal';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.antigripal' => 1), 'order' => 'Vaccination.id DESC')));
		//$this->paginate = array('conditions' => array('Vaccination.antigripal ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		//$data = $this->paginate('Vaccination');
		//$this->set(compact('data'));
		break;
	case 4:
		$report_name = 'Adultos (dosis)';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_dosis' => 1), 'order' => 'Vaccination.id DESC')));
		//$this->paginate = array('conditions' => array('Vaccination.adultos_dosis ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		//$data = $this->paginate('Vaccination');
		//$this->set(compact('data'));
		break;
	case 5:
		$report_name = 'Adultos (sin dosis)';
		$this->set('report_name', $report_name);
		$this->set('report_data', $this->Vaccination->find('all',array('conditions' => array('Vaccination.id' => $list, 'Vaccination.adultos_sin_dosis' => 1), 'order' => 'Vaccination.id DESC')));
		//$this->paginate = array('conditions' => array('Vaccination.adultos_sin_dosis ' => 1), 'limit' => 10, 'order' => 'Vaccination.id DESC');
		//$data = $this->paginate('Vaccination');
		//$this->set(compact('data'));
		break;

}


	
	//Configure::write('debug',0);
	$this->layout = 'pdf';
	$this->render();
	
	

}




}


?>
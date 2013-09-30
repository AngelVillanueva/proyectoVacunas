<?php

class Patient extends AppModel 

{

	var $name = 'Patient';
	var $hasMany = 'Vaccinations';
	var $cacheQueries = false;
	
	var $validate = array(
			'nhc' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca nhc'
				),
				
			'nombre' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca nombre'
				),
				
			'apellido1' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca 1er apellido'
				),
				
			'apellido2' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca 2º apellido'
				),
				
			'nacimiento' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca Fecha de nacimiento'
				),
				
			'madre' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca el nombre de la Madre'
				),
				
				);
	
					
					
	
	
	
	
		
	




}


?>
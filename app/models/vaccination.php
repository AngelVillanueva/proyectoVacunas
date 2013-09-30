<?php

class Vaccination extends AppModel 

{

	var $name = 'Vaccination';
	var $hasOne = array('Situation', 'Vaccine');
	var $belongsTo = array('Patient');

	
	var $validate = array(
			'fecha' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca fecha de vacunación'
			
				),
				
				);
	
	
		
	




}


?>
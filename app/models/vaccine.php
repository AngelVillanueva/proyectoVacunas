<?php

class Vaccine extends AppModel 

{

	var $name = 'Vaccine';
	
	
	
	
	var $validate = array(
	
			'nombre' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca el nombre de la vacuna'
				),
	
			'laboratorio' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca el nombre del laboratorio'
				),
				
			'lote' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca el lote'
				),
				
				
				);
	
	
		
	




}


?>
<?php
	$vacunasCalendario = 'Hepatitis, Polio, DTP, Meningitis, Triple Vírica, Varicela, Td';
	$vacunasFuera = 'Neumococo, Rotavirus, Cáncer de Cérvix, Otras vacunas';
?>

<?php

	echo $this->Html->tag('ul',
		$this->Html->tag('li',
			$this->Html->link('Nueva Vacuna'.$this->Html->tag('span', "ir"), '#', array('class'=>'main', 'escape'=>false)).
			$this->Html->tag('ul',
				$this->Html->tag('li',
					$this->Html->link('Antihepatitis-B neonatos',array('controller' => 'patients', 'action' => 'add', 1, 'uno')),
				array('escape'=>false)).
				$this->Html->tag('li',
					$this->Html->link('Vacunas Infantiles (no antigripal)','#', array('class'=>'separator')).
					$this->Html->tag('ul',
						$this->Html->tag('li',
							$this->Html->link('Calendario infantil obligatorio'.$this->Html->tag('span', $vacunasCalendario),
								array('controller' => 'patients', 'action' => 'add', 2, 'dos'), array('escape'=>false)),
						array('escape'=>false)).
						$this->Html->tag('li',
							$this->Html->link('Infantiles fuera del calendario'.$this->Html->tag('span', $vacunasFuera),
								array('controller' => 'patients', 'action' => 'add', 5, 'cinco'), array('escape'=>false)),
						array('escape'=>false)),
					array('id'=>'sub-nav3'), array('escape'=>false)),
				array('escape'=>false)).
				$this->Html->tag('li',
					$this->Html->link('Campaña Antigripal',array('controller' => 'patients', 'action' => 'add', 3, 'tres')),
				array('escape'=>false)).
				$this->Html->tag('li',
					$this->Html->link('Otras vacunas Adultos',array('controller' => 'patients', 'action' => 'add', 4, 'cuatro')),
				array('escape'=>false)),
			array('id'=>'sub-nav2'), array('escape'=>false)),
		array('class'=>'level'),array('escape'=>false)).
		$this->Html->tag('li',
			$this->Html->link('Gestión de Informes'.$this->Html->tag('span', "ir"), '#', array('class'=>'main', 'escape'=>false)).
			$this->Html->tag('ul',
				$this->Html->tag('li',
					$this->Html->link('Antihepatitis-B neonatos',array('controller' => 'vaccinations', 'action' => 'report', 1)),
				array('escape'=>false)).
				$this->Html->tag('li',
					$this->Html->link('Vacunas Infantiles (no antigripal)','#', array('class'=>'separator')).
					$this->Html->tag('ul',
						$this->Html->tag('li',
							$this->Html->link('Calendario infantil obligatorio'.$this->Html->tag('span', $vacunasCalendario),
								array('controller' => 'vaccinations', 'action' => 'report', 2, 'dos'), array('escape'=>false)),
						array('escape'=>false)).
						$this->Html->tag('li',
							$this->Html->link('Infantiles fuera del calendario'.$this->Html->tag('span', $vacunasFuera),
								array('controller' => 'vaccinations', 'action' => 'report', 5, 'cinco'), array('escape'=>false)),
						array('escape'=>false)),
					array('id'=>'sub-nav4'), array('escape'=>false)),
				array('escape'=>false)).
				$this->Html->tag('li',
					$this->Html->link('Campaña Antigripal',array('controller' => 'vaccinations', 'action' => 'report', 3)),
				array('escape'=>false)).
				$this->Html->tag('li',
					$this->Html->link('Otras vacunas Adultos',array('controller' => 'vaccinations', 'action' => 'report', 4)),
				array('escape'=>false)),
			array('id'=>'sub-nav'), array('escape'=>false)),
		array('class'=>'level'), array('escape'=>false)),
	array('id'=>'main-nav'), array('escape'=>false));

?>
<script type="text/javascript">
	document.getElementById('sub-nav').style.display = 'none';
	document.getElementById('sub-nav2').style.display = 'none';
	document.getElementById('sub-nav3').style.display = 'none';
	document.getElementById('sub-nav4').style.display = 'none'; 
</script>
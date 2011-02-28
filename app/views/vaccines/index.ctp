<!-- Archivo: /app/views/vaccines/index.ctp -->

<h2><?php __('Vacunas:') ?></h2>

<table>

	<tr>       
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Vacunacion_id', true), 'vaccination_id'); ?></th>
		<th><?php echo $paginator->sort(__('Nombre', true), 'nombre'); ?></th>
		<th><?php echo $paginator->sort(__('Enfermedad', true), 'enfermedad'); ?></th>
		<th><?php echo $paginator->sort(__('Laboratorio', true), 'laboratorio'); ?></th>
		<th><?php echo $paginator->sort(__('Lote', true), 'lote'); ?></th>
		 
		  
	</tr>
	
	<?php foreach($data as $vaccine): ?>
	
	<tr>
		<td><?php echo $vaccine['Vaccine']['id']; ?></td>
		<td><?php echo $vaccine['Vaccine']['vaccination_id']; ?></td>
		<td><?php echo $vaccine['Vaccine']['nombre']; ?></td>
		<td><?php echo $vaccine['Vaccine']['enfermedad']; ?></td>
		<td><?php echo $vaccine['Vaccine']['laboratorio']; ?></td>
		<td><?php echo $vaccine['Vaccine']['lote']; ?></td>
		

	</tr>
	
	<?php endforeach; ?>

</table>

<!-- Muestra los numeros de página -->

<?php echo $paginator->numbers(); ?>

<!-- Muestra los enlaces para Anterior y Siguiente -->

<?php
	echo $paginator->prev(__('<< Prev ', true), null, null, array('class' => 'disabled'));
	echo $paginator->next(__(' Next >>', true), null, null, array('class' => 'disabled'));

?>

<!-- Muestra X de Y, donde X es la página actual e Y el total de páginas -->

<?php echo $paginator->counter(); ?> 
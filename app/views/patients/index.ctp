<!-- Archivo: /app/views/patients/index.ctp -->

<h2><?php __('Pacientes:') ?></h2>

<table>

	<tr>       
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('NHC', true), 'nhc'); ?></th>
		<th><?php echo $paginator->sort(__('Nombre', true), 'nombre'); ?></th>
		<th><?php echo $paginator->sort(__('Apellido', true), 'apellido1'); ?></th>
		<th><?php echo $paginator->sort(__('Segundo Apellido', true), 'apellido2'); ?></th>
		<th><?php echo $paginator->sort(__('Fecha de Nacimiento', true), 'nacimiento'); ?></th>
		<th><?php echo $paginator->sort(__('Madre', true), 'madre'); ?></th>  
		  
	</tr>
	
	<?php foreach($data as $patient): ?>
	
	<tr>
		<td><?php echo $patient['Patient']['id']; ?></td>
		<td><?php echo $patient['Patient']['nhc']; ?></td>
		<td><?php echo $patient['Patient']['nombre']; ?></td>
		<td><?php echo $patient['Patient']['apellido1']; ?></td>
		<td><?php echo $patient['Patient']['apellido2']; ?></td>
		<td><?php echo $patient['Patient']['nacimiento']; ?></td>
		<td><?php echo $patient['Patient']['madre']; ?></td>

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
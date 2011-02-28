<!-- Archivo: /app/views/situations/index.ctp -->

<h2><?php __('Situaciones:') ?></h2>

<table>

	<tr>       
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Vacunacion_id', true), 'vaccination_id'); ?></th>
		<th><?php echo $paginator->sort(__('Residente', true), 'residente'); ?></th>
		<th><?php echo $paginator->sort(__('Medico Familia', true), 'medico_familia'); ?></th>
		<th><?php echo $paginator->sort(__('Centro Salud', true), 'centro_salud'); ?></th>
		<th><?php echo $paginator->sort(__('Contacto Aves', true), 'contacto_aves'); ?></th>
		<th><?php echo $paginator->sort(__('Personal Sanitario', true), 'personal_sanitario'); ?></th>
		<th><?php echo $paginator->sort(__('Riesgo', true), 'riesgo'); ?></th>
	</tr>
	
	<?php foreach($data as $situation): ?>
	
	<tr>
		<td><?php echo $situation['Situation']['id']; ?></td>
		<td><?php echo $situation['Situation']['vaccination_id']; ?></td>
		<td><?php echo $situation['Situation']['residente']; ?></td>
		<td><?php echo $situation['Situation']['medico_familia']; ?></td>
		<td><?php echo $situation['Situation']['centro_salud']; ?></td>
		<td><?php echo $situation['Situation']['contacto_aves']; ?></td>
		<td><?php echo $situation['Situation']['personal_sanitario']; ?></td>
		<td><?php echo $situation['Situation']['riesgo']; ?></td>
		

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
<!-- Archivo: /app/views/patients/view.ctp -->

<h2><?php __('Paciente:') ?></h2>

<table>

	<tr>       
		<th><?php __('id')?></th>
		<th><?php __('NHC')?></th>
		<th><?php __('Nombre')?></th>        
		<th><?php __('Apellido')?></th>
		<th><?php __('Segundo Apellido')?></th>  
		<th><?php __('Fecha de Nacimiento')?></th>     
		<th><?php __('Madre')?></th> 
	</tr>
	
	<tr>
		<td><?php echo $patient['Patient']['id']; ?></td>
		<td><?php echo $patient['Patient']['nhc']; ?></td>
		<td><?php echo $patient['Patient']['nombre']; ?></td>
		<td><?php echo $patient['Patient']['apellido1']; ?></td>
		<td><?php echo $patient['Patient']['apellido2']; ?></td>
		<td><?php echo $patient['Patient']['nacimiento']; ?></td>
		<td><?php echo $patient['Patient']['madre']; ?></td>

	</tr>

</table>


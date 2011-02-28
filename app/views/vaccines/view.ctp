<!-- Archivo: /app/views/vaccines/view.ctp -->

<h2><?php __('Vacuna:') ?></h2>

<table>

	<tr>       
		<th><?php __('ID')?></th>
		<th><?php __('Nombre')?></th>        
		<th><?php __('Enfermedad')?></th>
		<th><?php __('Laboratorio')?></th>  
		<th><?php __('Lote')?></th>     
		  
	</tr>
	
	<tr>
		<td><?php echo $vaccine['Vaccine']['id']; ?></td>
		<td><?php echo $vaccine['Vaccine']['nombre']; ?></td>
		<td><?php echo $vaccine['Vaccine']['enfermedad']; ?></td>
		<td><?php echo $vaccine['Vaccine']['laboratorio']; ?></td>
		<td><?php echo $vaccine['Vaccine']['lote']; ?></td>

	</tr>

</table>


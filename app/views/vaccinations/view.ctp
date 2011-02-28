<!-- Archivo: /app/views/vaccinations/view.ctp -->

<?php if(empty($user))
{
echo $html->link('Login', array('controller' => 'users', 'action' => 'login')); 
}
else
{
	echo $session->read('Auth.User.username'); 
	echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
}
?>

<br/>
<br/>

<br/>

<h2><?php __('Vacunacion:') ?></h2>

<table>

	<tr>       
		<th><?php __('ID')?></th>
		<th><?php __('Patient_id')?></th>  
		<th><?php __('Nombre Paciente')?></th>    
		<th><?php __('Apellidos Paciente')?></th>    
		<th><?php __('fecha')?></th>
		<th><?php __('dosis')?></th>
		<th><?php __('antihepatitisB')?></th>
		<th><?php __('infantil')?></th>  
		<th><?php __('antigripal')?></th> 
		<th><?php __('adultos_dosis')?></th>  
		<th><?php __('adultos_sin_dosis')?></th>  
		    
		  
	</tr>
	
	<tr>
		<td><?php echo $vaccinations['Vaccination']['id']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['patient_id']; ?></td>
		<td><?php echo $vaccinations['Patient']['nombre']; ?></td>
		<td><?php echo $vaccinations['Patient']['apellido1'].' '.$vaccinations['Patient']['apellido2']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['fecha']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['dosis']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['antihepatitisB']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['infantil']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['antigripal']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['adultos_dosis']; ?></td>
		<td><?php echo $vaccinations['Vaccination']['adultos_sin_dosis']; ?></td>

	</tr>

</table>
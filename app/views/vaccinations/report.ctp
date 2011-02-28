<!-- Archivo: /app/views/vaccination/report.ctp -->

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

<h2><?php echo $report_name;?></h2>

<?php
	echo $form->create('Vaccination', array('action' => 'report'));
?>

<?php
	echo $form->input('date1', array( 'label' => __('Inicio', true),'type' => 'date', 'dateFormat' => 'YMD'));
	echo $form->input('date2', array( 'label' => __('Fin', true),'type' => 'date', 'dateFormat' => 'YMD'));
	echo $form->hidden('id', array('value' => $id));
	echo $form->end(__('Filtrar', true));
?>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Vacunacion Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Vacuna Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Paciente_id', true), 'id_paciente'); ?></th>
		<th><?php echo $paginator->sort(__('Nombre paciente', true), 'nombre_paciente'); ?></th>
		<th><?php echo $paginator->sort(__('Apellido paciente', true), 'apellido_paciente'); ?></th>
		<th><?php echo $paginator->sort(__('Fecha', true), 'fecha'); ?></th>
		<th><?php echo $paginator->sort(__('Dosis', true), 'dosis'); ?></th>
		<th><?php echo $paginator->sort(__('Medico cabecera', true), 'medico_familia'); ?></th>
		
	</tr>
	
		<?php foreach($data as $vaccination): ?>
			
	<tr>
		<td><?php echo $vaccination['Vaccination']['id']; ?> </td>
		<td><?php echo $vaccination['Vaccine']['id']; ?> </td>
		<td><?php echo $vaccination['Patient']['id']; ?> </td>
		<td><?php echo $vaccination['Patient']['nombre']; ?> </td>
		<td><?php echo $vaccination['Patient']['apellido1']; ?> </td>
		<td><?php echo date('d-m-Y', strtotime($vaccination['Vaccination']['fecha'])); ?> </td>
		<td><?php echo $vaccination['Vaccination']['dosis']; ?> </td>
		<td><?php echo $vaccination['Situation']['medico_familia']; ?> </td>
				
				
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


<br/>
<br/>
<?php
echo $html->link('Exportar PDF',array('controller' => 'vaccinations', 'action' => 'pdf',$id, $f_date, $s_date));
?>
<br/>
<br/>
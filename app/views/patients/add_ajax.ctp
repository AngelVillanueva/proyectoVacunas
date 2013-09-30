<div id="respuesta">

	<?php if($newpatient==0) {?>

	<p class="mssg">Existe un paciente asociado a este NHC (vea <a href="#" target="_blank">aquí sus vacunas anteriores</a>). Estos son sus datos:</p>
	<p class="patid"><?php echo $patient_id;?>
	<p class="patname"><?php echo $patient_name;?></p>
	<p class="patap1"><?php echo $patient_apellido1;?></p>
	<p class="patap2"><?php echo $patient_apellido2;?></p>
	<p class="patnac"><?php echo $patient_nacimiento;?></p>
	<p class="patmad"><?php echo $patient_madre;?></p>
	
	
	<?php } else {?>
	
	<p class="newpat"><?php echo $newpatient;?></p>
	<p class="mssg">Este Número de Historia Clínica todavía no tiene asociado ninguna vacuna. <span>Introduzca los datos del paciente, por favor.</span></p>
	
	<?php }?>

</div>
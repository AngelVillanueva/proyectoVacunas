<div id="respuesta">

	<?php if($newpatient==0) {?>

	<p class="patid"><?php echo $patient_id;?>
	<p class="patname"><?php echo $patient_name;?></p>
	<p class="patap1"><?php echo $patient_apellido1;?></p>
	<p class="patap2"><?php echo $patient_apellido2;?></p>
	<p class="patnac"><?php echo $patient_nacimiento;?></p>
	<p class="patmad"><?php echo $patient_madre;?></p>
	
	
	<?php } else {?>
	
	<p class="newpat"><?php echo $newpatient;?></p>
	
	<?php }?>

</div>
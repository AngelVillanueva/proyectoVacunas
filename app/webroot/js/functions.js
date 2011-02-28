// ON DOCUMENT READY
$(document).ready(function(){
	
	//Automático en página añadir nuevo paciente
	if($('#PatientAddForm').size()) {
		if($('#PatientFormId').val()=='1') {//si es para Antihepatitis-B oculto campo Nhc y le doy valor '0'
			$('#PatientNhc').val(0);
			$('#PatientNhc').parent('div').hide();
		} else { //si no, oculto campo Madre y le doy valor 'No informado'
			$('#PatientMadre').val("No informado");
			$('#PatientMadre').parent('div').hide();
		}
	}
	
});

// END OF document ready


// FUNCTIONS
function rellenaCamposPaciente() {
	if($('p.newpat').size()) {
		alert("Nuevo paciente");
	} else {
		var id = $('p.patid').text();
		var nombre = $('p.patname').text();
		var apellido1 = $('p.patap1').text();
		var apellido2 = $('p.patap2').text();
		var nacimiento = $('p.patnac').text();
		var elyear = nacimiento.substring(0,4);
		var elmes = nacimiento.substring(5,7);
		var eldia = nacimiento.substring(8,10);
		var madre = $('p.patmad').text();
		
		$('#PatientNombre').val(nombre);
		$('#PatientApellido1').val(apellido1);
		$('#PatientApellido2').val(apellido2);
		$('#PatientMadre').val(madre);
		$('#PatientNacimientoDay').val(eldia);
		$('#PatientNacimientoMonth').val(elmes);
		$('#PatientNacimientoYear').val(elyear);
	}
}
// END OF functions
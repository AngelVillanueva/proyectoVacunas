// ON DOCUMENT READY
$(document).ready(function(){
	

/*********** PAGINA PRINCIPAL *********************/
	//Muestra submenús en página de inicio
	$("#main-nav li a.main").mouseout(function(){
		if($(this).next('ul:first').css('display') == 'none') {
			$(this).parent('li').removeClass('current');
		}	
	});
	
	$('#main-nav a.main').bind('click', function(){
		$('#content').css('height','490px');
		$('#content').css('overflow','hidden');
		$('#main-nav li').removeClass('current');
		$(this).parent().addClass('current');
		$(this).next('ul:first').slideToggle('slow');
		$(this).parent().parent().children('li:not(.current)').children('ul:first').fadeOut();
		$('a.separator').parent().children('ul').fadeOut();
		
	});
	$('#main-nav a.separator').bind('click', function(){
		$('#content').css('height','600px');
		$('#main-nav li').removeClass('current');
		$(this).parent().addClass('current');
		$(this).next('ul:first').slideToggle('slow');
		$(this).parent().parent().children('li:not(.current)').children('ul:first').fadeOut();
	});
/*********** END OF PAGINA PRINCIPAL *********************/
	
/*********** FORMULARIOS GLOBAL *********************/
	//Focus en el primer campo del formulario
	if($('form').size()) {
		$( 'html, body' ).animate( { scrollTop: 0 }, 'slow' );
	}
	//Muestra los mensajes de error sobre los campos de formulario obligatorios
	if($('.form-error').size()) {
		$('.form-error').each(function(){
			var textoerror = $(this).next('.error-message').text();
			if(!$(this).prev('label').children('span').size()) {	
				$(this).prev('label').append('<span class="errorspan">'+textoerror+'</span>');
			}
		});
	}
	$('.input input').bind('change', function(){	//cuando cambia el contenido después de un error vuelve a comprobarlo
			if($(this).val() != '') {
				$(this).prev('label').children('.errorspan').remove();
				$(this).removeClass('form-error');
			} else {
				var textoerror = $(this).next('.error-message').text();
				if(!$(this).prev('label').children('span').size()) {	
					$(this).prev('label').append('<span class="errorspan">'+textoerror+'</span>');
				}
				$(this).addClass('form-error');
				
			}
	});
	
	//Automático en página con formularios para introducir el texto de ejemplo y borrarlo si se ha dejado introducido antes de hacer el submit
	if($('div.input').size()) {
		$('div.input').each(function(){
			if($(this).next('p.reco').size()) {
				$(this).next('p.reco').addClass('hidden');
				var selector = $(this).children('input');
				createValueLabel(selector, $(this).next('p.reco').text());
			}
		});
		$('div.submits input').bind('click', function(){
			$('input').each(function(){
				if($(this).val().indexOf('Indique') != -1) {
					$(this).val('').removeClass('auto-label');
				}
			});
		});
	}
/*********** END OF FORMULARIOS GLOBAL *********************/	
	
/*********** FORMULARIO AÑADIR PACIENTE *********************/
	//Dependiendo del formulario muestra unos campos u otros
	if($('#PatientAddForm').size()) {
		if($('#PatientFormId').val()=='1') {//si es para Antihepatitis-B oculto campo Nhc y le doy valor '0'
			$('#PatientNhc').val('0');
			$('#PatientNhc').parent('div').hide(); $('#falso').hide();	//esto sólo es necesario si hay un error al completar los datos, si no está oculto por CSS (si js)
		} else { //si no, oculto campo Madre y le doy valor 'No informado'
			$('#PatientMadre').val("No informado");
			$('#PatientMadre').parent('div').hide();
			$('#panel').hide();
		}
		if($('.message').size()) {
			$('#panel').show();
		}
	}
	// Para el datepicker de la fecha
	$('#PatientAddForm, #PatientEditForm').submit(function() {
		if($('.jshow #PatientNacimiento').size()) {
			if($('.jshow #PatientNacimiento').val()) {
				var lafecha = $('.jshow #PatientNacimiento').val();
				var lafechaarray = lafecha.split('-');
				var nuevafecha = lafechaarray[2] + '-' + lafechaarray[1] + '-' + lafechaarray[0];
				$('.jshow #PatientNacimiento').val(nuevafecha);
			}
		}	
		if($('#panel').css('display') == 'none') {	// desactiva el envío de los datos del formulario mientras está comprobando el NHC
			return false;
		}
	});
	// Ajax para la introducción del NHC
	$('#falso').click(function(){		// desactiva el botón auxiliar
		return false;	
	});
	$('#PatientNhc').bind('change', function(){	// ajax call para recuperar los datos del paciente si ya existe
		var laurlmadre = window.location.pathname;
		var laurlmadrepos = laurlmadre.indexOf('patients');
		laurlmadre = laurlmadre.substr(0,laurlmadrepos);
		var laurl = laurlmadre + 'patients/add_ajax';
		$.ajax({
			async:true,
			type:'post',
			beforeSend:function(request) {
				$('#loading').show();
			},
			complete:function(request, json) {
				$('#responseDiv').html(request.responseText);
				rellenaCamposPaciente();
				compruebaMadre();
				$('#loading').hide()
			},
			url: laurl,
			data:$('#PatientNhc').serialize()
		})
	});
	
	// Si faltan campos por rellenar y NHC está vacío también lo marca
	if($('.flash_failure').size() && $('#PatientNhc').size()) {
		if(!$('#PatientNhc').val()) {
			$('#PatientNhc').addClass('form-error');
			$('#PatientNhc').prev('label').append('<span class="errorspan">Introduzca NHC</span>');
		}
	}

/******** END OF FORMULARIO AÑADIR PACIENTE *****************/

/************ FORMULARIO AÑADIR VACUNA *********************/
	//Automático en página añadir vacuna para seleccionar el tipo de vacuna
	if(($('#VaccinationAddForm').size() || $('#VaccinationEditForm').size())) {
		var tipo = $('p#form_id').text(); tipo = tipo * 1; tipo = tipo -1;
		$('#tipoVacuna div :checkbox').eq(tipo).attr('checked','checked');
	}
	
	//Automático en página añadir vacuna para manejar el checkbox No Residente
	if($('#VaccinationAddForm').size() && $('input#residente').size()) {
		$('#SituationResidente').parent('div').addClass('hidden');
		$('input#residente').bind('change', function(){
			if($('#SituationResidente').is(':checked')) {
				$('#SituationResidente').attr('checked', false);
			};
		});
	}
	
	// Comprobación de campos obligatorios al añadir nueva vacuna
	if($('p#form_id').size()) {
		if($('p#form_id').text() == '3') {
			var obligatorios = Array('#VaccineNombre', '#VaccineLaboratorio', '#VaccineLote', 'SituationMedicoFamilia', 'SituationCentroSalud', '#VaccinationFecha');
		} else if ($('p#form_id').text() == '2' || $('p#form_id').text() == '4') {
			var obligatorios = Array('#VaccineNombre', '#VaccineLaboratorio', '#VaccineLote', 'VaccinationDosis', '#VaccinationFecha');
		} else {
			var obligatorios = Array('#VaccineNombre', '#VaccineLaboratorio', '#VaccineLote', '#VaccinationFecha');
		}
		$('#VaccinationAddForm div.submit input, #VaccinationEditForm div.submit input').click(function() {
			var loserrores = 0;
			$('#VaccinationAddForm input, #VaccinationEditForm input').each(function(){
				var elid = $(this).attr('id');
				if(obligatorios.join().indexOf(elid) >= 0) {
					if($(this).val() == '' || $(this).val().indexOf('Indique') >= 0) {
						$(this).addClass('form-error');
						$(this).parent('div').addClass('required');
						if(!$(this).prev('label').children('span').size()) {
							$(this).prev('label').append('<span class="errorspan">Introduzca ' + $(this).prev('label').text().toLowerCase() + '</span');
						}
						loserrores = loserrores + 1;
					} else {
						$(this).removeClass('form-error');
						$(this).prev('label').children('span').remove();
					}
				}
			});
			if(loserrores > 0) {
				if(!$('.flash_failure').size()) {
					$('#bodywrapper').prepend('<div class="message flash_failure">Por favor, complete todos los campos obligatorios</div>');
				}
				return false;
			}
			else if($('.jshow #VaccinationFecha').size()) {
				if($('.jshow #VaccinationFecha').val()) {
					var lafecha = $('.jshow #VaccinationFecha').val();
					var lafechaarray = lafecha.split('-');
					var nuevafecha = lafechaarray[2] + '-' + lafechaarray[1] + '-' + lafechaarray[0];
					$('.jshow #VaccinationFecha').val(nuevafecha);
				}
			}
		});
	}
	
	
	//Automático en página de vacunas Adultos para manejar el campo de 'Otras vacunas'
	if(($('#VaccinationAddForm').size() || $('#VaccinationEditForm').size()) && $('#VaccineEnfermedad').size()) {
		$('#VaccineEnfermedad, #VaccinationDosis, #VaccinationActualizacion, #PatientMadre').parent('div').css('height', '77px');
		$('input#enfermedad').parent('div').addClass('hidden');
		$('#VaccineEnfermedad3 option:eq(0)').clone().appendTo('#VaccinationDosis');
		$('#VaccineEnfermedad').bind('change', function() {
			if($(this).val() == 'Otras') {
				$('input#enfermedad').parent('div').hide().removeClass('hidden').addClass('required').slideDown();
			}
			else {
				if($('input#enfermedad').parent('div').hasClass('hidden')) {} else {$('input#enfermedad').parent('div').slideUp().addClass('hidden').removeClass('required');}
			}
			if($('#form_id').text() == '2') {
				if($(this).val() == 'Hepatitis B') {
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(2,3,5,6,7,8,9,10,11,12,13,14); defecto = 0; } else { ocultos = Array(0,1,2,3,4,5,6,7,8,12,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Polio-DTP-HiB') {
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,5,7,8,9,10,11,12,13,14); defecto = 2;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13); defecto = 14;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Meningitis C') {
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,4,5,7,8,9,10,11,12,13,14); defecto = 2;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,11,12,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Triple Vírica') {
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,2,3,4,6,8,9,10,11,12,13,14); defecto = 5;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,11,12,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'DTP') {
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,2,3,4,5,6,8,9,10,11,12,13,14); defecto = 7;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,9,10,11,14); defecto = 12;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Varicela') {
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,2,3,4,6,7,9,10,11,12,13,14); defecto = 8;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,11,12,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Polio') {
					$('#VaccinationActualizacion').val('1');
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13); defecto = 14;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,12,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'DTP/Td') {
					$('#VaccinationActualizacion').val('1');
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13); defecto = 14;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,12,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Hib') {
					$('#VaccinationActualizacion').val('1');
					if($('#VaccinationActualizacion').val() == '0') { ocultos = Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13); defecto = 14;} else { ocultos = Array(0,1,2,3,4,5,6,7,8,13,14); defecto = 9;}
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
			}
			if($('#form_id').text() == '4') {
				if($(this).val() == 'HVB') {
					ocultos = Array(3,4); defecto = 0;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Td' || $(this).val() == 'Tétanos') {
					ocultos = Array(4,10); defecto = 0;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() != 'HVB' && $(this).val() != 'Td' && $(this).val() != 'Tétanos') {
					ocultos = Array(0,1,2,3); defecto = 4;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
			}
			if($('#form_id').text() == '5') {
				if($(this).val() == 'Neumococo') {
					ocultos = Array(4,5); defecto = 0;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Rotavirus') {
					ocultos = Array(4,5); defecto = 0;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() == 'Cáncer de Cérvix') {
					ocultos = Array(3,4); defecto = 0;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
				if($(this).val() != 'Neumococo' && $(this).val() != 'Rotavirus' && $(this).val() != 'Cáncer de Cérvix') {
					ocultos = Array(0,1,2,3); defecto = 4;
					ocultarValoresSelector('#VaccinationDosis', defecto, ocultos);
				}
			}
		});
		$('div.submit input').bind('click', function(){
			if($('input#enfermedad').size() && $('input#enfermedad').val() != '') {
				var enfermedad = $('input#enfermedad').val();
				$('#VaccineEnfermedad').append('<option value="' + enfermedad + '">'+ enfermedad + '</option>');
				$('#VaccineEnfermedad').val(enfermedad);
				$('input#enfermedad').removeClass('form-error');
				$('input#enfermedad').prev('label').children('span').remove();
			} else if($('input#enfermedad').size() && $('input#enfermedad').val() == '') {
				$('input#enfermedad').addClass('form-error');
				if(!$('input#enfermedad').prev('label').children('span').size()) {
					$('input#enfermedad').prev('label').append('<span class="errorspan">Introduzca la enfermedad o escoja una del desplegable superior</span');
			}

			}
		});
		
	}
	
	//Automático en página de vacunas con dosis (Infantil / Adultos) para manejar los valores del campo 'Dosis'
	if(($('#VaccinationAddForm').size() || $('#VaccinationEditForm').size()) && $('#VaccinationDosis').size()) {
		$('#VaccineEnfermedad').trigger('change');
		if($('#VaccinationActualizacion').size()) {
			$('#VaccinationActualizacion').bind('change', function(){
				$('#VaccineEnfermedad').trigger('change');
			});
		}
	}

/******** END OF FORMULARIO AÑADIR VACUNA *****************/
	
	
	
/****************** TABLES *********************/
	// Truca el formulario de filtro para que devuelva los resultados en el mismo report/$id
	if($('#VaccinationReportForm').size()) {
		var laaccion = $('#VaccinationReportForm').attr('action');
		var elreport = $('#VaccinationId').val();
		$('#VaccinationReportForm').attr('action', laaccion + '/' + elreport);
	}

	//Crea tooltip para las celdas con texto truncado o con riesgo
	if($('td').size()) {
		$('td').each(function(){
			//if($(this).text().indexOf('...')>=0 || $(this).text()=='1') {
			//	$(this).addClass('tipTip');
			//}
			var eltitle = $(this).attr('title');
			var eltexto = $(this).text();
			if(eltitle != eltexto) {
				$(this).addClass('tipTip');
			}		
		});
	}
	
	// Muestra un texto indicativo si no hay más registros que mostrar en las tablas
	if($('#paginator').size()) {
		if($('#paginator').text() == '') {
			$('#paginator').append('Mostrando todos los registros actuales');
			$('#paginator').css('visibility', 'visible');	
		}
	}
/************** END OF TABLES *********************/

/****************** GLOBAL *********************/
	//Inicializar tooltip
	if($('.tipTip').size()) {
		$('.tipTip').tipTip();
	}
	
	//Efecto click en botones para IE7
	$('div.submit input').bind('click', function() {
		$(this).trigger('blur');
	});
	
	// Datepicker
	$('.datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		firstDay: 1,
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		yearRange: '1930:c'
	});
	
	// Login error effect
	if($('#UserLoginForm').size() && $('#authMessage').size()) {
		$('#authMessage').effect('shake', {times: 5}, 20);
	}
/*********** END OF GLOBAL *********************/

/**** EDIT PATIENT MENU 10 noviembre 2011 **************/
if($('#welcome input').length) {
	$('#welcome .gov input').bind('focus', function(){
		if($(this).val() == 'NHC ó Fecha vacuna') $(this).val('');
	});
	$('#welcome .gov input').bind('blur', function(){
		if($(this).val() == '') $(this).val('NHC ó Fecha vacuna');
	});
	$('#welcome .go input').bind('focus', function(){
		if($(this).val() == 'NHC ó Apellido ó Fecha nc.') $(this).val('');
	});
	$('#welcome .go input').bind('blur', function(){
		if($(this).val() == '') $(this).val('NHC ó Apellido ó Fecha nc.');
	});
		
	$('#welcome .go input').bind('change', function(){
		var valNhc = $(this).val(); 
		var oldLink = $('#welcome .edit a').attr('href');
		var newLink = oldLink + '/' + valNhc;
		$('#welcome .go a').attr('href', newLink);
	});
	$('#welcome .gov input').bind('change', function(){
		var valNhc = $(this).val(); 
		var oldLink = $('#welcome .editv a').attr('href');
		var newLink = oldLink + '/' + valNhc;
		$('#welcome .gov a').attr('href', newLink);
	});
	$('#welcome .go a').bind('hover', function(){
		var valNhc = $(this).val(); 
		var oldLink = $('#welcome .edit a').attr('href');
		var newLink = oldLink + '/' + valNhc;
		$('#welcome .go a').attr('href', newLink);
	});
	$('#welcome .gov a').bind('hover', function(){
		var valNhc = $(this).val(); 
		var oldLink = $('#welcome .editv a').attr('href');
		var newLink = oldLink + '/' + valNhc;
		$('#welcome .gov a').attr('href', newLink);
	});
	$('#welcome .edit a').bind('click', function(){
		var texto = $(this).text();
		$('.go').toggle();
		return false;
	});
	$('#welcome .editv a').bind('click', function(){
		var texto = $(this).text();
		$('.gov').toggle();
		return false;
	});
}
if($('#PatientEditForm').length) {
	if($('.jshow #PatientNacimiento').size()) {
		if($('.jshow #PatientNacimiento').val()) {
			var lafecha = $('.jshow #PatientNacimiento').val();
			var lafechaarray = lafecha.split('-');
			var nuevafecha = lafechaarray[2] + '-' + lafechaarray[1] + '-' + lafechaarray[0];
			$('.jshow #PatientNacimiento').val(nuevafecha);
		}
	}
}
$('td.tableaction.delete a').bind('click', function(){
	if(!confirm('El borrado no puede deshacerse. Quiero borrar el registro:')) return false;
});
/******* DEBUG ******/
var debug = 1;
if(debug) {
	$('#PatientAddForm').submit(function(){
		console.log($('#PatientAddForm').attr('action'));
		console.log($('#PatientAddForm').serializeArray());
		//return false;
	});
	$('#VaccinationEditForm').submit(function(){
		console.log($('#VaccinationEditForm').attr('action'));
		console.log($('#VaccinationEditForm').serializeArray());
		//return false;
	});
}
/********************************************** END OF document ready ******************************************/
});

/********************* AUX FUNCTIONS ********************/

/*   FUNCTION to set the stored values in the input fields when patient already exists   */
function rellenaCamposPaciente() {
	
	$('#panel').fadeOut();
	$('#PatientAddForm .input:first').removeClass('error');
	$('#PatientAddForm .input:first div').remove();
	
	if($('#PatientNhc').val() == '') {
		var mensaje = '<div class="error-message">Introduzca Número de Historia Clínica</div>';
		$('#PatientAddForm .input:first').addClass('error').append(mensaje);
	}
	else if($('p.newpat').size()) {
		var mensaje = $('p.mssg').html();
		mensaje = '<div class="notice">' + mensaje + '</div>';
		$('#PatientAddForm .input:first').append(mensaje);
		$('#PatientNombre').val('').removeAttr('readonly');
		$('#PatientApellido1').val('').removeAttr('readonly');
		$('#PatientApellido2').val('').removeAttr('readonly');
		$('#PatientMadre').val('').removeAttr('readonly');
		$('#PatientNacimientoDay').val('').removeAttr('readonly');
		$('#PatientNacimientoMonth').val('').removeAttr('readonly');
		$('#PatientNacimientoYear').val('').removeAttr('readonly');
		$('#PatientNacimiento').removeAttr('readonly');
		$('#panel').fadeIn();
	} else {
			var nhc = $('#PatientNhc').val();
			var anchorshow = $('#anchorshow').attr('href');
			var enlace = anchorshow + nhc;
			$('p.mssg a').attr('href', enlace).css({'color':'#4ca83d', 'text-decoration':'underline'});
		var mensaje = $('p.mssg').html();
		mensaje = '<div class="success">' + mensaje + '</div>';
		var id = $('p.patid').text();
		var nombre = $('p.patname').text();
		var apellido1 = $('p.patap1').text();
		var apellido2 = $('p.patap2').text();
		var nacimiento = $('p.patnac').text();
		var elyear = nacimiento.substring(0,4);
		var elmes = nacimiento.substring(5,7);
		var eldia = nacimiento.substring(8,10);
		var madre = $('p.patmad').text();
		$('#PatientAddForm .input:first').append(mensaje);
		$('#PatientNombre').val(nombre);
		$('#PatientApellido1').val(apellido1);
		$('#PatientApellido2').val(apellido2);
		$('#PatientMadre').val(madre);
		$('#PatientNacimientoDay').val(eldia);
		$('#PatientNacimientoMonth').val(elmes);
		$('#PatientNacimientoYear').val(elyear);
		$('#PatientNacimiento').val(eldia+'-'+elmes+'-'+elyear);
			var role = $('span.user').attr('data-role');
			if(role ==1 || role == '2') {
				$('#PatientNombre, #PatientApellido1, #PatientApellido2, #PatientMadre, #PatientNacimientoDay, #PatientNacimientoMonth, #PatientNacimientoYear, #PatientNacimiento').attr('readonly', 'readonly');
			}
		$('#panel').fadeIn();
	}
	
}
/*   End of Function to set the stored values in the input fields when patient already exists   */

/*   FUNCTION to set the default value in the 'Madre' field   */
function compruebaMadre() {
	
	if($('#PatientFormId').val()>1 && $('input#PatientMadre').val() == '') {
		$('input#PatientMadre').val('no informado');
	}
}
/*   End of Function to set the default value in the 'Madre' field   */

/*   FUNCTION to set a default value in an input field   */
function createValueLabel (selector, defaultValue){
  
  $(selector).data("default", defaultValue);	//assign the default value to the form selector
 
  if(!$(selector).val()) $(selector).val(defaultValue);	//if the selector is empty, initialize the default value
  
  $(selector).bind("focus blur", function(){	//assign a function to the focus and blur events
    value = $(this).val();
    if(value==defaultValue) {$(this). val("") .removeClass("auto-label");}	//if the current and default value are the same, clear the input field
    if(!value) {$(this) .val(defaultValue) .addClass("auto-label");}	//if the field is empty, set the value to default
  });
  
  $(selector).trigger("focus").trigger("blur");	//invoke the events to initialize the default value
  
}
/*	End of Function to set a default value in an input field */

/* FUNCTION para ocultar valores de un selector */
// hide() option values is not x-browser, so let's clone the original selector and copy/paste option nodes
function ocultarValoresSelector(selector, nuevopordefecto, valoresocultar) {
	nuevopordefecto = 0;
	var baul = selector + 'Copia'; //implica que el id de la copia del selector es igual al del selector + 'Copia'
	var opciones = selector + ' option';
	var baulopciones = baul + ' option';
	var longitud = $(baulopciones).size();
	$(opciones).remove();
	for (i=0;i<=longitud-1;i++) {
		var seleccion = opciones + ':eq(' + i + ')';
		var baulseleccion = baulopciones + ':eq(' + i + ')';
		if(jQuery.inArray(i, valoresocultar)<=-1) {
			$(baulseleccion).clone().appendTo(selector);
		}
	}
	var selectordefecto = opciones + ':eq(' + nuevopordefecto + ')'; 
	var valorpordefecto = $(selectordefecto).val();
	$(selector).val(valorpordefecto);
}

/* End of Function para ocultar valores de un selector */

/**************************************** END OF AUX FUNCTIONS *********************************/
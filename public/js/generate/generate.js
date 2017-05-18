$(function() {
	$(".select2").select2();
	$("#formcapt").hide();
});
$('#fecha_nueva2').datepicker({
    format: "yyyy-mm-dd",

    //startDate: '0m',
    //endDate: '0m',
    autoclose: true
});
function validarSelect(campo) {
  if (campo != '') {
    select=document.getElementById(campo).selectedIndex;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
    else {
      $("#"+campo).parent().parent().attr("class","form-group has-default");
      return true;
    }
  };
};
function validarInput(campo) {
  if (campo != '') {
    select=document.getElementById(campo).value;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
    else {
      $("#"+campo).parent().parent().attr("class","form-group has-default");
      return true;
    }
  };
}
$('#generateInfo').on('click', function(){
  var a0=validarSelect('select_one');
	var a1=validarInput('fecha_nueva2');
  var _token = $('input[name="_token"]').val();
  var identificador= $('#select_one').val();
	var fechan= $('#fecha_nueva2').val();

	if (a0 == false && a1 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  else {

	  $.ajax({
         type: "POST",
         url: './verifiCaptura',
         data: { ident : identificador, fechae: fechan, _token : _token },
         success: function (data) {
					 console.log('Error:', data);
					 if (data == '0') {
						 toastr.success('Dia no capturado. !!', 'Mensaje', {timeOut: 1000});
						 $("#formcapt").show();
						 $('#idhotel').val(identificador);
						 $('#fecha_nueva').val(fechan);
						 $('#userxday').val('');
						 $('#gigxday').val('');
						 $('#mac1').val(''); $('#modelo1').val(''); $('#cliente1').val('');
						 $('#mac2').val(''); $('#modelo2').val(''); $('#cliente2').val('');
						 $('#mac3').val(''); $('#modelo3').val(''); $('#cliente3').val('');
						 $('#mac4').val(''); $('#modelo4').val(''); $('#cliente4').val('');
						 $('#mac5').val(''); $('#modelo5').val(''); $('#cliente5').val('');
						 $('#nombrew1').val(''); $('#clientew1').val('');
						 $('#nombrew2').val(''); $('#clientew2').val('');
						 $('#nombrew3').val(''); $('#clientew3').val('');
						 $('#nombrew4').val(''); $('#clientew4').val('');
						 $('#nombrew5').val(''); $('#clientew5').val('');
					 }
					 if (data == '1') {
						 toastr.error('Dia capturado. !!', 'Mensaje', {timeOut: 1000});
						 $("#formcapt").hide();
						 $('#idhotel').val('');
						 $('#fecha_nueva').val('');
						 $('#userxday').val('');
						 $('#gigxday').val('');
						 $('#mac1').val(''); $('#modelo1').val(''); $('#cliente1').val('');
						 $('#mac2').val(''); $('#modelo2').val(''); $('#cliente2').val('');
						 $('#mac3').val(''); $('#modelo3').val(''); $('#cliente3').val('');
						 $('#mac4').val(''); $('#modelo4').val(''); $('#cliente4').val('');
						 $('#mac5').val(''); $('#modelo5').val(''); $('#cliente5').val('');
						 $('#nombrew1').val(''); $('#clientew1').val('');
						 $('#nombrew2').val(''); $('#clientew2').val('');
						 $('#nombrew3').val(''); $('#clientew3').val('');
						 $('#nombrew4').val(''); $('#clientew4').val('');
						 $('#nombrew5').val(''); $('#clientew5').val('');
					 }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});

$('#generateClear').on('click', function(){
		$("#formcapt")[0].reset();
		$("#formcapt").hide();
		$("#select_one").select2("val", "");
		$('#fecha_nueva2').val('');
});

$('#subform').on('click', function(){
	var a0=validarInput('userxday');	var a1=validarInput('gigxday');
	var a2=validarInput('mac1');	var a3=validarInput('modelo1'); var a4=validarInput('cliente1');
	var a5=validarInput('mac2');  var a6=validarInput('modelo2'); var a7=validarInput('cliente2');
	var a8=validarInput('mac3');  var a9=validarInput('modelo3'); var a10=validarInput('cliente3');
	var a11=validarInput('mac4'); var a12=validarInput('modelo4');var a13=validarInput('cliente4');
	var a14=validarInput('mac5'); var a15=validarInput('modelo5');var a16=validarInput('cliente5');

	var a17=validarInput('nombrew1'); var a18=validarInput('clientew1');

	if (a0 == true && a1 == true && a2 == true && a3 == true && a4 == true && a5 == true &&
			a6 == true && a7 == true && a8 == true && a9 == true && a10 == true && a11 == true &&
			a12 == true && a13 == true && a14 == true && a15 == true && a16 == true && a17 == true && a18 == true){
			toastr.success('Datos completados. !!', 'Mensaje', {timeOut: 1000});
			$( "#formcapt" ).submit();
			}
	else {
		toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
	}
});

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

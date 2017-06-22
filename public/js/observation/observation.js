$(function() {
	$(".select2").select2();
	$("#fobservation").hide();
});
$('#fecha_nueva').datepicker({
  format: "mm-yyyy",
  viewMode: "months",
  minViewMode: "months",
  startDate: '-1y',
  endDate: '0y',
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
$('#subform').on('click', function(){
	var a0=validarInput('comment');
	if (a0 == true){
			toastr.success('Datos completados. !!', 'Mensaje', {timeOut: 1000});
			$( "#fobservation" ).submit();
			}
	else {
		toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
	}
});

$('#generateInfo').on('click', function(){
  var a0=validarSelect('select_one');
	var a1=validarInput('fecha_nueva');
  var _token = $('input[name="_token"]').val();
  var identificador= $('#select_one').val();
	var fechan= $('#fecha_nueva').val();

	if (a0 == false && a1 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (a0 == true && a1 == true) {

	  $.ajax({
         type: "POST",
         url: './verifObserv',
         data: { ident : identificador, fechae: fechan, _token : _token },
         success: function (data) {
					 console.log('Error:', data);
					 if (data == '0') {
						 toastr.success('Mes no capturado. !!', 'Mensaje', {timeOut: 1000});
						 $("#fobservation").show();
						 $('#idhotel').val(identificador);
						 $('#fecha_nueva2').val(fechan);
						 $('#comment').val('');
					 }
					 if (data == '1') {
						 toastr.error('Mes capturado.!!', 'Mensaje', {timeOut: 1000});
						 $("#formcapt").hide();
						 $('#idhotel').val('');
             $('#fecha_nueva2').val('');
						 $('#comment').val('');
					 }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});
$('#generateClear').on('click', function(){
		resetdiv();
});
function resetdiv(){
	$("#fobservation")[0].reset();
	$("#fobservation").hide();

  $("#select_one").select2("val", "");
  $('#select_one').parent().parent().attr("class", "form-group has-default");
	$('#fecha_nueva').parent().parent().attr("class", "form-group has-default");
	$('#fecha_nueva').val('');
	$('#fecha_nueva').val('').datepicker('update');

}

$(function() {
	$(".select2").select2();
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

$('#generateInfo').on('click', function(){
  var a0=validarSelect('select_one');
  var _token = $('input[name="_token"]').val();
  var identificador= $('#select_one').val();

	if (a0 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  else {

	  $.ajax({
         type: "POST",
         url: './generateSNMP',
         data: { ident : identificador ,_token : _token },
         success: function (data) {
           if (data != '') {
             toastr.success('Datos Registrados. !!', 'Mensaje', {timeOut: 1000});
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});

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
function control(f){
        var ext=['jpg','jpeg','png'];
        var v=f.value.split('.').pop().toLowerCase();
        for(var i=0,n;n=ext[i];i++){
            if(n.toLowerCase()==v)
                return
        }
        var t=f.cloneNode(true);
        t.value='';
        f.parentNode.replaceChild(t,f);
        //alert('Extensión no válida solo validas JPG, JPEG, PNG');
				toastr.error('Extensión no válida solo validas JPG, JPEG, PNG.!', 'Error', {timeOut: 3000});

        //$("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
          //$("#danger-alert").slideUp(500);
        //});
    }
    
//Formulario de perfil
$('#update_data').on('click', function() {
	var z0=validarInput('inputNamefull');
	var z1=validarInput('inputdatenac');
  var nameact= $('#inputNamefull').val();
  var mailact= $('#inputEmail').val();
  var dateact= $('#inputdatenac').val();
  var _token = $('input[name="_token"]').val();

	 if (z0 == false || z1 == false) {
	 	  toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
	 }
	 else {
     $("#formPerfil").submit();
	 }
});
$('#update_pass').on('click', function(){
  var z1=validarInput('inputnpass');
  var passnueva=$('#inputnpass').val();
  var mailact= $('#inputEmail').val();

  var _token = $('input[name="_token"]').val();

   if (z1 == false) {
      toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
   }
   else {
     $("#formPerfilpass").submit();
   }
})
$('#inputdatenac').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true
});
$.getJSON('http://api.wipmania.com/jsonp?callback=?', function (data) {
	    $("#divcontexto").text(data.address.country);
	});

  $('#formPerfilpass :checkbox').change(function() {
      if (this.checked) {
        //alert('Clickeado');
        $('#inputnpass').attr('type', 'text');
          // the checkbox is now checked
      } else {
        //alert('NOClickeado');
        $('#inputnpass').attr('type', 'password');
          // the checkbox is now no longer checked
      }
  });

  document.addEventListener("DOMContentLoaded", function(event) {
  var limpnacimiento= $("#inputdatenac").val();
  if(limpnacimiento == '--'){
    $("#inputdatenac").val('');
  }


  $("#cumpleEmpleado").hide();
  var arrayDT01 = [];
  //$("#danger-alert").hide();
  $.get('/profiles',function(data){
    $.each(JSON.parse(data),function(index, objdatablasr){
      objdatablasr.toString();
      arrayDT01.push(objdatablasr);
    });
    var diaC1= arrayDT01[0].dia;
    var mesC1= arrayDT01[0].mes;
    $('#diaCumpl').val(diaC1);
    $('#mesCumpl').val(mesC1);


    var diaA= $('#diaAct').val();		var mesA= $('#mesAct').val();
    var diaC= $('#diaCumpl').val();	var mesC= $('#mesCumpl').val();

    if (mesC === mesA) {
      if (diaC === diaA) {
        $("#cumpleEmpleado").show();
      }
      if (diaC != diaA) {
        $("#cumpleEmpleado").hide();
      }
    }
    else {
      $("#cumpleEmpleado").hide();
    }

  });
});

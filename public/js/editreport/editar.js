$(function() {
  initialization_page();
  reset_quiz_current();
  $(".select2").select2({placeholder: "Please select an agent"});
});


function initialization_page(){
  $('#fecha_ngb').datepicker({ language: 'es', format: "yyyy-mm-dd", autoclose: true, endDate: '-1d' /*startDate: '0m', endDate: '0m',*/ });
  $('#fecha_nuser').datepicker({ language: 'es', format: "yyyy-mm-dd", autoclose: true , endDate: '-1d'/*startDate: '0m', endDate: '0m',*/ });
  $('#month_upload_type').datepicker({ language: 'es', format: "yyyy-mm", viewMode: "months", minViewMode: "months", autoclose: true, endDate: '0m' /*startDate: '0m', endDate: '0m',*/ });
  $('#month_upload').datepicker({ language: 'es', format: "yyyy-mm", viewMode: "months", minViewMode: "months", autoclose: true, endDate: '0m' /*startDate: '0m', endDate: '0m',*/ });

  $('#fecha_ngb').val('').datepicker('update');
  $('#fecha_nuser').val('').datepicker('update');
  $('#month_upload_type').val('').datepicker('update');
  $('#month_upload').val('').datepicker('update');
};

function reset_quiz_current(){
  inputcantone();
  inputcanttwo();
  resertselectall();
};
function inputcantone(){
  $('#valorgb_trans').val('');
  $('#new_valorgb_tran').val('');
  $('#valorgb_trans').attr('disabled', true);
  $('#new_valorgb_tran').attr('readOnly', true);
}
function inputcanttwo(){
  $('#val_user').val('');
  $('#new_val_user').val('');
  $('#val_user').attr('disabled', true);
  $('#new_val_user').attr('readOnly', true);
}
function resertselectall() {
  $("#select_onet").prop('selectedIndex',0);
  $("#select_two").prop('selectedIndex',0);
}
function habilitarnuevo(campo) {
  $('#'+campo).prop("readOnly", false);
  $('#'+campo).val('');
}
$('#select_onet').on('change', function(e){
  var id= $(this).val();
  var date_current= $('#fecha_ngb').val();
  var _token = $('input[name="_token"]').val();
  if (id != ''){
      if (date_current != '' ) {
        $.ajax({
          type: "POST",
          url: './obt_gb_report',
          data: { valora: id, d_cur: date_current,  _token : _token },
          success: function (data) {
            if (data == '') {
              mensajetoast('Mensaje', '3', 'Sin datos', 1000);
              inputcantone();
            }
            else{
              inputcantone();
              $('#fecha_ngb').prop("disabled", true);
              $('#valorgb_trans').val(data);
              habilitarnuevo('new_valorgb_tran');
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }
      else{
        $("#select_onet").prop('selectedIndex',0);
        mensajetoast('Mensaje', '3', 'Ingresa una fecha', 1000);
      }
  }
  else {
    mensajetoast('Mensaje', '3', 'Elija un hotel de la lista', 1000);
    inputcantone();
  }
});

$('#select_two').on('change', function(e){
  var id= $(this).val();
  var date_current= $('#fecha_nuser').val();
  var _token = $('input[name="_token"]').val();
  if (id != ''){
    if (date_current != '' ) {
      $.ajax({
        type: "POST",
        url: './obt_user_report',
        data: { valora: id, d_cur: date_current,  _token : _token },
        success: function (data) {
          if (data == '') {
            mensajetoast('Mensaje', '3', 'Sin datos', 1000);
            inputcanttwo();
          }
          else {
            inputcanttwo();
            $('#fecha_nuser').prop("disabled", true);
            $('#val_user').val(data);
            habilitarnuevo('new_val_user');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
    else{
      $("#select_two").prop('selectedIndex',0);
      mensajetoast('Mensaje', '3', 'Ingresa una fecha', 1000);
    }
  }
  else {
    mensajetoast('Mensaje', '3', 'Elija un hotel de la lista', 1000);
    inputcanttwo();
  }
});

function mensajetoast(title, campoa, campob, tiempo){
  switch (campoa) {
    case '1':
      toastr.success(campob, title, {timeOut: tiempo});
      break;
    case '2':
      toastr.warning(campob, title, {timeOut: tiempo});
      break;
    case '3':
      toastr.error(campob, title , {timeOut: tiempo});
      break;
  }
}
$('#generateGbClear').on('click', function(e){
  $('#fecha_ngb').val('').datepicker('update');
  $('#fecha_ngb').prop("disabled", false);
  $("#select_onet").prop('selectedIndex',0);
  inputcantone();
});
$('#generateUserClear').on('click', function(e){
  $("#select_two").prop('selectedIndex',0);
  $('#fecha_nuser').val('').datepicker('update');
  $('#fecha_nuser').prop("disabled", false);
  inputcanttwo();
});

$('#generateimgtypeClear').on('click', function(){
  limp_img_disp_type();
});
function limp_img_disp_type(){
	$('#form_edit_upload_type')[0].reset();
	$("#select_one_type").select2("val", "");
	$("#form_edit_upload_type div.form-group").attr("class","form-group has-default");
	$('#month_upload_type').val('').datepicker('update');
}

$('#generateimgClear').on('click', function(){
  limp_img_band_mens();
});
function limp_img_band_mens(){
	$('#form_edit_img_upload')[0].reset();
	$("#select_one_band").select2("val", "");
	$("#form_edit_img_upload div.form-group").attr("class","form-group has-default");
	$('#month_upload').val('').datepicker('update');
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
}

$('#generateGbInfo').on('click', function(){
  var id= $('#select_onet').val();
  var date_current= $('#fecha_ngb').val();
  var new_cant= $('#new_valorgb_tran').val();
  var _token = $('input[name="_token"]').val();

  var a0=validarSelect('select_onet');
	var a1=validarInput('fecha_ngb');
  var a2=validarInput('new_valorgb_tran');

  if (a0 == false || a1 == false || a2 == false) {
		mensajetoast('Mensaje', '3', 'Datos Requeridos. !!', 1000);
	}

  if (a0 === true && a1 === true && a2 === true) {
    //mensajetoast('Mensaje', '3', 'cumplio', 1000);
    $.ajax({
      type: "POST",
      url: './gb_edit_report',
      data: { valora: id, d_cur: date_current, d_cant: new_cant, _token : _token },
      success: function (data) {
        if (data == '1') {
          $('#fecha_ngb').val('').datepicker('update');
          $('#fecha_ngb').prop("disabled", false);
          $("#select_onet").prop('selectedIndex',0);
          inputcantone();
          mensajetoast('Mensaje', '1', 'Se actualizo con exito.', 1000);
        }
        else {
          mensajetoast('Mensaje', '3', 'Error, Intente mas tarde.', 1000);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }

});

$('#generateUserInfo').on('click', function(){
  var id= $('#select_two').val();
  var date_current= $('#fecha_nuser').val();
  var new_cant= $('#new_val_user').val();
  var _token = $('input[name="_token"]').val();

  var a0=validarSelect('select_two');
  var a1=validarInput('fecha_nuser');
  var a2=validarInput('new_val_user');

  if (a0 == false || a1 == false || a2 == false) {
    mensajetoast('Mensaje', '3', 'Datos Requeridos. !!', 1000);
  }

  if (a0 === true && a1 === true && a2 === true) {
    //mensajetoast('Mensaje', '3', 'cumplio', 1000);
    $.ajax({
      type: "POST",
      url: './user_edit_report',
      data: { valora: id, d_cur: date_current, d_cant: new_cant, _token : _token },
      success: function (data) {
        if (data == '1') {
          $('#fecha_nuser').val('').datepicker('update');
          $('#fecha_nuser').prop("disabled", false);
          $("#select_two").prop('selectedIndex',0);
          inputcanttwo();
          mensajetoast('Mensaje', '1', 'Se actualizo con exito.', 1000);
        }
        else {
          mensajetoast('Mensaje', '3', 'Error, Intente mas tarde.', 1000);
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }

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

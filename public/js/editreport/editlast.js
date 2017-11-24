$(function() {
  $(".select2").select2();
  $('#fecha_ngb').datepicker({ language: 'es', format: "yyyy-mm-dd", autoclose: true /*startDate: '0m', endDate: '0m',*/ });
  $('#fecha_nuser').datepicker({ language: 'es', format: "yyyy-mm-dd", autoclose: true /*startDate: '0m', endDate: '0m',*/ });
  desactivalimpiarinput('valorgb_trans');
  desactivalimpiarinput('new_valorgb_tran');
  $('#form_gb')[0].reset();
  resetselect('select_onet');
  resethabilitarpicker('fecha_ngb');

  desactivalimpiarinput('val_user');
  desactivalimpiarinput('new_val_user');
  $('#form_user')[0].reset();
  resetselect('select_two');
  resethabilitarpicker('fecha_nuser');
});
function habilitar(campo) {
    $('#'+campo).prop("disabled", false);
}
function habilitarnuevo(campo) {
    $('#'+campo).prop("disabled", false);
    $('#'+campo).val('');
}
function resetselect(campo){
    $('#'+campo).prop('selectedIndex',0);
    $("#"+campo).select2({placeholder: "Elija"});
}
function desactivalimpiarinput(campo){
  $('#'+campo).prop("disabled", true);
  $('#'+campo).val('');
}
function resethabilitarpicker(campo){
  $('#'+campo).prop("disabled", false);
  $('#'+campo).datepicker('update', '');
  $('#'+campo).val('');
}
function formunocolor(){
  colordefault('fecha_ngb');
  colordefault('select_onet');
  colordefault('valorgb_trans');
  colordefault('new_valorgb_tran');
}

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
  $('#form_gb')[0].reset();
  colordefault('select_onet');
  colordefault('new_valorgb_tran');
  resetselect('select_onet');
  colordefault('fecha_ngb');
  resethabilitarpicker('fecha_ngb');
});
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
            resethabilitarpicker('fecha_ngb');
            resetselect('select_onet');
            desactivalimpiarinput('valorgb_trans')
            desactivalimpiarinput('new_valorgb_tran');
            mensajetoast('Mensaje', '3', 'Sin datos', 1000);
          }
          else{
            $('#fecha_ngb').prop("disabled", true);
            $('#valorgb_trans').val(data)
            habilitar('new_valorgb_tran');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
    else{
      mensajetoast('Mensaje', '3', 'Primero debes insertar una fecha!!', 1000);
      validarInput('fecha_ngb');
      //resetselect('select_onet');
    }
  }
  else {
    $('#form_gb')[0].reset();
    resetselect('select_onet');
    mensajetoast('Mensaje', '2', 'Elija un hotel de la lista!!', 1000);
  }
});

$('#generateGbInfo').on('click', function(e){

  $val_select_hotel = validarSelect('select_onet');
  $val_date = validarInput('fecha_ngb');
  $val_newgb = validarInput('new_valorgb_tran');

  if ($val_select_hotel == true && $val_date == true && $val_newgb == true) {
    var id= $('#select_onet').val();
    var date_current= $('#fecha_ngb').val();
    var new_gb= $('#new_valorgb_tran').val();
    var _token = $('input[name="_token"]').val();

    $.ajax({
      type: "POST",
      url: './gb_edit_report',
      data: { data_one: id, data_two: date_current, data_three: new_gb,   _token : _token },
      success: function (data) {
        //alert(data);
        if (data == '1') {
          resethabilitarpicker('fecha_ngb');
          resetselect('select_onet');
          desactivalimpiarinput('valorgb_trans')
          desactivalimpiarinput('new_valorgb_tran');
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
  else {
    mensajetoast('Mensaje', '2', 'Completa los requerimientos.', 1000);
  }
});

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

function colordefault(campo){
  $("#"+campo).parent().parent().attr("class","form-group has-default");
}

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
  }
  else {
    return false;
  }
}

//------------------------------------------------------------------------------
$('#generateUserClear').on('click', function(e){
  $('#form_user')[0].reset();
  colordefault('select_two');
  colordefault('new_val_user');
  resetselect('select_two');
  colordefault('fecha_nuser');
  resethabilitarpicker('fecha_nuser');
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
            resethabilitarpicker('fecha_nuser');
            resetselect('select_two');
            desactivalimpiarinput('val_user')
            desactivalimpiarinput('new_val_user');
            mensajetoast('Mensaje', '3', 'Sin datos', 1000);
          }
          else{
            $('#fecha_nuser').prop("disabled", true);
            $('#val_user').val(data);
            desactivalimpiarinput('new_val_user');
            habilitar('new_val_user');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
    }
    else{
      mensajetoast('Mensaje', '3', 'Primero debes insertar una fecha!!', 1000);
      validarInput('fecha_nuser');
      resetselect('select_two');
    }
  }
  else {
    $('#form_user')[0].reset();
    resetselect('select_two');
    mensajetoast('Mensaje', '2', 'Elija un hotel de la lista!!', 1000);
  }
});


$('#generateUserInfo').on('click', function(e){
  $val_select_hotel = validarSelect('select_two');
  $val_date = validarInput('fecha_nuser');
  $val_newuser = validarInput('new_val_user');

  if ($val_select_hotel == true && $val_date == true && $val_newuser == true) {
    var id= $('#select_two').val();
    var date_current= $('#fecha_nuser').val();
    var new_user= $('#new_val_user').val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
      type: "POST",
      url: './user_edit_report',
      data: { data_one: id, data_two: date_current, data_three: new_user,   _token : _token },
      success: function (data) {
        if (data == '1') {
          resethabilitarpicker('fecha_nuser');
          resetselect('select_two');
          desactivalimpiarinput('val_user')
          desactivalimpiarinput('new_val_user');
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
  else {
    mensajetoast('Mensaje', '2', 'Completa los requerimientos.', 1000);
  }
});

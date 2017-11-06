$(function() {
  initialization_page();
  $(".select2").select2();
  $('#calendar_fecha').datepicker({
    language: 'es',
    defaultDate: '',
    format: "mm-yyyy",
    viewMode: "months",
    minViewMode: "months",
    endDate: '0y',
    autoclose: true
  });
});
function enableselect(campo){
  $('#'+campo).prop('disabled', false);
  $('#'+campo).parent().parent().attr("class", "form-group has-error");
}
function disableselect(campo){
  $('#'+campo).prop('disabled', true);
  $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function enabledinput(campo){
  $('#'+campo).val('');
  $('#'+campo).prop('readonly', false);
  $('#'+campo).show();
  $('#'+campo).parent().parent().attr("class", "form-group has-error");
}
function disabledinput(campo){
  $('#'+campo).prop('readonly', true);
  $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function initialization_page(){
  $('#select_one').prop('selectedIndex',0);
  $("#select_one").select2({placeholder: "Elija"});
  $('#select_one').prop('disabled', false);
  $('#calendar_fecha').val('');
  disabledinput('calendar_fecha');
  $('#gama').hide();
  $("#delta")[0].reset();
}

$('#select_one').on('change', function(e){
  var id= $(this).val();
  if (id != ''){
    $('#calendar_fecha').attr('disabled', false);
    $('#calendar_fecha').datepicker('update', '');
    enabledinput('calendar_fecha');
  }
  else {
    $('#calendar_fecha').attr('disabled', true);
    $('#calendar_fecha').datepicker('update', '');
  }
});

$('#generateInfo').on('click', function() {
  $val_select_hotel = validarSelect('select_one');
  $val_date = validarInput('calendar_fecha');
  var _token = $('input[name="_token"]').val();

  if ($val_select_hotel == true && $val_date == true) {
    $var_hotel_t1= $('#select_one').val();
    $var_date_t1= $('#calendar_fecha').val();

    if($var_hotel_t1 != '' && $var_date_t1 !=''){
      disabledinput('calendar_fecha');
      disableselect('select_one');
      $.ajax({
        type: "POST",
        url: "./info_search_register",
        data: {
          var_xa : $var_hotel_t1,
          var_xb : $var_date_t1,
          _token : _token },
          success: function (data){
            if (data != '[]') {
              $("#delta")[0].reset();
              var datos = JSON.parse(data);
              var probabilidad = datos[0].ProbabilidadNumero;
              var prob_calificacion = datos[0].Calificacion;
              var prob_num = '';
              var prob_cal = '';
              if (probabilidad == '' || probabilidad == null) { prob_num = 0; } else { prob_num = probabilidad;}
              $('#select_quest_one option[value='+prob_num+']').attr('selected','selected');
              if (prob_calificacion == "" || prob_calificacion == null){ prob_cal = 0; } else { prob_cal = prob_calificacion;}
              $('#select_quest_calf option[value='+prob_cal+']').attr('selected','selected');
              $('#comment_a').val(datos[0].Comentario1);
              $('#comment_b').val(datos[0].Comentario2);
              $('#comment_c').val(datos[0].Comentario3);
              $('#gama').show();
            }
            else {
              toastr.error('No hay calificación disponible.', 'Mensaje', {timeOut: 2000});
              initialization_page();
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });

    }
    else {
      toastr.error('Error al obtener la información. Intente más tarde', 'Mensaje', {timeOut: 2000});
    }
  }
  else {
    toastr.error('error', 'Mensaje', {timeOut: 2000});
    $('#gama').hide();
  }

});

$('#generateClear').on('click', function() {
  initialization_page();
});

$('#reload_quiz').on('click', function() {
  document.getElementById("delta").reset();
  $('#select_quest_one').prop('selectedIndex',0);
  $('#select_quest_calf').prop('selectedIndex',0);
    // alert('sd');
});

$('#register_quiz').on('click', function() {
      $val_select_hotel = validarSelect('select_quest_one');
      $val_select_calfic = validarSelect('select_quest_calf');
      $validation_a = validartextarea('comment_a');
      $validation_b = validartextarea('comment_b');
      $validation_c = validartextarea('comment_c');


      if ($val_select_hotel == true && $val_select_calfic == true && $validation_a == true && $validation_b == true && $validation_c == true) {
        $var_hotel_t1= $('#select_one').val();
        $var_date_t1= $('#calendar_fecha').val();
        $var_select_1= $('#select_quest_one').val();
        $var_select_2= $('#select_quest_calf').val();
        $var_coment_a= $('#comment_a').val();
        $var_coment_b= $('#comment_b').val();
        $var_coment_c= $('#comment_c').val();
        var _token = $('input[name="_token"]').val();
        // toastr.success('Completados los requerimientos', 'Mensaje', {timeOut: 2000});
        $.ajax({
             url: "/info_recargar_calif",
             type: "POST",
             data: {
               var_xa : $var_hotel_t1,
               var_xb : $var_date_t1,
               var_xc : $var_select_1,
               var_xd : $var_select_2,
               var_xe : $var_coment_a,
               var_xf : $var_coment_b,
               var_xg : $var_coment_c,
               _token : _token
             },
             success: function (data) {
               if (data == 1) {
                 toastr.success('Registro completado.!', 'Mensaje', {timeOut: 2000});
                 initialization_page();
               }
               else{
                 toastr.error('Intentar nuevamente..!', 'Mensaje', {timeOut: 2000});
               }
             },
             error: function (data) {
               console.log('Error:', data);
             }
        });
      }
      else {
        toastr.error('Completa los requerimientos', 'Mensaje', {timeOut: 2000});
      }

      // $var_coment_a= $('#comment_a').val().length; $validation_a = false;
      // $var_coment_b= $('#comment_b').val().length; $validation_b = false;
      // $var_coment_c= $('#comment_c').val().length; $validation_c = false;
      // if ($var_coment_a > 0) {
      //   if ($var_coment_a <=4) { $validation_a = false; $("#comment_a").parent().parent().attr("class","form-group has-error"); }
      //   else { $validation_a = true; $("#comment_a").parent().parent().attr("class","form-group has-default"); }
      // }
      // else {
      //   $validation_a = true;
      //   $("#comment_a").parent().parent().attr("class","form-group has-default");
      // }
      //
      // if ($var_coment_b > 0) {
      //   if ($var_coment_b <=4) { $validation_b = false; $("#comment_b").parent().parent().attr("class","form-group has-error"); }
      //   else { $validation_b = true; $("#comment_b").parent().parent().attr("class","form-group has-default"); }
      // }
      // else {
      //   $validation_b = true;
      //   $("#comment_b").parent().parent().attr("class","form-group has-default");
      // }
      //
      // if ($var_coment_c > 0) {
      //   if ($var_coment_c <=4) { $validation_c = false; $("#comment_c").parent().parent().attr("class","form-group has-error"); }
      //   else { $validation_c = true; $("#comment_c").parent().parent().attr("class","form-group has-default"); }
      // }
      // else {
      //   $validation_c = true;
      //   $("#comment_c").parent().parent().attr("class","form-group has-default");
      // }

});

function validartextarea(campo){
  $variable = $('#'+campo).val().length;
  if ($variable > 0) {
    if ($variable <=4) {
       $("#"+campo).parent().parent().attr("class","form-group has-error");
       return false;
    }
    else {
       $("#"+campo).parent().parent().attr("class","form-group has-default");
       return true;
   }
  }
  else {
    $("#"+campo).parent().parent().attr("class","form-group has-default");
    return true;
  }
}


//Funciones de validaciones
function validarSelecttwo(campo) {
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

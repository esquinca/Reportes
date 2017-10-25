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

$('#generateInfo').on('click', function() {
  $val_select_hotel = validarSelect('select_one');
  $val_date = validarInput('calendar_fecha');

  if ($val_select_hotel == true && $val_date == true) {
    var objData = $("#alpha").find("select,select2,textarea, input").serialize();
    $("#select_quest_one").find('option:selected').removeAttr("selected");
    $("#select_quest_calf").find('option:selected').removeAttr("selected");

    $.ajax({
         url: "/info_edit_register",
         type: "POST",
         data: objData,
         success: function (data) {
           if (data == '0') {
             toastr.error('NO HAY', 'Mensaje', {timeOut: 2000});
             $('#gama').hide();
             $("#delta")[0].reset();
           }
           if (data == '1') {

             //Ajax Anidado-----------------------------------------------------
             $.ajax({
                  url: "/info_search_register",
                  type: "POST",
                  data: objData,
                  success: function (data) {

                   var datos = JSON.parse(data);
                   var probabilidad = datos[0].ProbabilidadNumero;
                   var prob_num = '';
                   var prob_calificacion = datos[0].Calificacion;
                   var prob_cal = '';


                   if (probabilidad == '' || probabilidad == null) { prob_num = 0; } else { prob_num = probabilidad;}
                   if (prob_calificacion == "" || prob_calificacion == null){ prob_cal = 0; } else { prob_cal = prob_calificacion;}


                   $('#select_quest_one option[value='+prob_num+']').attr('selected','selected');
                   $('#select_quest_calf option[value='+prob_cal+']').attr('selected','selected');

                   $('#comment_a').val(datos[0].Comentario1);
                   $('#comment_b').val(datos[0].Comentario2);
                   $('#comment_c').val(datos[0].Comentario3);
                   $('#gama').show();

                  },
                  error: function (data) {
                    console.log('Error:', data);
                  }
             });

             //-----------------------------------------------------------------
             //toastr.success('HAY INFO', 'Mensaje', {timeOut: 2000});
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
    });
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

  // if ()
  // {
  //
  // }
  //


  // $val_date = validarInput('calendar_fecha');
  //
  // if ($val_select_hotel == true && $val_date == true) {
  //   var objData = $("#alpha").find("select,select2,textarea, input").serialize();
  // }
  // else {
  //   toastr.error('error', 'Mensaje', {timeOut: 2000});
  // }

  alert('sd');
});

function initialization_page(){
      $('#select_one').prop('selectedIndex',0);
      $("#select_one").select2({placeholder: "Elija"});
      $('#calendar_fecha').val('');
      $('#gama').hide();
      $("#delta")[0].reset();
}

//Funciones de validaciones
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

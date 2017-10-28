function initialization_page(){
      $('#select_one').prop('selectedIndex',0);
      $("#select_one").select2({placeholder: "Elija"});
      $('#select_two').empty();
      $('#select_two').append('<option value="" selected>Elija</option>');
      $("#select_two").select2({placeholder: "Elija"});
      $('#calendar_fecha').attr('disabled', true);
      $('#calendar_fecha').val('');
      $('#gama').hide();
      $("#delta")[0].reset();
      $('#check_a').hide();
      $('#check_b').hide();
      $('#check_c').hide();
}
function reset_quiz_current(){
  $('#question_tone').hide();
  $('#question_ttwo').hide();

  $('#comment_ab').hide();
  $('#comment_bc').hide();
  $('#comment_cd').hide();

  $('#question_tthree').hide();

  clearmultiselect('select_quest_two');
  clearmultiselect('select_quest_three');
  disabledmultiselect('select_quest_two');
  disabledmultiselect('select_quest_three');
  disabledinput('comment_a');
  disabledinput('comment_b');
  disabledinput('comment_c');
  disableselect('select_quest_calf');
}

function reset_quiz_all(){
  $('#select_one').attr('disabled', false);
  $('#select_two').attr('disabled', false);
  initialization_page();
  reset_quiz_current();
}


$(function() {
  initialization_page();
  reset_quiz_current();
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

/*-----------------------------------Parte 1-----------------------------------*/
//Funciones on change & on click
$('#select_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  $('#select_two').empty();
  $('#select_two').append('<option value="" selected>Elije</option>');
  $("#select_two").select2("val", "");
  $('#select_two').prop('selectedIndex',0);

  $('#calendar_fecha').attr('disabled', true);
  $('#calendar_fecha').datepicker('update', '');

  if (id != ''){
    $.ajax({
      type: "POST",
      url: "./searchencuestad",
      data: { xa_iden : id , _token : _token },
      success: function (data){
        $('#select_two').empty();
        $('#select_two').append('<option value="" selected>Elije</option>');
        $("#select_two").select2("val", "");
        $('#select_two').prop('selectedIndex',0);


        $.each(JSON.parse(data),function(index, objdata){
          $('#select_two').append('<option value="'+objdata.id_clientes+'">'+ objdata.email +'</option>');
        });
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    $('#select_two').empty();
    $('#select_two').append('<option value="" selected>Elije</option>');
    $("#select_two").select2("val", "");
    $('#select_two').prop('selectedIndex',0);
  }
});
$('#select_two').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  $('#calendar_fecha').attr('disabled', true);
  $('#calendar_fecha').datepicker('update', '');

  if (id != ''){
    $('#calendar_fecha').attr('disabled', false);
    $('#calendar_fecha').datepicker('update', '');
  }
  else {
    $('#calendar_fecha').attr('disabled', true);
    $('#calendar_fecha').datepicker('update', '');
  }
});
$('#generateInfo').on('click', function() {
  $val_select_hotel = validarSelect('select_one');
  $val_select_client = validarSelect('select_two');
  $val_date = validarInput('calendar_fecha');

  if ($val_select_hotel == true && $val_select_client == true &&  $val_date == true) {
    var objData = $("#alpha").find("select,select2,textarea, input").serialize();
    $.ajax({
         url: "/info_register_calf",
         type: "POST",
         data: objData,
         success: function (data) {
           if (data == '0') {
             $('#select_one').attr('disabled', true);
             $('#select_two').attr('disabled', true);
             $('#calendar_fecha').attr('disabled', true);
             $('#gama').show();
           }
           if (data == '1') {
             toastr.error('Esta fecha ya se encuentra registrada', 'Mensaje', {timeOut: 2000});
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
  reset_quiz_all();
});
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

/*-----------------------------------Parte 2-----------------------------------*/
$('#select_quest_one').on('change', function(e){
  var valor= $(this).val();
  if (valor != ''){
    if( valor >=8){
      reset_quiz_current();
      $('#comment_cd').show();
      enabledinput('comment_c');

      $('#question_tthree').show();
      enableselect('select_quest_calf');
      reset_input_validar_multiselect();
    }
    if( valor >=2 && valor <=7){
      reset_quiz_current();
      $('#question_tone').show();
      enablemultiselect('select_quest_two');


      $('#question_tthree').show();
      enableselect('select_quest_calf');
      reset_input_validar_multiselect();
    }
    if( valor == 1){
      reset_quiz_current();
      $('#question_ttwo').show();
      enablemultiselect('select_quest_three');

      $('#question_tthree').show();
      enableselect('select_quest_calf');
      reset_input_validar_multiselect();
    }
  }
  else {
    reset_quiz_current();
  }
});
function reset_input_validar_multiselect(){
  $("#check_a").val('');
  $("#check_b").val('');
  $("#check_c").val('');
}
function enableselect(campo){
  $('#'+campo).prop('selectedIndex',0);
  $('#'+campo).prop('disabled', false);
  $('#'+campo).parent().parent().attr("class", "form-group has-error");
}
function disableselect(campo){
  $('#'+campo).prop('selectedIndex',0);
  $('#'+campo).prop('disabled', true);
  $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function enabledinput(campo){
  $('#'+campo).val('');
  $('#'+campo).prop('disabled', false);
  $('#'+campo).show();
  $('#'+campo).parent().parent().attr("class", "form-group has-error");
}
function disabledinput(campo){
  $('#'+campo).val('');
  $('#'+campo).prop('disabled', true);
  $('#'+campo).hide();
  $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function enablemultiselect(campo) {
  $('#'+campo).multiselect('enable');
  $('#'+campo).parent().parent().parent().attr("class", "form-group has-error");
}
function disabledmultiselect(campo){
  $('#'+campo).multiselect('disable');
  $('#'+campo).parent().parent().parent().attr("class", "form-group has-default");
}
function clearmultiselect(campo){
  $('#'+campo).multiselect({
    buttonWidth: '100%',
    nonSelectedText: 'Elija uno o más',
    enableClickableOptGroups: true,
    enableCollapsibleOptGroups: false,
    enableFiltering: false,
    includeSelectAllOption: true,
    onSelectAll: function () {
                    $('#comment_ab').show(); enabledinput('comment_a');
                    $('#comment_bc').show(); enabledinput('comment_b');
                    $('#comment_cd').show(); enabledinput('comment_c');
                    $("#check_a").val('1');
                    $("#check_b").val('1');
                    $("#check_c").val('1');
                    $('#'+campo).parent().parent().parent().attr("class", "form-group has-default");
                },
    onDeselectAll: function () {
                    $('#comment_ab').hide(); disabledinput('comment_a');
                    $('#comment_bc').hide(); disabledinput('comment_b');
                    $('#comment_cd').hide(); disabledinput('comment_c');
                    $("#check_a").val('');
                    $("#check_b").val('');
                    $("#check_c").val('');
                    $('#'+campo).parent().parent().parent().attr("class", "form-group has-error");
    },
    onChange: function(option, checked, select) {
      var opselected = $(option).val();
      //alert(opselected);
      if(checked == true) {
            $('#'+campo).parent().parent().parent().attr("class", "form-group has-default");
            if (opselected == 'comment_xa') { $('#comment_ab').show(); enabledinput('comment_a');  $("#check_a").val('1'); }
            if (opselected == 'comment_xb') { $('#comment_bc').show(); enabledinput('comment_b');  $("#check_b").val('1'); }
            if (opselected == 'comment_xc') { $('#comment_cd').show(); enabledinput('comment_c');  $("#check_c").val('1'); }
      } else if(checked == false){
            if (opselected == 'comment_xa') { $('#comment_ab').hide(); disabledinput('comment_a'); $("#check_a").val(''); }
            if (opselected == 'comment_xb') { $('#comment_bc').hide(); disabledinput('comment_b'); $("#check_b").val(''); }
            if (opselected == 'comment_xc') { $('#comment_cd').hide(); disabledinput('comment_c'); $("#check_c").val(''); }
      }
    }
  });
  $('#'+campo).multiselect('deselectAll', false);
  $('#'+campo).multiselect('updateButtonText');
}
/*-----------------------------------Parte 3-----------------------------------*/
function validarespacioinput(campo){
  if( $("#"+campo).val().trim()==='' || $("#"+campo).val().length < 4 ) {
    //alert('d');
    $('#'+campo).parent().parent().attr("class", "form-group has-error");
    return false;
  }
  else {
    $("#"+campo).parent().parent().attr("class","form-group has-default");
    return true;
  }
}

$('#register_quiz').on('click', function() {
  $val_select_one = validarSelect('select_quest_one');

       $var_hotel = $('#select_one').val();
     $var_cliente = $('#select_two').val();
       $var_fecha = $('#calendar_fecha').val();

$var_probabilidad = $('#select_quest_one').val();
  $var_inconforme = $('#select_quest_two').val();
     $var_mejorar = $('#select_quest_three').val();


   $var_comercial = $('#comment_a').val();
   $var_proyectos = $('#comment_b').val();
     $var_soporte = $('#comment_c').val();
$var_calificacion = $('#select_quest_calf').val();
       var _token = $('input[name="_token"]').val();

  if ($val_select_one == true) {
    if( $("#select_quest_one").val() >= 8){
      toastr.error('Mensaje 3', 'Mensaje', {timeOut: 2000});

    }
    if( $("#select_quest_one").val() >= 2 && $("#select_quest_one").val() <= 7){
      toastr.error('Mensaje 2', 'Mensaje', {timeOut: 2000});
    }
    if( $("#select_quest_one").val() == 1){
      toastr.error('Mensaje 1', 'Mensaje', {timeOut: 2000});
      alert($var_mejorar);
      // $.ajax({
      //   type: "POST",
      //   url: "./quizencuestamanual",
      //   data: {
      //      var_xa : $var_hotel,
      //      var_xb : $var_cliente,
      //      var_xc : $var_fecha,
      //      var_xd : $var_probabilidad,
      //      var_xe : $var_inconforme,
      //      var_xf : $var_mejorar,
      //      var_xg : $var_comercial,
      //      var_xh : $var_proyectos,
      //      var_xi : $var_soporte,
      //      var_xj : $var_calificacion,
      //      _token : _token },
      //   success: function (data){
      //     toastr.success('Registro completado.!', 'Mensaje', {timeOut: 2000});
      //   },
      //   error: function (data) {
      //     console.log('Error:', data);
      //   }
      // });
    }


  }
  else{
    toastr.error('error', 'Mensaje', {timeOut: 2000});
  }
});


$("#reload_quiz").on("click", function () {
  $('#select_quest_one').prop('selectedIndex',0);
  reset_quiz_current();
});

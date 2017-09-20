$(function() {
  initialization_page();
  $(".select2").select2();
  reset_quiz_current();

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

function initialization_page(){
      $('#select_one').prop('selectedIndex',0);
      $('#calendar_fecha').attr('disabled', true);

      $('#select_two').empty();
      $('#select_two').append('<option value="" selected>Elije</option>');
      $('#gama').hide();
}


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

$('#generateInfo').on('click', function() {
  $val_select_hotel = validarSelect('select_one');
  $val_select_client = validarSelect('select_two');
  $val_date = validarInput('calendar_fecha');

  if ($val_select_hotel == true && $val_select_client == true &&  $val_date == true) {
    $('#select_one').attr('disabled', true);
    $('#select_two').attr('disabled', true);
    $('#calendar_fecha').attr('disabled', true);
    //toastr.success('Bien', 'Mensaje', {timeOut: 2000});
    $('#gama').show();

  }else{
    toastr.error('error', 'Mensaje', {timeOut: 2000});
    $('#gama').hide();
  }

});

$('#generateClear').on('click', function() {
  initialization_page();
  $("#select_one").select2("val", "");
  $('#select_two').empty();
  $('#select_two').append('<option value="" selected>Elije</option>');
  $("#select_two").select2("val", "");
  $('#select_two').prop('selectedIndex',0);

  $('#calendar_fecha').attr('disabled', true);
  $('#calendar_fecha').datepicker('update', '');

  $('#select_one').attr('disabled', false);
  $('#select_two').attr('disabled', false);
  $('#gama').hide();
  $("#delta")[0].reset();
  reset_quiz_current();
});

function reset_quiz_current(){
  $('.question_tone').hide();
  $('.question_ttwo').hide();
  $('.question_tthree').hide();
  $('.comment_ab').hide();
  $('.comment_bc').hide();
  $('.comment_cd').hide();
  clearmultiselect('select_quest_two');
  clearmultiselect('select_quest_three');
  disabledmultiselect('select_quest_two');
  disabledmultiselect('select_quest_three');
  disabledinput('comment_a');
  disabledinput('comment_b');
  disabledinput('comment_c');
  disableselect('select_quest_calf');
}
$('#select_quest_one').on('change', function(e){
  var valor= $(this).val();
  if (valor != ''){
    if( valor == 'cien'){
      reset_quiz_current();
      $('.comment_cd').show(); enabledinput('comment_c');
      $('.question_tthree').show(); enableselect('select_quest_calf');
    }
    if( valor == 'cero'){
      reset_quiz_current();
      $('.question_tone').show();
      enablemultiselect('select_quest_two');
      $('.question_tthree').show();  enableselect('select_quest_calf');
    }
    if( valor == 'ninguno'){
      reset_quiz_current();
      $('.question_ttwo').show();
      enablemultiselect('select_quest_three');
      $('.question_tthree').show();  enableselect('select_quest_calf');
    }
  }
  else {
    reset_quiz_current();
  }
});

function enableselect(campo){
  $('#'+campo).prop('selectedIndex',0);
  $('#'+campo).prop('disabled', false);
}
function disableselect(campo){
  $('#'+campo).prop('selectedIndex',0);
  $('#'+campo).prop('disabled', true);
}

function enablemultiselect(campo) {
  $('#'+campo).multiselect('enable');
}
function disabledmultiselect(campo){
  $('#'+campo).multiselect('disable');
}
function disabledinput(campo){
  $('#'+campo).val('');
  $('#'+campo).prop('disabled', true);
}
function enabledinput(campo){
  $('#'+campo).val('');
  $('#'+campo).prop('disabled', false);
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
                    $('.comment_ab').show(); enabledinput('comment_a');
                    $('.comment_bc').show(); enabledinput('comment_b');
                    $('.comment_cd').show(); enabledinput('comment_c');
                },
    onDeselectAll: function () {
                    $('.comment_ab').hide(); disabledinput('comment_a');
                    $('.comment_bc').hide(); disabledinput('comment_b');
                    $('.comment_cd').hide(); disabledinput('comment_c');
    },
    onChange: function(option, checked, select) {
      var opselected = $(option).val();
      //alert(opselected);
      if(checked == true) {
            if (opselected == 'comment_xa') { $('.comment_ab').show(); enabledinput('comment_a'); }
            if (opselected == 'comment_xb') { $('.comment_bc').show(); enabledinput('comment_b'); }
            if (opselected == 'comment_xc') { $('.comment_cd').show(); enabledinput('comment_c'); }
      } else if(checked == false){
            if (opselected == 'comment_xa') { $('.comment_ab').hide(); disabledinput('comment_a'); }
            if (opselected == 'comment_xb') { $('.comment_bc').hide(); disabledinput('comment_b'); }
            if (opselected == 'comment_xc') { $('.comment_cd').hide(); disabledinput('comment_c'); }
      }
    }
  });
  $('#'+campo).multiselect('deselectAll', false);
  $('#'+campo).multiselect('updateButtonText');
}

$('#register_quiz').on('click', function() {
  $val_select_one = validarSelect('select_quest_one');

  if ($val_select_one == true) {
    if () {

    }
  }
  else{
    toastr.error('error', 'Mensaje', {timeOut: 2000});
  }
});




$('#reload_quiz').on('click', function() {
  enableselect('select_quest_one');
  reset_quiz_current();
});

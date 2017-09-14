$(function() {
  initialization_page();
  $(".select2").select2();
  $('#calendar_fecha').datepicker({
    language: 'es',
    defaultDate: '',
    format: "mm-yyyy",
    viewMode: "months",
    minViewMode: "months",
    autoclose: true
  });


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

function reinicioproy(){
  $('#xa_encuesta')[0].reset();
  $('#selecthotelofclient').attr("disabled", false);
  $('#xqa').val('na');
  $("#selecthotelofclient").parent().parent().attr("class","form-group has-default");
}

function show_element(campo){
  $('#'+campo).show();
}
function hide_element(campo){
  $('#'+campo).hide();
}
function reset_form(campo) {
  $('#'+campo)[0].reset();
}
function initialization_page() {
  hide_element('xy_quiz');
  reset_form('xa_encuesta');
  reset_form('delta');

  hide_element('answer_two');
  hide_element('answer_three');
  hide_element('answer_four');
  hide_element('answer_five');

  $('#example-1to10').barrating({ theme: 'bars-1to10' });
}

function inicializacionhidden() {
  $("#xy_quiz").hide();
  $("#answer_two").hide();
  $("#answer_three").hide();
  $("#answer_four").hide();
  $("#answer_five").hide();
  $('#comment_a').parent().parent().hide();
  $('#comment_b').parent().parent().hide();
  $('#comment_c').parent().parent().hide();
}


$('#generatequizquest').on('click', function(){
  $val_select = validarSelect('selecthotelofclient');
  $val_date = validarInput('calendar_fecha');

  if ($val_select == true && $val_date == true) {
    toastr.success('algo lul', 'Mensaje', {timeOut: 2000});
    hide_element('generatequizquest');
  }else{
    toastr.error('error lul', 'Mensaje', {timeOut: 2000});
  }

});

$('#clearquizquest').on('click', function(){
  show_element('generatequizquest');
});


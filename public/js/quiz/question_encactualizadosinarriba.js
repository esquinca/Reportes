/**................... Boton checked  .......................................**/
$(function () {
  initialization_page();
})

function initialization_page(){
  reset_select_pral('select_one');
  reset_data_current();
  reset_input_validar_multiselect();
}
function reset_select_pral(campo){
  $('#'+campo).prop('selectedIndex',0);
}
function reset_data_current(){
  //
  reset_hide_question('select_question_inconforme');
  reset_hide_question('select_question_mejorar');
  reset_hide_question_two('select_question_add');

  reset_hide_comment('comment_a');
  reset_hide_comment('comment_b');
  reset_hide_comment('comment_c');
  reset_select_pral('select_evaluation');
  //
  // clearmultiselectthreeoption('select_question_inconforme');
  // clearmultiselectthreeoption('select_question_mejorar');
}
function show_element(campo){
  $('#'+campo).show();
}
function hide_element(campo){
  $('#'+campo).hide();
}
function reset_hide_question_two(campo){
  // $('#'+campo).prop('selectedIndex',0);
  // $('#'+campo).multiselect('deselectAll', false);
  // $('#'+campo).multiselect('updateButtonText');
  clearmultiselecttwooption(campo);
  $('#'+campo).parent().parent().hide();
  // $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function reset_hide_question(campo){
  // $('#'+campo).prop('selectedIndex',0);
  // $('#'+campo).multiselect('deselectAll', false);
  // $('#'+campo).multiselect('updateButtonText');
  clearmultiselectthreeoption(campo);
  $('#'+campo).parent().parent().hide();
  // $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function reset_input_validar_multiselect(){
  $("#check_a").val('');
  $("#check_b").val('');
  $("#check_c").val('');
}
function reset_show_question(campo){
  $('#'+campo).parent().parent().show();
  $('#'+campo).parent().parent().attr("class", "form-group has-default");
}
function reset_hide_comment(campo){
  $('#'+campo).val('');
  $('#'+campo).parent().parent().hide();
  $('#'+campo).parent().parent().parent().attr("class", "form-group has-default");
}
function reset_show_comment(campo){
  $('#'+campo).val('');
  $('#'+campo).parent().parent().show();
  $('#'+campo).parent().parent().parent().attr("class", "form-group has-default");
}

$('#select_one').on('change', function(e){
  var valor= $(this).val();
  if (valor != ''){
    if( valor == 1){
      reset_data_current();
      reset_input_validar_multiselect();
      reset_show_question('select_question_inconforme');
    }
    if( valor >=2 && valor <=7){
      reset_data_current();
      reset_input_validar_multiselect();
      reset_show_question('select_question_mejorar');
    }
    if( valor >=8){
      reset_data_current();
      reset_input_validar_multiselect();
      reset_show_question('select_question_add');
      reset_show_comment('comment_c'); $("#check_c").val('1');
    }
  }
  else {
    reset_data_current();
    reset_input_validar_multiselect();
  }
});
function clearmultiselecttwooption(campo){
  $('#'+campo).multiselect({
    buttonWidth: '100%',
    nonSelectedText: 'Elija uno o más',
    enableClickableOptGroups: true,
    enableCollapsibleOptGroups: false,
    enableFiltering: false,
    includeSelectAllOption: true,
    onSelectAll: function () {
                    reset_show_comment('comment_a');
                    reset_show_comment('comment_b');
                    $("#check_a").val('1');
                    $("#check_b").val('1');
                },
    onDeselectAll: function () {
                    reset_hide_comment('comment_a');
                    reset_hide_comment('comment_b');
                    $("#check_a").val('');
                    $("#check_b").val('');
    },
    onChange: function(option, checked, select) {
      var opselected = $(option).val();
      if(checked == true) {
            if (opselected == 'comment_xa') { reset_show_comment('comment_a'); $("#check_a").val('1'); }
            if (opselected == 'comment_xb') { reset_show_comment('comment_b'); $("#check_b").val('1'); }
      } else if(checked == false){
            if (opselected == 'comment_xa') { reset_hide_comment('comment_a'); $("#check_a").val(''); }
            if (opselected == 'comment_xb') { reset_hide_comment('comment_b'); $("#check_b").val(''); }
      }
    }
  });
  $('#'+campo).multiselect('deselectAll', false);
  $('#'+campo).multiselect('updateButtonText');
}
function clearmultiselectthreeoption(campo){
  $('#'+campo).multiselect({
    buttonWidth: '100%',
    nonSelectedText: 'Elija uno o más',
    enableClickableOptGroups: true,
    enableCollapsibleOptGroups: false,
    enableFiltering: false,
    includeSelectAllOption: true,
    onSelectAll: function () {
                    reset_show_comment('comment_a');
                    reset_show_comment('comment_b');
                    reset_show_comment('comment_c');
                    $("#check_a").val('1');
                    $("#check_b").val('1');
                    $("#check_c").val('1');
                },
    onDeselectAll: function () {
                    reset_hide_comment('comment_a');
                    reset_hide_comment('comment_b');
                    reset_hide_comment('comment_c');
                    $("#check_a").val('');
                    $("#check_b").val('');
                    $("#check_c").val('');
    },
    onChange: function(option, checked, select) {
      var opselected = $(option).val();
      if(checked == true) {
            if (opselected == 'comment_xa') { reset_show_comment('comment_a'); $("#check_a").val('1'); }
            if (opselected == 'comment_xb') { reset_show_comment('comment_b'); $("#check_b").val('1'); }
            if (opselected == 'comment_xc') { reset_show_comment('comment_c'); $("#check_c").val('1'); }
      } else if(checked == false){
            if (opselected == 'comment_xa') { reset_hide_comment('comment_a'); $("#check_a").val(''); }
            if (opselected == 'comment_xb') { reset_hide_comment('comment_b'); $("#check_b").val(''); }
            if (opselected == 'comment_xc') { reset_hide_comment('comment_c'); $("#check_c").val(''); }
      }
    }
  });
  $('#'+campo).multiselect('deselectAll', false);
  $('#'+campo).multiselect('updateButtonText');
}
//Funciones de validaciones.....................................................
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

$("#approvalInfo").click(function(event) {
  $eval_one = validarSelect('select_one');

  if($eval_one == true) {
    $var_probd = $('#select_one').val();
    $var_calif = $('#select_evaluation').val();

    $valor_com_a = $('#comment_a').val();
    $valor_com_b = $('#comment_b').val();
    $valor_com_c = $('#comment_c').val();
    $permiso_obligar_a = $('#check_a').val();
    $permiso_obligar_b = $('#check_b').val();
    $permiso_obligar_c = $('#check_c').val();

    if( $var_probd >=8){
      if ($permiso_obligar_a == '1' && $permiso_obligar_b == '') {
        $obligatorio_a = validarespacioinput('comment_c');
        $obligatorio_b = validarSelect('select_evaluation');
        $obligatorio_adicional_a = validarespacioinput('comment_a');
        if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_adicional_a == true) {
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '' && $permiso_obligar_b == '1') {
        $obligatorio_a = validarespacioinput('comment_c');
        $obligatorio_b = validarSelect('select_evaluation');
        $obligatorio_adicional_b = validarespacioinput('comment_b');
        if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_adicional_b == true) {
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '1' && $permiso_obligar_b == '1') {
        $obligatorio_a = validarespacioinput('comment_c');
        $obligatorio_b = validarSelect('select_evaluation');
        $obligatorio_adicional_a = validarespacioinput('comment_a');
        $obligatorio_adicional_b = validarespacioinput('comment_b');
        if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_adicional_a == true && $obligatorio_adicional_b == true) {
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '' && $permiso_obligar_b == '') {
        $obligatorio_a = validarespacioinput('comment_c');
        $obligatorio_b = validarSelect('select_evaluation');
        if ($obligatorio_a == true && $obligatorio_b == true) {
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
    }
    else{
      if ($permiso_obligar_a == '' && $permiso_obligar_b == '' && $permiso_obligar_c == '') {
          toastr.error('Necesitamos un comentario como mínimo', 'Mensaje', {timeOut: 2000});
      }
      if ($permiso_obligar_a == '1'&& $permiso_obligar_b == '' && $permiso_obligar_c == '') {
        $obligatorio_a = validarespacioinput('comment_a');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_a == true && $obligatorio_d == true ) {
          // $.ajax({
          //   type: "POST",
          //   url: "./quizencuestamanual",
          //   data: {
          //     var_xa : $var_hotel,
          //     var_xb : $var_cliente,
          //     var_xc : $var_fecha,
          //     var_xd : $var_recomienda,//1-10
          //     var_xe : $var_ninguna,
          //     var_xf : $var_cero,
          //     var_xg : $var_adicional,
          //     var_xh : $var_com_a,
          //     var_xi : $var_com_b,
          //     var_xj : $var_com_c,
          //     var_xk : $var_calif,
          //     var_xl : $var_checka,
          //     var_xm : $var_checkb,
          //     var_xn : $var_checkc,
          //     _token : _token },
          //     success: function (data){
          //       if (data == 1) {
          //         toastr.success('Registro completado.!', 'Mensaje', {timeOut: 2000});
          //         reset_quiz_all();
          //       }
          //       else{
          //         toastr.error('Intentar nuevamente..!', 'Mensaje', {timeOut: 2000});
          //       }
          //     },
          //     error: function (data) {
          //       console.log('Error:', data);
          //     }
          //   });
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '' && $permiso_obligar_b == '1'&& $permiso_obligar_c == '') {
        $obligatorio_b = validarespacioinput('comment_b');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_b == true && $obligatorio_d == true ) {
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '' && $permiso_obligar_b == '' && $permiso_obligar_c == '1'){
        $obligatorio_c = validarespacioinput('comment_c');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_c == true && $obligatorio_d == true ) {
        }
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '1'&& $permiso_obligar_b == '1'&& $permiso_obligar_c == '') {
        $obligatorio_a = validarespacioinput('comment_a');
        $obligatorio_b = validarespacioinput('comment_b');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_a == true && $obligatorio_b == true && $obligatorio_d == true ) {}
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '1'&& $permiso_obligar_b == '' && $permiso_obligar_c == '1'){
        $obligatorio_a = validarespacioinput('comment_a');
        $obligatorio_c = validarespacioinput('comment_c');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_a == true && $obligatorio_c == true && $obligatorio_d == true ) {}
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '' && $permiso_obligar_b == '1'&& $permiso_obligar_c == '1'){
        $obligatorio_b = validarespacioinput('comment_b');
        $obligatorio_c = validarespacioinput('comment_c');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_b == true && $obligatorio_c == true && $obligatorio_d == true ) {}
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
      if ($permiso_obligar_a == '1'&& $permiso_obligar_b == '1'&& $permiso_obligar_c == '1'){
        $obligatorio_a = validarespacioinput('comment_a');
        $obligatorio_b = validarespacioinput('comment_b');
        $obligatorio_c = validarespacioinput('comment_c');
        $obligatorio_d = validarSelect('select_evaluation');
        if ($obligatorio_a == true && $obligatorio_b == true  && $obligatorio_c == true && $obligatorio_d == true ) {}
        else { toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000}); }
      }
    }

    // if( $var_probd == 1){}
    // if( $var_probd >=2 && $var_probd <=7){ }
  }
  else {
    toastr.error('Completa los requerimientos.', 'Mensaje', {timeOut: 2000});
    reset_data_current();
  }
});

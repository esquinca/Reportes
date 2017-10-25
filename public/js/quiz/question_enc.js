/**................... Boton checked  .......................................**/
$(function () {
  style_checkbox();
  initialization_page();
})
  function style_checkbox(){
    $('.button-checkbox').each(function () {
        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };
        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });
        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');
            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");
            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);
            // Update the button's color
            if (isChecked) {
                selectallmultiselect('selecthotelofclient');
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                clearmultiselect('selecthotelofclient');
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }
        // Initialization
        function init() {
            updateDisplay();
            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
  }
/**................... Funciones multiselect ...............................**/
  function selectallmultiselect(campo) {
    $('#'+campo).multiselect('selectAll', false);
    $('#'+campo).multiselect('updateButtonText');
    var za = $('#'+campo).val();
    $('#xqb').val(za);
  }
  function enablemultiselect(campo) {
    $('#'+campo).multiselect('enable');
  }
  function disabledmultiselect(campo){
    $('#'+campo).multiselect('disable');
  }
  function clearmultiselect(campo){
    $('#'+campo).multiselect({nonSelectedText: 'Elija uno o más'});
    $('#'+campo).multiselect('deselectAll', false);
    $('#'+campo).multiselect('updateButtonText');
    $('#xqb').val('');
  }
  function validate_multiselect(campo) {
    if (campo != '') {
      select=$('#'+campo).val();
      if( select == null || select == 0 ) {
         return false;
      }
      else {
        return true;
      }
    };
  }
/**................... Funciones style checkall ............................**/
  function reset_style_checkall(){
    $(".button-checkbox input[type='checkbox']").prop( "checked", false );// Es lo mismo a $("#allselect").prop( "checked", false );
    $(".button-checkbox button").removeClass('btn-success active');
    $(".button-checkbox button").addClass('btn-default');

    $(".button-checkbox button i").removeClass('state-icon glyphicon glyphicon-check');
    $(".button-checkbox button i").addClass('state-icon glyphicon glyphicon-unchecked');
  }
  function enable_style_checkall(){
    $(".button-checkbox button[type='button']").prop( "disabled", false );
    $(".button-checkbox input[type='checkbox']").prop( "disabled", false );
  }
  function disable_style_checkall(){
    $(".button-checkbox button[type='button']").prop( "disabled", true );
    $(".button-checkbox input[type='checkbox']").prop( "disabled", true );
  }
/**................... Habilitar y deshabilitar elementos ...................**/
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

    clearmultiselect('selecthotelofclient');
    reset_style_checkall();
  }
/**................... Botones Formulario ...................................**/
  $('#selecthotelofclient').on('change', function(e){
    var id= $(this).val();
    if (id != ''){
      $('#xqb').val(id);
    }
    else {
        $('#xqb').val('');
    }
  });
  $("#generatequizquest").click(function(event) {
    var rec_xa = $('#xqb').val();
    var rec_xb = $('#selecthotelofclient').val();
    var val_sel = validate_multiselect('selecthotelofclient');

    if( val_sel == false){
      toastr.error('Selecciona uno o más hoteles a calificar. !!', 'Mensaje', {timeOut: 2000});
    }
    else{
      disabledmultiselect('selecthotelofclient');
      disable_style_checkall();
      hide_element('generatequizquest');
      toastr.success('Pasamos la seleccion. !!', 'Mensaje', {timeOut: 2000});

      show_element('xy_quiz');
    }
  });
  $("#clearquizquest").click(function(event) {
    clearmultiselect('selecthotelofclient');
    reset_style_checkall();
    enablemultiselect('selecthotelofclient');
    enable_style_checkall();
    show_element('generatequizquest');

    initialization_page();

  });
/**................... Funcion radio 1era Pregunta ..........................**/
  function hide_comment(campo) {
    $('#'+campo).parent().parent().hide(100);
    $('#'+campo).val('');
  }
  function show_comment(campo) {
    $('#'+campo).parent().parent().show(100);
    $('#'+campo).val('');
  }
  $('#answer_one input[name="radio"]').on('click', function() {
    if($('input:radio[name=radio]:checked').val() == "100"){
      $(".evaluation").hide();
      $("#answer_four").show()
      $("#answer_five").show();

      hide_comment('comment_a');
      hide_comment('comment_b');
      show_comment('comment_c');
    }
    if($('input:radio[name=radio]:checked').val() == "0"){
      $(".evaluation").hide();
      $('#xy_quiz input:checkbox').prop('checked', false);

      show_element('answer_two');
      show_element('answer_five');

      hide_comment('comment_a');
      hide_comment('comment_b');
      hide_comment('comment_c');
    }
    if($('input:radio[name=radio]:checked').val() == "ninguna"){
      $(".evaluation").hide();
      $('#xy_quiz input:checkbox').prop('checked', false);

      show_element('answer_three');
      show_element('answer_five');

      hide_comment('comment_a');
      hide_comment('comment_b');
      hide_comment('comment_c');
    }
  });
  function validarcheck(campo) {
    if($('input[name='+campo+']').is(':checked')){
      $("#"+campo).parent().parent().attr("class","form-group has-default");
      return true;
    }
    else {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
  }

/**................... Validar checkbox en la encuesta .......................*/
  $('input[type="checkbox"]').click(function() {
      var id = $(this).prop('id');
      var status = $(this).is(':checked');

      selected_check(id, status, radiob2, comment_a);
      selected_check(id, status, radiob3, comment_b);
      selected_check(id, status, radiob1, comment_c);

      selected_check(id, status, radioc2, comment_a);
      selected_check(id, status, radioc3, comment_b);
      selected_check(id, status, radioc1, comment_c);
  });
  function selected_check(identificador, estado, idverificar, campoarea) {
   if( identificador == idverificar.id && estado == true){
       $('#answer_four').show(300);
       $('#'+campoarea.id).parent().parent().show(300);
       $('#'+campoarea.id).val('');
       //alert('true mostrar');
   }
   if( identificador == idverificar.id && estado == false){
       $('#'+campoarea.id).parent().parent().hide(100);
       $('#'+campoarea.id).val('');
       //alert('false ocultar');
   }
  }
/**................... Funcion de botones de la encuesta .....................*/
  $("#reload_quiz").click(function(event) {
    reset_form('delta');

    hide_element('answer_two');
    hide_element('answer_three');
    hide_element('answer_four');
    hide_element('answer_five');

    hide_comment('comment_a');
    hide_comment('comment_b');
    hide_comment('comment_c');

  });
  $("#register_quiz").click(function(event) {
   if ( $('#xqb').val() != ''  ) {
    if ($('input[name="radio"]').is(':checked')) {
        if($('input:radio[name=radio]:checked').val() == "100") {
          var count_todos_proyec_one = $("#comment_c").val().length;
          if (count_todos_proyec_one >=4) {
            $("#delta").submit();

            // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
            // $.ajax({
            //       url: "/survey_form",
            //       type: "POST",
            //       data: objData,
            //       success: function (data) {
            //         toastr.success('Se guardo encuesta!!', 'Mensaje', {timeOut: 2000});
            //         setTimeout('document.location.reload()',2000);
            //       },
            //       error: function (data) {
            //         console.log('Error:', data);
            //       }
            // });
          }
        }

        if($('input:radio[name=radio]:checked').val() == "0"){
          var a2= validarcheck('radiob2');
          var a3= validarcheck('radiob3');
          var a1= validarcheck('radiob1');

          if (a1 == false && a2 == false &&  a3 == false ) {
            toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
          }
          else {
            /**.............................................................**/
            if (a1 == true && a2 == false &&  a3 == false ) {
              if ($.trim($("#comment_c").val())) {
                var count_c = $("#comment_c").val().length;
                if (count_c >=4) {
                  $("#delta").submit();

                  // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                  // $.ajax({
                  //      url: "/survey_form",
                  //      type: "POST",
                  //      data: objData,
                  //      success: function (data) {
                  //        console.log('success:', data);
                  //      },
                  //      error: function (data) {
                  //        console.log('Error:', data);
                  //      }
                  // });
                }
              }
              else {
                toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 2000});
              }
              $("#radiob2").parent().parent().attr("class","form-group has-default");
              $("#radiob3").parent().parent().attr("class","form-group has-default");
            }

            if (a1 == false && a2 == true &&  a3 == false ) {
              if ($.trim($("#comment_a").val())) {
                var count_a = $("#comment_a").val().length;
                if (count_a >=4) {
                  $("#delta").submit();
                  // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                  // $.ajax({
                  //      url: "/survey_form",
                  //      type: "POST",
                  //      data: objData,
                  //      success: function (data) {
                  //        console.log('success:', data);
                  //      },
                  //      error: function (data) {
                  //        console.log('Error:', data);
                  //      }
                  //  });
                }
              }
              else {
                toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
              }
              $("#radiob1").parent().parent().attr("class","form-group has-default");
              $("#radiob3").parent().parent().attr("class","form-group has-default");
            }

            if (a1 == false && a2 == false &&  a3 == true ) {
              if ($.trim($("#comment_b").val())) {
                var count_a = $("#comment_b").val().length;
                if (count_a >=4) {
                  $("#delta").submit();
                  // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                  // $.ajax({
                  //      url: "/survey_form",
                  //      type: "POST",
                  //      data: objData,
                  //      success: function (data) {
                  //        console.log('success:', data);
                  //      },
                  //      error: function (data) {
                  //        console.log('Error:', data);
                  //      }
                  // });
                }
              }
              else {
                toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
              }
              $("#radiob1").parent().parent().attr("class","form-group has-default");
              $("#radiob2").parent().parent().attr("class","form-group has-default");
            }
            /**.............................................................**/
            if (a1 == true && a2 == true &&  a3 == false ) {
              var val_a1 = false;
              var val_a2 = false;
              if ($.trim($("#comment_c").val())) {
                var count_ac1 = $("#comment_c").val().length;
                if (count_ac1 >=4) {
                  val_a1=true;
                }
              }
              else {
                val_a1 = false;
              }

              if ($.trim($("#comment_a").val())) {
                var count_aa1 = $("#comment_a").val().length;
                if (count_aa1 >=4) {
                  val_a2=true;
                }
              }
              else {
                val_a2 = false;
              }

              if (val_a1 == false || val_a2== false) {
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (val_a1 == true && val_a2== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                // });
              }
              $("#radiob3").parent().parent().attr("class","form-group has-default");
            }

            if (a1 == true && a2 == false &&  a3 == true ) {
              var val_b1 = false;
              var val_b2 = false;
              if ($.trim($("#comment_c").val())) {
                var count_bc1 = $("#comment_c").val().length;
                if (count_bc1 >=4) {
                  val_b1=true;
                }
              }
              else {
                val_b1 = false;
              }
              if ($.trim($("#comment_b").val())) {
                var count_ba1 = $("#comment_b").val().length;
                if (count_ba1 >=4) {
                  val_b2=true;
                }
              }
              else {
                val_b2 = false;
              }
              if (val_b1 == false || val_b2== false) {
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (val_b1 == true && val_b2== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                // });
              }
              $("#radiob2").parent().parent().attr("class","form-group has-default");
            }

            if (a1 == false && a2 == true &&  a3 == true ) {
              var val_c1 = false;
              var val_c2 = false;
              if ($.trim($("#comment_a").val())) {
                var count_cc1 = $("#comment_a").val().length;
                if (count_cc1 >=4) {
                  val_c1=true;
                }
              }
              else {
                val_c1 = false;
              }

              if ($.trim($("#comment_b").val())) {
                var count_ca1 = $("#comment_b").val().length;
                if (count_ca1 >=4) {
                  val_c2=true;
                }
              }
              else {
                val_c2 = false;
              }

              if (val_c1 == false || val_c2== false) {
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (val_c1 == true && val_c2== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                // });
              }
              $("#radiob1").parent().parent().attr("class","form-group has-default");
            }
            /**.............................................................**/
            if (a1 == true && a2 == true &&  a3 == true ) {
              var val_com_sop= false;
              var val_com_com= false;
              var val_com_pro= false;
              //soporte
              if ($.trim($("#comment_c").val())) {
                var count_comsop1 = $("#comment_c").val().length;
                if (count_comsop1 >=4) {
                  val_com_sop=true;
                }
              }
              else {
                val_com_sop = false;
              }
              //comercial
              if ($.trim($("#comment_a").val())) {
                var count_comcomercial = $("#comment_a").val().length;
                if (count_comcomercial >=4) {
                  val_com_com=true;
                }
              }
              else {
                val_com_com = false;
              }
              //proyectos e instalaciones
              if ($.trim($("#comment_b").val())) {
                var count_comproyect = $("#comment_b").val().length;
                if (count_comproyect >=4) {
                  val_com_pro=true;
                }
              }
              else {
                val_com_pro = false;
              }
              // validar si alguno no concuerda.
              if (val_com_sop == false || val_com_com== false || val_com_pro== false) {
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (val_com_sop == true && val_com_com== true && val_com_pro== true) {
                /*
                  Enviar por ajax aqui.... xD
                */
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                // });
                //toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
              }
              $("#radiob1").parent().parent().attr("class","form-group has-default");
              $("#radiob2").parent().parent().attr("class","form-group has-default");
              $("#radiob3").parent().parent().attr("class","form-group has-default");
            }
            /**.............................................................**/
          }
        }

        if($('input:radio[name=radio]:checked').val() == "ninguna"){
          var ning_1= validarcheck('radioc1');
          var ning_2= validarcheck('radioc2');
          var ning_3= validarcheck('radioc3');
          if (ning_1 == false && ning_2 == false &&  ning_3 == false ) {
            toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
          }
          else{
            if (ning_1 == true && ning_2 == false &&  ning_3 == false ) {
              if ($.trim($("#comment_c").val())) {
                var count_sop_one = $("#comment_c").val().length;
                if (count_sop_one >=4) {
                  $("#delta").submit();
                  // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                  // $.ajax({
                  //      url: "/survey_form",
                  //      type: "POST",
                  //      data: objData,
                  //      success: function (data) {
                  //        console.log('success:', data);
                  //      },
                  //      error: function (data) {
                  //        console.log('Error:', data);
                  //      }
                  //  });
                }
              }
              else {
                toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
              }
              $("#radioc2").parent().parent().attr("class","form-group has-default");
              $("#radioc3").parent().parent().attr("class","form-group has-default");
            }
            if (ning_1 == false && ning_2 == true &&  ning_3 == false ) {
              if ($.trim($("#comment_a").val())) {
                var count_com_one = $("#comment_a").val().length;
                if (count_com_one >=4) {
                  $("#delta").submit();
                  //var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                  // $.ajax({
                  //      url: "/survey_form",
                  //      type: "POST",
                  //      data: objData,
                  //      success: function (data) {
                  //        console.log('success:', data);
                  //      },
                  //      error: function (data) {
                  //        console.log('Error:', data);
                  //      }
                  //  });
                }
              }
              else {
                toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
              }
              $("#radioc1").parent().parent().attr("class","form-group has-default");
              $("#radioc3").parent().parent().attr("class","form-group has-default");
            }
            if (ning_1 == false && ning_2 == false &&  ning_3 == true ) {
              if ($.trim($("#comment_b").val())) {
                var count_proy_one = $("#comment_b").val().length;
                if (count_proy_one >=4) {
                  $("#delta").submit();
                  // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                  // $.ajax({
                  //      url: "/survey_form",
                  //      type: "POST",
                  //      data: objData,
                  //      success: function (data) {
                  //        console.log('success:', data);
                  //      },
                  //      error: function (data) {
                  //        console.log('Error:', data);
                  //      }
                  //  });
                }
              }
              else {
                toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
              }
              $("#radioc1").parent().parent().attr("class","form-group has-default");
              $("#radioc2").parent().parent().attr("class","form-group has-default");
            }
            // -----------------------------------------------------------------//
            if (ning_1 == true && ning_2 == true &&  ning_3 == false ) {
              var ninguna_vala_a= false;
              var ninguna_vala_b= false;
              /*Soporte*/
              if ($.trim($("#comment_c").val())) {
                var count_ning_one = $("#comment_c").val().length;
                if (count_ning_one >=4) {
                  ninguna_vala_a= true;
                }
              }
              else {
                ninguna_vala_a= false;
              }
              /*Comercial*/
              if ($.trim($("#comment_a").val())) {
                var count_ning_two = $("#comment_a").val().length;
                if (count_ning_two >=4) {
                  ninguna_vala_b= true;
                }
              }
              else {
                ninguna_vala_b= false;
              }
              /**********/
              if (ninguna_vala_a == false || ninguna_vala_b== false){
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (ninguna_vala_a == true && ninguna_vala_b== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                //  });
              }
              $("#radioc1").parent().parent().attr("class","form-group has-default");
              $("#radioc2").parent().parent().attr("class","form-group has-default");
              $("#radioc3").parent().parent().attr("class","form-group has-default");
            }
            if (ning_1 == true && ning_2 == false &&  ning_3 == true ) {
              var ninguna_valb_a= false;
              var ninguna_valb_b= false;
              /*Soporte*/
              if ($.trim($("#comment_c").val())) {
                var count_ning_sop_two = $("#comment_c").val().length;
                if (count_ning_sop_two >=4) {
                  ninguna_valb_a= true;
                }
              }
              else {
                ninguna_valb_a= false;
              }
              /*Proyectos*/
              if ($.trim($("#comment_b").val())) {
                var count_ning_proyec_two = $("#comment_b").val().length;
                if (count_ning_proyec_two >=4) {
                  ninguna_valb_b= true;
                }
              }
              else {
                ninguna_valb_b= false;
              }
              /*****************/
              if (ninguna_valb_a == false || ninguna_valb_b== false){
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (ninguna_valb_a == true && ninguna_valb_b== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                //  });
                // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            if (ning_1 == false && ning_2 == true &&  ning_3 == true ) {
              var ninguna_valc_a= false;
              var ninguna_valc_b= false;
              /*Comercial*/
              if ($.trim($("#comment_a").val())) {
                var count_ning_com_two = $("#comment_a").val().length;
                if (count_ning_com_two >=4) {
                  ninguna_valc_a= true;
                }
              }
              else {
                ninguna_valc_a= false;
              }
              /*Proyectos*/
              if ($.trim($("#comment_b").val())) {
                var count_ning_proyec_three = $("#comment_b").val().length;
                if (count_ning_proyec_three >=4) {
                  ninguna_valc_b= true;
                }
              }
              else {
                ninguna_valc_b= false;
              }
              /*****************/
              if (ninguna_valc_a == false || ninguna_valc_b== false){
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (ninguna_valc_a == true && ninguna_valc_b== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                //  });
                //toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            /////////////////---------------------------------------//////////////
            if (ning_1 == true && ning_2 == true &&  ning_3 == true ) {
              var ninguna_val_all_a= false;
              var ninguna_val_all_b= false;
              var ninguna_val_all_c= false;
              //soporte
              if ($.trim($("#comment_c").val())) {
                var count_coment_c = $("#comment_c").val().length;
                if (count_coment_c >=4) {
                  ninguna_val_all_a=true;
                }
              }
              else {
                ninguna_val_all_a = false;
              }
              //comercial
              if ($.trim($("#comment_a").val())) {
                var count_coment_a = $("#comment_a").val().length;
                if (count_coment_a >=4) {
                  ninguna_val_all_b = true;
                }
              }
              else {
                ninguna_val_all_b = false;
              }
              //proyectos e instalaciones
              if ($.trim($("#comment_b").val())) {
                var count_coment_b = $("#comment_b").val().length;
                if (count_coment_b >=4) {
                  ninguna_val_all_c=true;
                }
              }
              else {
                ninguna_val_all_c = false;
              }
              // validar si alguno no concuerda.
              if (ninguna_val_all_a == false || ninguna_val_all_b== false || ninguna_val_all_c== false) {
                toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
              }
              if (ninguna_val_all_a == true && ninguna_val_all_b== true && ninguna_val_all_c== true) {
                $("#delta").submit();
                // var objData = $("#delta, #xa_encuesta").find("select,textarea, input").serialize();
                // $.ajax({
                //      url: "/survey_form",
                //      type: "POST",
                //      data: objData,
                //      success: function (data) {
                //        console.log('success:', data);
                //      },
                //      error: function (data) {
                //        console.log('Error:', data);
                //      }
                // });
                // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
              }
            }
          }
        }
    }
    else {
      toastr.error('Responde la primera pregunta. !!', 'Mensaje', {timeOut: 2500});
    }

   }
   else{
     toastr.error('Completar todos los campos. !!', 'Mensaje', {timeOut: 2500});
   }
  });

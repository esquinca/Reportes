/**................... Encuesta encabezado ..................................**/
  $(function() {
    reinicioproy();
    barstyle();
    inicializacionhidden();
  });

  function reinicioproy(){
    $('#xa_encuesta')[0].reset();
    $('#selecthotelofclient').attr("disabled", false);
    $('#xqa').val('na');
    $("#selecthotelofclient").parent().parent().attr("class","form-group has-default");
  }

  $('#radioigualdad').change(function() {
      if(this.checked) {
        $('#xqa').val('ok');
        $('#selecthotelofclient').val('');
        $('#selecthotelofclient').attr("disabled", true);
        $("#selecthotelofclient").parent().parent().attr("class","form-group has-default");
      }
      else {
        $('#xqa').val('na');
        $('#selecthotelofclient').val('');
        $('#selecthotelofclient').attr("disabled", false);
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

  $('#generatequizquest').on('click', function(){
    var rec_xa = $('#xqa').val();
    var rec_xb = $('#selecthotelofclient').val();
    var val_sel = validarSelect('selecthotelofclient');

    if (rec_xa == 'na' && val_sel == false ) {
      alert('falta validar');
    }
    if (rec_xa == 'ok' && val_sel == false ) {
      $("#selecthotelofclient").parent().parent().attr("class","form-group has-default");
      alert('calificacion general');
    }
    if (rec_xa == 'na' && val_sel == true) {
      alert('calificacion individual');
    }
  });

  $('#clearquizquest').on('click', function(){
      reinicioproy();
  });

/**................... ./Encuesta encabezado ................................**/

/**................... Encuesta Preguntas ...................................**/
  function barstyle(){
    $('#example-1to10').barrating({
      theme: 'bars-1to10'
    });
  }
  function inicializacionhidden() {
    $("#answer_two").hide();
    $("#answer_three").hide();
    $("#answer_four").hide();
    $("#answer_five").hide();
    $('#comment_a').parent().parent().hide();
    $('#comment_b').parent().parent().hide();
    $('#comment_c').parent().parent().hide();
  }
  $('#answer_one input[name="radio"]').on('click', function() {
    if($('input:radio[name=radio]:checked').val() == "100"){
        $(".evaluation").hide();
        $("#answer_four").show()
        $("#answer_five").show();

        $('#comment_a').parent().parent().hide(100);
        $('#comment_a').val('');
        $('#comment_b').parent().parent().hide(100);
        $('#comment_b').val('');
        $('#comment_c').parent().parent().show(100);
        $('#comment_c').val('');
    }
    if($('input:radio[name=radio]:checked').val() == "0"){
        $(".evaluation").hide();
        $("#answer_two").show();
        $('input:checkbox').prop('checked', false);
        $("#answer_five").show();


        $('#comment_a').parent().parent().hide(100);
        $('#comment_a').val('');
        $('#comment_b').parent().parent().hide(100);
        $('#comment_b').val('');
        $('#comment_c').parent().parent().hide(100);
        $('#comment_c').val('');
    }
    if($('input:radio[name=radio]:checked').val() == "ninguna"){
        $(".evaluation").hide();
        $("#answer_three").show();
        $('input:checkbox').prop('checked', false);
        $("#answer_five").show();


        $('#comment_a').parent().parent().hide(100);
        $('#comment_a').val('');
        $('#comment_b').parent().parent().hide(100);
        $('#comment_b').val('');
        $('#comment_c').parent().parent().hide(100);
        $('#comment_c').val('');
    }
  });
  $('input[type="checkbox"]').click(function() {
      var id = $(this).prop('id');
      var status = $(this).is(':checked');
      //$(this).is(':checked') ? alert('checked ' + id) : alert('unchecked ' + id);

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

/**................... ./Encuesta Preguntas .................................**/

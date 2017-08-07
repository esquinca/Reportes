$(function() {
  table();
});

function table(){
  var TableTC= $('#tableUserenc').dataTable({
    "order": [[ 0, "asc" ]],
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    "pagingType": "simple",
    "pageLength": 5,
    responsive: true,
    language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
            "oPaginate": {
                  "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
    }
  });

  $.get('/usershowenc',function(data){
        TableTC.fnClearTable(); /*Este codigo es para la tabla*/
        /*Este codigo de abajo es para graficar*/
        $.each(JSON.parse(data), function(index, status){
          /*Inicio el codigo para generar la tabla*/
          var tokenOrig= $('#_tokenb').val();
          TableTC.fnAddData([
            status.name,
            status.email,
            status.Privilegio,
            '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-success btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-eye" style="margin-right: 4px;"></span>Visualizar</a>',
            '<a href="javascript:void(0);" onclick="enviardos(this)" value="'+status.id+'" class="btn btn-warning btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-share-square-o" style="margin-right: 4px;"></span>Enviar</a>',
          ]);
        });
  });
};

function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
   $.ajax({
       type: "POST",
       url: './config_two_edit',
       data: {sector : valor, _token : _token},
       success: function (data) {
        var datos = JSON.parse(data);
        var nextAutoIncrement = $(location).attr('host');
        $('#i_recibido').val(datos[0].id);
        $('#inpuEditnick').val(datos[0].name);
        $('#inputEditName').val(datos[0].nombrecomp);
        $('#inputEditEmail').val(datos[0].email);
        $('#passgeneratetemp').val(datos[0].temp_pass);
        $('#urlgeneratetemp').val(nextAutoIncrement+'/survey_questions'+'/'+datos[0].shell);

        $("#inpuEditnick").parent().parent().attr("class","form-group has-default");
        $("#inputEditName").parent().parent().attr("class","form-group has-default");
        $('#modal-editUserenc').modal('show');

       },
       error: function (data) {
         alert('Error:', data);
       }
  })
}

function enviardos(e) {
  var valor= e.getAttribute('value');
  var dir_s = $(location).attr('host');
  $('#r_recibido').val(valor);
  $('#r_rec_host').val(dir_s);


  $('#modal-Userenc').modal('show');
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

function numeroAleatorio(min, max) {
  var num = Math.round(Math.random() * (max - min) + min);
  return num;
}

function validarEmail(campo) {
  var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
  if (campo != '') {
    select=document.getElementById(campo).value;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
    else {
       if (regex.test(select)) {
         $("#"+campo).parent().parent().attr("class","form-group has-default");
         return true;
       }
       else {
         $('#'+campo).parent().parent().attr("class", "form-group has-error");
         return false;
       }
    }
  }
}

$('#update_keyuser_data').on('click', function(){
  var nrandom= numeroAleatorio(100000, 999999);
  var identificador = $('#i_recibido').val();
  var _token = $('input[name="_token"]').val();
   $.ajax({
       type: "POST",
       url: './config_two_rand',
       data: { xa : nrandom, xb: identificador, _token : _token},
       success: function (data) {
         if (data == 1) { /*Si se  cambio*/
           toastr.success('Key generada con exito!', 'Mensaje', {timeOut: 2000});
           $('#modal-editUserenc').modal('toggle');
         }
         if (data == 0) { /*No se cambio*/
           toastr.error('Problema al generar la Key!', 'Mensaje', {timeOut: 2000});
           $('#modal-editUserenc').modal('toggle');
          }
       },
       error: function (data) {
         console.log('Error:', data);
       }
  })
});

$('#update_edituser_data').on('click', function(){
  var a0=validarInput('inpuEditnick');
  var a1=validarInput('inputEditName');

  var identificador = $('#i_recibido').val();
  var nick_n = $('#inpuEditnick').val();
  var name_n = $('#inputEditName').val();

  var _token = $('input[name="_token"]').val();

  if (a0 == false || a1 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
    $.ajax({
        type: "POST",
        url: './config_two_data_chang',
        data: { xa : nick_n, xb: name_n, xc : identificador, _token : _token},
        success: function (data) {
          if (data == 0) { /*No se cambio*/
            toastr.warning('Sin cambios. !!', 'Mensaje', {timeOut: 1000});
            $('#modal-editUserenc').modal('toggle');
          }
          if (data == 1) { /*Si se  cambio*/
            toastr.success('Datos guardados con exito!', 'Mensaje', {timeOut: 2000});
            $('#modal-editUserenc').modal('toggle');
            var fds= $('#tableUserenc').dataTable();
            fds.fnDestroy();
            table();

          }
          if (data == 2) { /*Si se  cambio*/
            toastr.error('Volverlo a intentar en otro momento!', 'Mensaje', {timeOut: 2000});
            $('#modal-editUserenc').modal('toggle');
          }
        },
        error: function (data) {
          console.log('Error:', data);
        }
   })
  }
});

$('#send_user_data').on('click', function(){
  var identificador = $('#r_recibido').val();
  var correocss = $('#inputcc').val();
  var hosting = $('#r_rec_host').val();
  var _token = $('input[name="_token"]').val();

  var z0=validarEmail('inputcc');

  if (z0 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
    $.ajax({
      type: "POST",
      url: './config_two_ccmail',
      data: { xa : identificador, xb: correocss, xc: hosting ,_token : _token},
      success: function (data) {
        alert(data);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    })
  }

});

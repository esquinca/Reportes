$('#btnregister').on('click', function(){
  var z0=validarInput('inputName');
  var z1=validarEmail('inputEmail');
  var z2=validarSelect('selectpriv');
  var z3=validarInput('inputNick');
  if (z0 == false || z1 == false || z2 == false || z3 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
     $('#formadduser').submit();
  }
});

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

$(function() {
  table();
});

function table(){
  var TableTC= $('#tableUser').dataTable({
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

  $.get('/usershow',function(data){
        TableTC.fnClearTable(); /*Este codigo es para la tabla*/
        /*Este codigo de abajo es para graficar*/
        $.each(JSON.parse(data), function(index, status){
          /*Inicio el codigo para generar la tabla*/
          var tokenOrig= $('#_tokenb').val();
          var r='<?php echo {{ url("/config_two", ["id" => 1 ] ) }} ?>';
          TableTC.fnAddData([
            status.name,
            status.email,
            status.Privilegio,
            '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-pencil-square-o" style="margin-right: 4px;"></span>Editar</a>',
          ]);
        });
  });
};


//Editar
    function enviar(e){
      var valor= e.getAttribute('value');
      var _token = $('input[name="_token"]').val();
      //$('#EditarServicioSx').modal('show');
      //$('#id_recibido').val(valor);
      $.ajax({
           type: "POST",
           url: './config_two_e',
           data: {sector : valor, _token : _token},
           success: function (data) {
             var datos = JSON.parse(data);
             //console.log(data);
             $('#id_recibido').val(datos[0].id);
             $('#inpuEditnick').val(datos[0].name);
             $('#inputEditName').val(datos[0].nombrecomp);
             $('#inputEditEmail').val(datos[0].email);
             //$('#selectEditPriv').val(datos[0].privilegiorentas);
             $("#selectEditPriv").find('option:selected').removeAttr("selected");
             $("#selectEditPriv option[value='"+datos[0].Privilegio+"']").prop('selected', true);

             $('#modal-editUser').modal('show');
           },
           error: function (data) {
             alert('Error:', data);
           }
       })
		}

    $('#update_user_data').on('click', function(){
      var a0=validarInput('inpuEditnick');
      var a1=validarInput('inputEditName');
      var a2=validarEmail('inputEditEmail');
      var a3=validarSelect('selectEditPriv');
      var _token = $('input[name="_token"]').val();
      var id= $('#id_recibido').val();
      var vali= $('#inputEditEmail').val();

      if (a0 == false || a1 == false || a2 == false || a3 == false) {
         toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
      }
      else {
        $.ajax({
             type: "POST",
             url: './config_two_ed',
             data: {correo : vali, _token : _token},
             success: function (data) {
               if(data == 1){
                     //toastr.error('Registrado. !!', 'Error', {timeOut: 1000});
                     $.ajax({
                          type: "POST",
                          url: './config_two_exit',
                          data: {sector : id, correo : vali,  _token : _token},
                          success: function (data) {
                            if(data== 0){
                              //console.log('SI es 0  esta registrado en otro individuo= '+data);
                              toastr.error('Este correo le pertenece a otro usuario.!!', 'Error', {timeOut: 1000});
                            }
                            if(data== 1){
                              //console.log('SI es 1 es el Mismo correo y id = '+data);
                              $('#formrewrite').submit();
                            }
                          },
                          error: function (data) {
                            alert('Error:', data);
                          }
                      })
               }
               if (data == 0) {
                 //toastr.success('No registrado!!', 'Error', {timeOut: 1000});
                 $('#formrewrite').submit();
               }
             },
             error: function (data) {
               alert('Error:', data);
             }
         });

      }
    });

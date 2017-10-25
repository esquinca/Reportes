$(function() {
  table();
  tableHotEnc();
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
            '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-eye" style="margin-right: 4px;"></span>Visualizar</a>',
            '<a href="javascript:void(0);" onclick="enviardos(this)" value="'+status.id+'" class="btn bg-olive btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-share-square-o" style="margin-right: 4px;"></span>Enviar</a>',
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

function validarSelect(campo) {
  if (campo !='') {
    selectNew=document.getElementById(campo).selectedIndex;
    if( selectNew == null || selectNew == 0 ) {
        $('#'+campo).parent().parent().attr("class", "form-group has-error");
        return false;
    }
    else {
      $('#'+campo).parent().parent().attr("class","form-group has-default");
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
        if (data == 'OK') {
          $('#formrewritecc')[0].reset();
          toastr.success('Datos guardados con exito!', 'Mensaje', {timeOut: 2000});
          $('#modal-Userenc').modal('toggle');
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    })
  }

});

$('#update_keyusergeneral_data').on('click', function(){
  var _token = $('input[name="_token"]').val();
   $.ajax({
       type: "POST",
       url: './config_two_rand_all',
       data: { _token : _token},
       success: function (data) {

         if (data == 'OK') { /*Si se  cambio*/
           toastr.success('Keys generadas con exito!', 'Mensaje', {timeOut: 2000});
         }
         if (data == 'NA') { /*No se cambio*/
           toastr.error('Problema al generar la Key!', 'Mensaje', {timeOut: 2000});
         }
       },
       error: function (data) {
         console.log('Error:', data);
       }
  })
});

//Registrar un nuevo encuestado

$('#btnregister').on('click', function(){
  var z0=validarInput('inputNick');
  var z1=validarInput('inputName');
  var z2=validarEmail('inputEmail');
  var _token = $('input[name="_token"]').val();

  if (z0 == false || z1 == false || z2 == false ) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
    var objData = $("#formadduserenc").find("select,textarea, input").serialize();

    $.ajax({
         type: "POST",
         url: './config_reg_verfmail',
         data: objData,
         success: function (data) {
           if (data == 'OK') {
             $('#formadduserenc')[0].reset();
             toastr.success('Datos guardados con exito!', 'Mensaje', {timeOut: 2000});
             var fds= $('#tableUserenc').dataTable();
             fds.fnDestroy();
             table();
             /*.........................................................................................*/
             var w_encuestado = $("#select_two");
             $.ajax({
                  type: "POST",
                  url: './config_rec_rel_hotenc',
                  data: { _token : _token },
                  dataType: 'json',
                  beforeSend: function ()
                  {
                      w_encuestado.find('option').remove();
                  },
                  success: function (datatwo) {

                    $("#select_two").find('option:selected').removeAttr("selected");

                    w_encuestado.append('<option value="">Elija</option>');
                    $(datatwo).each(function(i, v){ // indice, valor
                        w_encuestado.append('<option value="' + v.id + '">' + v.email + '</option>');
                    })

                    $("#select_two option[value='']").prop('selected', true);
                  },
                  error: function (datatwo) {
                    alert('Ocurrio un error, volverlo a intentar mas tarde');
                    w_encuestado.prop('disabled', false);
                  }
              });
             /*.........................................................................................*/
           }
           if (data == 'NA') {
             $('#formadduserenc')[0].reset();
             toastr.error('Este usuario ya esta registrado!', 'Mensaje', {timeOut: 2000});
           }
         },
         error: function (data) {
           alert('Error:', data);
         }
     })
  }
});

//Apartado de relación hotel con encuestado.
function enviartres(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#id_recibido').val(valor);
  $('#modal-edithotenc').modal('show');
  var x_encuestado = $("#selectEditClient");

  $.ajax({
     type: "POST",
     url: './config_rec_data_obj',
     data: { xa : valor , _token : _token },
     dataType: 'json',
     success: function (data) {
       $('#inputhotel').val(data[0].Nombre_hotel);
       $.ajax({
            type: "POST",
            url: './config_rec_rel_hotenc',
            data: { _token : _token },
            dataType: 'json',
            beforeSend: function ()
            {
                x_encuestado.find('option').remove();
            },
            success: function (datatwo) {

              $("#selectEditClient").find('option:selected').removeAttr("selected");

              x_encuestado.append('<option value="">Seleccione una opción</option>');
              $(datatwo).each(function(i, v){ // indice, valor
                  x_encuestado.append('<option value="' + v.id + '">' + v.email + '</option>');
              })

              $("#selectEditClient option[value='"+data[0].id_clientes+"']").prop('selected', true);
            },
            error: function (datatwo) {
              alert('Ocurrio un error, volverlo a intentar mas tarde');
              x_encuestado.prop('disabled', false);
            }
        });
       //alert(data[0].id_clientes);
     },
     error: function (data) {
       console.log( 'Error:', data );
     }
 })
}

$('#update_encues_assign').on('click', function(){
  var _token = $('input[name="_token"]').val();
  var id =$('#id_recibido').val();
  var enc =$('#selectEditClient').val();
  //alert('SA');
    $.ajax({
         type: "POST",
         url: './config_hotelenc_chang',
         data: { xa: id, xb: enc, _token : _token},
         success: function (data) {
          // alert(data);
          if (data == 'OK') {
            $('#modal-edithotenc').modal('toggle');
            var fds= $('#tableUREnc').dataTable();
            fds.fnDestroy();
            tableHotEnc();
            toastr.success('Cambio guardado con exito!', 'Mensaje', {timeOut: 2000});
          }
          if (data == 'NA') {
            $('#modal-edithotenc').modal('toggle');
            toastr.error('Este encuestado ya esta asociado a dicho hotel!', 'Mensaje', {timeOut: 2000});
          }
         },
         error: function (data) {
           console.log('Error:', data);
         }
    });
});


function enviarcuatro(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#recibidoconf').val(valor);
  $('#modal-delhotenc').modal('show');
}

$('#delete_enc_data').on('click', function(){
  var _token = $('input[name="_token"]').val();
  var id= $('#recibidoconf').val();
    $.ajax({
         type: "POST",
         url: './config_two_delet',
         data: { xa: id, _token : _token},
         success: function (data) {
           if (data == 1) {
             $('#modal-delhotenc').modal('toggle');
             var fds= $('#tableUREnc').dataTable();
             fds.fnDestroy();
             tableHotEnc();
             toastr.success('Eliminado!!', 'Mensaje', {timeOut: 1000});
           }
           if ( data != 1 ){
             toastr.error('Problema al eliminar reintentar mas tarde!!', 'Mensaje', {timeOut: 1000});
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
    });
});

function tableHotEnc (){
  var TableRHE= $('#tableUREnc').dataTable({
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

  $.get('/usershowrhe',function(data){
        TableRHE.fnClearTable(); /*Este codigo es para la tabla*/
        /*Este codigo de abajo es para graficar*/
        $.each(JSON.parse(data), function(index, status){
          /*Inicio el codigo para generar la tabla*/
          TableRHE.fnAddData([
            status.Nombre_hotel,
            status.email,
            '<a href="javascript:void(0);" onclick="enviartres(this)" value="'+status.id+'" class="btn btn-default btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-eye" style="margin-right: 4px;"></span>Visualizar</a>',
            '<a href="javascript:void(0);" onclick="enviarcuatro(this)" value="'+status.id+'" class="btn btn-danger btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-trash" style="margin-right: 4px;"></span>Eliminar</a>',
          ]);
        });
  });
};

$('#btnregasig').on('click', function(){
  var z0=validarSelect('select_one');
  var z1=validarSelect('select_two');
  var y1=$('#select_one').val();
  var y2=$('#select_two').val();

  var _token = $('input[name="_token"]').val();
  if (z0 == false || z1 == false ) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  else {
    //toastr.success('Datos Requeridos Completados. !!', 'Mensaje', {timeOut: 1000});
    $.ajax({
      type: "POST",
      url: './config_two_asignreg',
      data: { xa : y1, xb: y2, _token : _token},
      success: function (data) {
        if (data == 'OK') {
          $('#formassinguserht')[0].reset();
          toastr.success('Datos guardados con exito!', 'Mensaje', {timeOut: 2000});
          var zx2= $('#tableUREnc').dataTable();
          zx2.fnDestroy();
          tableHotEnc();
        }
        if (data == 'NA') {
          $('#formassinguserht')[0].reset();
          toastr.error('Este usuario ya esta asociado a dicho hotel!', 'Mensaje', {timeOut: 2000});
        }
      },
      error: function (data) {
        console.log('Error:', data);
      }
    })

  }
});
$('#mail_keyusergeneral_data').on('click', function(){
  toastr.warning('Se proximamente tendra funcionalidad', 'Mensaje', {timeOut: 2000});

});

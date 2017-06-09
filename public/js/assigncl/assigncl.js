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

$('#capInfo').on('click', function(){
  var a0=validarSelect('select_one');
  var a1=validarSelect('select_two');
  var valorselone= $('#select_one').val();
  var valorseltwo= $('#select_two').val();
  var _token = $('input[name="_token"]').val();

  if (a0 == false && a1 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (a0 == true && a1 == true) {
    $.ajax({
         type: "POST",
         url: './assignclreg',
         data: { idh : valorselone, idc: valorseltwo, _token : _token },
         success: function (data) {
           console.log('Error:', data);
           if (data == '0') {
             toastr.error('Ya esta asignado a dicho hotel. !!', 'Mensaje', {timeOut: 1000});
           }
           if (data == '1') {
             toastr.success('Registrado. !!', 'Mensaje', {timeOut: 1000});
             var fds= $('#tableclient').dataTable();
             fds.fnDestroy();
             table();
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });
  }
});

$('#capClear').on('click', function(){
  $("#select_one").select2("val", "");
  $("#select_two").select2("val", "");
});

$(function() {
  $(".select2").select2();
  table();
});

function table(){
  var TableHotelClient= $('#tableclient').dataTable({
    "order": [[ 0, "asc" ]],
    "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    //"pagingType": "simple",
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
  var _token = $('input[name="_tokenb"]').val();
  $.ajax({
       type: "POST",
       url: '/assignclshow',
       data: {_token : _token},
       success: function (data) {
         TableHotelClient.fnClearTable();
         $.each(JSON.parse(data), function(index, status){
           var tokenOrig= $('#_tokenb').val();
           TableHotelClient.fnAddData([
             status.id_hotels,
             status.id_clientes,
             '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-sm" role="button" data-target="#modal-edithotcl"><span class="fa fa-pencil-square-o"></span></a> <a href="javascript:void(0);" onclick="enviardos(this)" value="'+status.id+'" class="btn btn-danger btn-sm" role="button" data-target="#modal-delhotcl"><span class="fa fa-trash"></span></a>',
           ]);
         });

       },
       error: function (data) {
         console.log('Error:', data);
       }
   });
};

//Enviar dato a la modal de editar.
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#id_recibido').val(valor);

  $.ajax({
       type: "POST",
       url: './assignclold',
       data: { scv : valor, _token : _token},
       success: function (data) {
         var datos = JSON.parse(data);
         $('#inputhotel').val(datos[0].id_hotels);

         $("#selectEditClient").find('option:selected').removeAttr("selected");
         $("#selectEditClient option[value='"+datos[0].id_clientes+"']").prop('selected', true);

         $('#modal-edithotcl').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

//Boton actualizar modal de editar.
$('#update_client_assign').on('click', function(){
  var a0=validarSelect('selectEditClient');
  var _token = $('input[name="_token"]').val();
  var id= $('#id_recibido').val();
  var idclien= $('#selectEditClient').val();


  if (a0 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
    $.ajax({
         type: "POST",
         url: './assignclupdate',
         data: { idreg: id, idcl : idclien, _token : _token},
         success: function (data) {
           if (data == 1) {
             $('#modal-edithotcl').modal('toggle');
             var fds= $('#tableclient').dataTable();
             fds.fnDestroy();
             table();
             toastr.success('Actualizado!!', 'Mensaje', {timeOut: 1000});
           }
         },
         error: function (data) {
           alert('Error:', data);
         }
     });
  }
});


//Enviar dato a la modal de eliminar.
function enviardos(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#recibidoconf').val(valor);
  $('#modal-delhotcl').modal('show');
}

//Boton actualizar modal de delete.
$('#delete_client_data').on('click', function(){
  var _token = $('input[name="_token"]').val();
  var id= $('#id_recibido').val();

    $.ajax({
         type: "POST",
         url: './assigncldelete',
         data: { idreg: id, _token : _token},
         success: function (data) {
           if (data == 1) {
             $('#modal-delhotcl').modal('toggle');
             var fds= $('#tableclient').dataTable();
             fds.fnDestroy();
             table();
             toastr.success('Eliminado!!', 'Mensaje', {timeOut: 1000});
           }
         },
         error: function (data) {
           alert('Error:', data);
         }
     });
});

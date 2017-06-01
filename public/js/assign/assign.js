$(function() {
  table();
});
function table(){
  var TableHotel= $('#tableHotel').dataTable({
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
       url: '/usershow',
       data: {_token : _token},
       success: function (data) {
         TableHotel.fnClearTable();
         $.each(JSON.parse(data), function(index, status){
           var tokenOrig= $('#_tokenb').val();
           TableHotel.fnAddData([
             status.Nombre_hotel,
             status.Encargado,
             '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.IDHotels+'" class="btn btn-default btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-pencil-square-o" style="margin-right: 4px;"></span>Editar</a>',
           ]);
         });

       },
       error: function (data) {
         alert('Error:', data);
       }
   });
};
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
//Apartado de asignar concierge
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#id_recibido').val(valor);
  $('#modal-editUser').modal('show');

  $.ajax({
       type: "POST",
       url: './config_asig_car_edit',
       data: { sector : valor, _token : _token},
       success: function (data) {
         var datos = JSON.parse(data);
         console.log(data);
         //$('#id_recibido').val(datos[0].IDHotels);
         $('#inputhotel').val(datos[0].Nombre_hotel);
         $("#selectEditItconcierge").find('option:selected').removeAttr("selected");
         $("#selectEditItconcierge option[value='"+datos[0].IDUsuario+"']").prop('selected', true);

         $('#modal-editItconcierge').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

$('#update_user_assign').on('click', function(){
  var a0=validarSelect('selectEditItconcierge');
  var _token = $('input[name="_token"]').val();
  var id= $('#id_recibido').val();
  var it= $('#selectEditItconcierge').val();
  if (a0 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
    $.ajax({
         type: "POST",
         url: './config_hotel',
         data: { concierge: it, hotel : id, _token : _token},
         success: function (data) {
           if (data == 1) {
             $('#modal-editItconcierge').modal('toggle');
             var fds= $('#tableHotel').dataTable();
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

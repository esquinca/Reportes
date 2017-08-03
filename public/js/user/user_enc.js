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
            '<a href="javascript:void(0);" onclick="enviardos(this)" value="'+status.id+'" class="btn btn-default btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-key" style="margin-right: 4px;"></span>Generar Clave</a>',
            '<a href="javascript:void(0);" onclick="enviartres(this)" value="'+status.id+'" class="btn btn-warning btn-block btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-share-square-o" style="margin-right: 4px;"></span>Enviar</a>',
          ]);
        });
  });
};

function enviar(e){
  var valor= e.getAttribute('value');
  // var _token = $('input[name="_token"]').val();
  // //$('#EditarServicioSx').modal('show');
  // //$('#id_recibido').val(valor);
   $.ajax({
       type: "POST",
       url: './config_two_edit',
       data: {sector : valor, _token : _token},
       success: function (data) {
         var datos = JSON.parse(data);
         //console.log(data);
        //  $('#id_recibido').val(datos[0].id);
        //  $('#inpuEditnick').val(datos[0].name);
        //  $('#inputEditName').val(datos[0].nombrecomp);
        //  $('#inputEditEmail').val(datos[0].email);
        //  $('#selectEditPriv').val(datos[0].privilegiorentas);
        //  $("#selectEditPriv").find('option:selected').removeAttr("selected");
        //  $("#selectEditPriv option[value='"+datos[0].Privilegio+"']").prop('selected', true);

         $('#modal-editUser').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
  })
}

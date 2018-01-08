$(function() {
  tableapproval();
  $("#selectfiltro").hide();
  $("#filter_year").hide();
  $("#filter_status").hide();
  $("#filter_hotel").hide();
  setInterval(pendientesactivosdos, 2500);

});

function pendientesactivosdos(){
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./showpendient",
    data: { _token : _token },
    success: function (data){
      $("#buttonpendientes").text(data);
    },
    error: function (data) {
      console.error('Error:', data);
    }
  });
}

$('#boton_muestra_selectfiltro').on('click', function() {
  $("#selectfiltro").show(10);
  //console.log('corre el show de id selectfiltro');
});


$(".selectFiltro").change(function() {
  mostraryreordenar($( this).val(), $("#filtration_container") );
  //console.log('verifico y mando al metodo');
});

function mostraryreordenar(identifier, contentElements)
{
  contentElements.append( $('#'+identifier) ); //Para mover el div
  $('#'+identifier).show(300);
  $("#selectfiltro").hide(100);
  $('#selectfiltro').prop('selectedIndex',0);

  //console.log(contentElements);
  //console.log('#'+identifier);
}
$(".boton-mini").click(function(event) {
   var identifier = $(this).closest( $( ".control-filter" ) );
   ocultaryreordenar(identifier);
});

function ocultaryreordenar(element)
{
  element.hide(100);
  element.find('select').prop('selectedIndex',0);
  //console.log(element.find('select').attr("id"));
}



var configTable={
      "order": [[ 3, "desc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      bInfo: false,
      language:{
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "<i class='fa fa-search'></i> Buscar:",
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
}

function tableapproval()
{
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./showtypereports",
    data: { _token : _token },
    success: function (data){
      $('#example1').DataTable().destroy();
      var TablaDetalles= $('#example1').dataTable(configTable);
      TablaDetalles.fnClearTable();


      $.each(JSON.parse(data),function(index, objdataTable){
        if(objdataTable.status2 == '0') { estadoact='<a href="javascript:void(0);" class="btn btn-warning btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-clock-o" style="margin-right: 4px;"></span>Pendiente</a>'}
        if(objdataTable.status2 == '1') { estadoact='<a href="javascript:void(0);" class="btn btn-success btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-check-circle" style="margin-right: 4px;"></span>Aprobado</a>'};
        TablaDetalles.fnAddData([
          objdataTable.Nombre_hotel,
          objdataTable.Nombre_Reporte,
          objdataTable.FechaAutorizacion,
          estadoact,
        '<a href="javascript:void(0);" onclick="enviarOne(this)" value="'+objdataTable.id+'" class="btn btn-success btn-xs " role="button"><span class="fa fa-check-square" style="margin-right: 4px;"></span>Activar</a><a href="javascript:void(0);" onclick="enviarTwo(this)" value="'+objdataTable.id+'" class="btn btn-warning btn-xs" role="button"><span class="fa fa-hourglass-half" style="margin-right: 4px;"></span>Desactivar</a><a href="javascript:void(0);" onclick="enviarthree(this)" value="'+objdataTable.id+'" class="btn btn-danger btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-ban" style="margin-right: 4px;"></span>Eliminar</a>',
        ]);
      });

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function enviarOne(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./changependientactive",
    data: { val: valor, _token : _token },
    success: function (data){
      toastr.success('Se ha aprobado correctamente..!!', 'Mensaje', {timeOut: 2000});
      tableapproval();
    },
    error: function (data) {
      console.error('Error:', data);
    }
  });
}

function enviarTwo(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./changependientdesactive",
    data: { val: valor, _token : _token },
    success: function (data){
      toastr.success('Se ha desactivado correctamente..!!', 'Mensaje', {timeOut: 2000});
      tableapproval();
    },
    error: function (data) {
      console.error('Error:', data);
    }
  });
}
$('#boton-aprobar_todopendientes').on('click', function() {
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./changependientall",
    data: {_token : _token },
    success: function (data){
      toastr.success('Se ha activaron todos correctamente..!!', 'Mensaje', {timeOut: 2000});
      tableapproval();
    },
    error: function (data) {
      console.error('Error:', data);
    }
  });
});

$("#boton-aplica-filtro-visitantes").click(function(event) {
  var objData = $("#filasasw").find("select,textarea, input").serialize();
  var _token = $('input[name="_token"]').val();
  $.ajax({
       url: "/result_filter_approval",
       type: "POST",
       data: objData,
       success: function (data) {
          tablaEnc(data, $("#example1") , 0);
       },
       error: function (data) {
         console.log('Error:', data);
       }
   });
});


function tablaEnc(datajson, table, order){
    table.DataTable().destroy();
    var vartable = table.dataTable({
      "order": [[ 2, "asc" ]],
      paging: true,
      //"pagingType": "simple",
      Filter: true,
      searching: true,
      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
      //ordering: false,
      //"pageLength": 5,
      bInfo: false,
      language:{
              "sProcessing":     "Procesando...",
              "sLengthMenu":     "Mostrar _MENU_ registros",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún dato disponible",
              "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sSearch":         "<i class='fa fa-search'></i> Buscar:",
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
    vartable.fnClearTable();
    $.each(JSON.parse(datajson), function(index, objdataTable){
      if(objdataTable.status2 == '0') { estadoact='<a href="javascript:void(0);" class="btn btn-warning btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-clock-o" style="margin-right: 4px;"></span>Pendiente</a>'}
      if(objdataTable.status2 == '1') { estadoact='<a href="javascript:void(0);" class="btn btn-success btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-check-circle" style="margin-right: 4px;"></span>Aprobado</a>'};
      vartable.fnAddData([
        objdataTable.Nombre_hotel,
        objdataTable.Nombre_Reporte,
        objdataTable.FechaAutorizacion,
        estadoact,
'<a href="javascript:void(0);" onclick="enviarOne(this)" value="'+objdataTable.id+'" class="btn btn-success btn-xs " role="button"><span class="fa fa-check-square" style="margin-right: 4px;"></span>Activar</a><a href="javascript:void(0);" onclick="enviarTwo(this)" value="'+objdataTable.id+'" class="btn btn-warning btn-xs" role="button"><span class="fa fa-hourglass-half" style="margin-right: 4px;"></span>Desactivar</a><a href="javascript:void(0);" onclick="enviarthree(this)" value="'+objdataTable.id+'" class="btn btn-danger btn-xs" role="button" data-target="#EditarServicioSx"><span class="fa fa-ban" style="margin-right: 4px;"></span>Eliminar</a>',
      ]);
    });
}

$('#enviarthree').on('click', function() {

});

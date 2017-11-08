$(function() {

});
var _token = $('input[name="_token"]').val();
var configTable={
      "order": [[ 2, "desc" ]],
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
};

function table_one(){
  $.ajax({
    type: "POST",
    url: "./showtypereports",
    data: { _token : _token },
    success: function (data){
      $('#table_type_reports').DataTable().destroy();
      var TablaDetalles= $('#table_type_reports').dataTable(configTable);
      TablaDetalles.fnClearTable();
      // $.each(JSON.parse(data),function(index, objdataTable){
      // });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}
function table_two(){
}
function table_three(){
}
function table_four(){
}
function table_five(){

}

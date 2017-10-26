$(function() {
  reset_quiz_all();
  tableapproval();
});

$('#approvalInfo').on('click', function() {
  var a0=validarSelect('select_one');
  var a1=validarSelect('select_two');
  if (a0 == false || a1 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (a0 == true && a1 == true) {
    var objData = $("#lambda").find("select,select2,textarea, input").serialize();
    $.ajax({
         url: "/typecreateone",
         type: "POST",
         data: objData,
         success: function (data) {

           if (data == '1') {
             reset_quiz_all();
             toastr.success('Registrado. !!', 'Mensaje', {timeOut: 2000});
             tableapproval();
           }
           if (data == '0') {
             reset_quiz_all();
             toastr.error('Ya se encuentra registrado. !!', 'Mensaje', {timeOut: 2000});
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
    });
  }
})

$('#clearinfo').on('click', function() {
  reset_quiz_all();
  $('#select_one').parent().parent().attr("class", "form-group has-default");
  $('#select_two').parent().parent().attr("class", "form-group has-default");
  $('#calendar_fecha').parent().parent().attr("class", "form-group has-default");
});

function reset_quiz_all(){
  $('#select_one').prop('selectedIndex',0);
  $("#select_one").select2({placeholder: "Elija"});
  $('#select_two').prop('selectedIndex',0);
  $("#select_two").select2({placeholder: "Elija"});
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
  }
  else {
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

var configTable={
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
}

function enviar(e){
  var valor= e.getAttribute('value');
  $('#recibidoconf').val(valor);
  $('#modal-deltype').modal('show');
}

$('#delete_type_rep').on('click', function() {
  var valormodal= $('#recibidoconf').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
       type: "POST",
       url: './delete_register_tipo',
       data: { status : valormodal, _token : _token},
       success: function (data) {
        // alert(data);
         if (data == '1') {
           toastr.success('Se ha eliminado correctamente..!!', 'Mensaje', {timeOut: 2000});
           tableapproval();
           $('#modal-deltype').modal('toggle');
         }
         else {
           toastr.error('Error.. !!', 'Mensaje', {timeOut: 2000});
           tableapproval();
           $('#modal-deltype').modal('toggle');
         }
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
});

function tableapproval()
{
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./showtypehotel",
    data: { _token : _token },
    success: function (data){
      $('#table_type_reports').DataTable().destroy();
      var TablaTipoReportes= $('#table_type_reports').dataTable(configTable);
      TablaTipoReportes.fnClearTable();

      $.each(JSON.parse(data),function(index, objdataTable){
          TablaTipoReportes.fnAddData([
          objdataTable.Nombre_hotel,
          objdataTable.Nombre,
          '<a href="javascript:void(0);" onclick="enviar(this)" value="'+objdataTable.id_tabla+'" class="btn btn-danger btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-ban" style="margin-right: 4px;"></span>Eliminar</a>',
        ]);
      });

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

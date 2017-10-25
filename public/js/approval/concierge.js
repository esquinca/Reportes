$(function() {
  initialization_page();
  $(".select2").select2();
  tableapproval();
});
function initialization_page(){
      $('#select_one').prop('selectedIndex',0);
      $("#select_one").select2({placeholder: "Elija"});

      resetselecttype();
      $('#calendar_fecha').attr('disabled', true);
      $('#calendar_fecha').datepicker({
          language: 'es',
          defaultDate: '',
          format: "mm-yyyy",
          viewMode: "months",
          minViewMode: "months",
          startDate: "01-2016",
          endDate: '-1m', //Esto indica que aparecera el mes hasta que termine el ultimo dia del mes.
          autoclose: true
      });
      resetcalent();
}
function reset_quiz_all(){
  initialization_page();
}
function resetselecttype() {
  $('#select_two').empty();
  $('#select_two').append('<option value="">Elije</option>');

  $('#select_two').prop('selectedIndex',0);
  $("#select_two").select2({placeholder: "Elija"});
}
function resetcalent() {
  $('#calendar_fecha').val('');
  $('#calendar_fecha').attr('disabled', true);
  $('#calendar_fecha').datepicker('update', '');
}

$('#select_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
      $.ajax({
        type: "POST",
        url: "./typereportnew",
        data: { numero : id , _token : _token },
        success: function (data){

          if (data === '[]' || data === '' || data === null) {
            resetselecttype();
            resetcalent();
            toastr.error('Solicita al administrador que habilite el tipo de reporte a este hotel. !!', 'Mensaje', {timeOut: 2000});
          }
          else {
            resetselecttype();
            $('#calendar_fecha').attr('disabled', false);
            $('#calendar_fecha').datepicker('update', '');
            // toastr.success('Solicita al administrador que habilite el tipo de reporte a este hotel. !!', 'Mensaje', {timeOut: 2000});
            $.each(JSON.parse(data),function(index, objdata){
                if (objdata.Nombre == 'Basico') {
                  $('#select_two').append('<option value="'+objdata.fk_tiporeportenew+'" selected>'+ objdata.Nombre +'</option>');
                  $('#select_two').val(objdata.fk_tiporeportenew).trigger('change');
                }
                else {
                  $('#select_two').append('<option value="'+objdata.fk_tiporeportenew+'">'+ objdata.Nombre +'</option>');
                }
              });
          }


        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
    resetselecttype();
  }
});

$('#clearinfo').on('click', function() {
  reset_quiz_all();
  $('#select_one').parent().parent().attr("class", "form-group has-default");
  $('#select_two').parent().parent().attr("class", "form-group has-default");
  $('#calendar_fecha').parent().parent().attr("class", "form-group has-default");
});

$('#approvalInfo').on('click', function() {
  var a0=validarSelect('select_one');
  var a1=validarSelect('select_two');
  var a2=validarInput('calendar_fecha');
  if (a0 == false || a1 == false  || a2 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (a0 == true && a1 == true && a2 == true) {
    var objData = $("#lambda").find("select,select2,textarea, input").serialize();
    $.ajax({
         url: "/approvalcreateone",
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
       url: './delete_register_aprobation',
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

//--------------------------------------------------------------------------------------------------------------//
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
//--------------------------------------------------------------------------------------------------------------//
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
}

function tableapproval()
{
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./showtypereports",
    data: { _token : _token },
    success: function (data){
      $('#table_type_reports').DataTable().destroy();
      var TablaDetalles= $('#table_type_reports').dataTable(configTable);
      TablaDetalles.fnClearTable();


      $.each(JSON.parse(data),function(index, objdataTable){
        if(objdataTable.status2 == '0') { estadoact='<a href="javascript:void(0);" class="btn btn-warning btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-clock-o" style="margin-right: 4px;"></span>Pendiente</a>'}
        if(objdataTable.status2 == '1') { estadoact='<a href="javascript:void(0);" class="btn btn-success btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-check-circle" style="margin-right: 4px;"></span>Aprobado</a>'};
        TablaDetalles.fnAddData([
          objdataTable.Nombre_hotel,
          objdataTable.Nombre_Reporte,
          objdataTable.FechaAutorizacion,
          estadoact,
        '<a href="javascript:void(0);" onclick="enviar(this)" value="'+objdataTable.id+'" class="btn btn-danger btn-xs btn-block" role="button" data-target="#EditarServicioSx"><span class="fa fa-ban" style="margin-right: 4px;"></span>Eliminar</a>',
        ]);
      });

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

$(function() {
	$(".select2").select2();
  //table();
  $('#tableWLAN').dataTable(config_table);
});

var config_table= {
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
}

$('#selecthotel').on('change',function(e){
  var id= $(this).val();
  if (id != '') {
    //alert(id);
    $('#tableWLAN').dataTable().fnDestroy();
    var TableWLAN= $('#tableWLAN').dataTable(config_table);

    var _token = $('input[name="_token"]').val();
    var estadoact = '';
    $.ajax({
         type: "POST",
         url: '/wlanstatus',
         data: { hotel : id, _token : _token},
         success: function (data) {
           TableWLAN.fnClearTable();
           $.each(JSON.parse(data), function(index, status){
             var tokenOrig= $('#_token').val();
             if(status.Estado=='0') { estadoact='<a href="javascript:void(0);" class="btn btn-danger btn-xs btn-block"><span class="glyphicon glyphicon-thumbs-down" style="margin-right: 4px;"></span>Deshabilitada</a>'}
             if(status.Estado=='1') { estadoact='<a href="javascript:void(0);" class="btn btn-primary btn-xs btn-block"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 4px;"></span>Habilitada</a>'};
             TableWLAN.fnAddData([
               status.NombreWLAN,
               estadoact,
               '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-xs btn-block" role="button" data-target="#modal_wlan"><span class="fa fa-pencil-square-o" style="margin-right: 4px;"></span>Editar</a>'
             ]);
           });

         },
         error: function (data) {
           alert('Error:', data);
         }
     });
  }
  else {
    toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 3000});
  }
});

//Actualizar estado
function enviar(e){
  var valor= e.getAttribute('value');
  var _token = $('input[name="_token"]').val();
  $('#id_recibido').val(valor);
  $('#modal-editUser').modal('show');

  $.ajax({
       type: "POST",
       url: './config_stat_wlan',
       data: { stat : valor, _token : _token},
       success: function (data) {
         var datos = JSON.parse(data);
         $("#selectEditwlan").find('option:selected').removeAttr("selected");
         $("#selectEditwlan option[value='"+datos[0].Estado+"']").prop('selected', true);
         $('#modal-editstatuswlan').modal('show');
       },
       error: function (data) {
         alert('Error:', data);
       }
   })
}

$('#clearInput').on('click', function(){
   $('#namewlan').val('');
	 $("#selecthotel").select2("val", "");
});

$('#update_wlan').on('click', function(){
  var a0=validarSelect('selectEditwlan');
  var _token = $('input[name="_token"]').val();
  var id= $('#id_recibido').val();
  var it= $('#selectEditwlan').val();

  if (a0 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {
    $.ajax({
         type: "POST",
         url: './conf_estado_wlan',
         data: { hotel: id, estadoup: it, _token : _token},
         success: function (data) {
           if (data == 1) {
             toastr.success('Actualizado!!', 'Mensaje', {timeOut: 1000});
             $('#modal-editstatuswlan').modal('toggle');
						 generarnew();
           }
         },
         error: function (data) {
           alert('Error:', data);
         }
     });
  }
});

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

function generarnew(){
	var select_hotel= $('#selecthotel').val();
	var _token = $('input[name="_token"]').val();
	$('#tableWLAN').dataTable().fnDestroy();
	var fds= $('#tableWLAN').dataTable(config_table);
	$.ajax({
		type: "POST",
		url: '/wlanstatus',
		data: { hotel : select_hotel, _token : _token},
		success: function (data) {
			fds.fnClearTable();
			$.each(JSON.parse(data), function(index, status){
				var tokenOrig= $('#_token').val();
				if(status.Estado=='0') { estadoact='<a href="javascript:void(0);" class="btn btn-danger btn-xs btn-block"><span class="glyphicon glyphicon-thumbs-down" style="margin-right: 4px;"></span>Deshabilitada</a>'}
				if(status.Estado=='1') { estadoact='<a href="javascript:void(0);" class="btn btn-primary btn-xs btn-block"><span class="glyphicon glyphicon-thumbs-up" style="margin-right: 4px;"></span>Habilitada</a>'};
				fds.fnAddData([
					status.NombreWLAN,
					estadoact,
					'<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.id+'" class="btn btn-default btn-xs btn-block" role="button" data-target="#modal_wlan"><span class="fa fa-pencil-square-o" style="margin-right: 4px;"></span>Editar</a>'
				]);
			});

		},
		error: function (data) {
			alert('Error:', data);
		}
	});
}

$('#btnregedit').on('click', function(){
  var a0=validarInput('namewlan');
  var a1=validarSelect('selecthotel');
	var select_hotel= $('#selecthotel').val();
	var name_wlan= $('#namewlan').val();
  var _token = $('input[name="_token"]').val();

  if (a0 == false || a1 == false) {
     toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
  }
  else {

    $.ajax({
         type: "POST",
         url: './ext_wlan',
         data: { hotel : select_hotel, wlan : name_wlan,  _token : _token},
         success: function (data) {
					 if(data== 0){
					 	//toastr.success('No existe.!!', 'Mensaje', {timeOut: 1000});
						$.ajax({
				         type: "POST",
				         url: './reg_wlan',
				         data: {hotel : select_hotel, wlan : name_wlan,  _token : _token},
				         success: function (data) {
									 if(data== 1){
										 toastr.success('Agregado.!!', 'Mensaje', {timeOut: 1000});
										 generarnew();
									}
				         },
				         error: function (data) {
				           alert('Error:', data);
				         }
				     });

					 }
					 if(data== 1){
						 toastr.error('Red Existente.!!', 'Mensaje', {timeOut: 1000});
					 }
         },
         error: function (data) {
           alert('Error:', data);
         }
     });
  }
});

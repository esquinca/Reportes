@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestador')
  @section('htmlheader_title')
      {{ trans('message.results') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.results') }}
  @endsection

  @push('scripts')


  <!--<link href="{{ asset('/js/datatable/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />-->
  <script src="/js/datatable/dataTables.buttons.min.js"></script>
  <script src="/js/datatable/buttons.flash.min.js"></script>
  <script src="/js/datatable/jszip.min.js"></script>
  <script src="/js/datatable/pdfmake.min.js"></script>
  <script src="/js/datatable/vfs_fonts.js"></script>
  <script src="/js/datatable/buttons.html5.min.js"></script>
  <script src="/js/datatable/buttons.print.min.js"></script>


  <script type="text/javascript">
    $(function() {
      //table();
      $("#selectfiltro").hide();
      $("#filter_year").hide();
      $("#filter_month").hide();
      $("#filter_vertical").hide();
      $("#filter_operation").hide();
      $("#filter_average").hide();
      $("#tfoot_average").hide();

      $('#filasasw')[0].reset();
    });

    $('#boton_muestra_selectfiltro').on('click', function() {
     	$("#selectfiltro").show(10);
    });

    $(".selectFiltro").change(function() {
  		mostraryreordenar($( this).val(), $("#filtration_container") );
  	});

    function mostraryreordenar(identifier, contentElements)
    {
      contentElements.append( $('#'+identifier) ); //Para mover el div
    	$('#'+identifier).show(300);
      $("#selectfiltro").hide(100);
      $('#selectfiltro').prop('selectedIndex',0);
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

    $('#boton_muestra_selectfiltro').on('click', function() {
     	$("#selectfiltro").show(10);
      //console.log('corre el show de id selectfiltro');
    });

    $("#boton-aplica-filtro-visitantes").click(function(event) {
		  //var urlDest = baseUrl + "/result_filter";
		  var objData = $("#filasasw").find("select,textarea, input").serialize();
      //var objData = $('#filasasw').find('select, textarea, input').serialize();
      var _token = $('input[name="_token"]').val();
      //alert(objData);
      $.ajax({
           url: "/survey_viewresult",
           type: "POST",
           data: objData,
           success: function (data) {
             //alert(data)
             if ($('#searchaverage').val()=== '0') {
               tablaEnc(data, $("#example1") , 0);
               $("#tfoot_average").hide();
             }
             else {
               tablaEnctwo(data, $("#example1") , 0);
               $("#tfoot_average").show();
             }
           },
           error: function (data) {
             console.log('Error:', data);
           }
       });
    });

    function searchfechas (identificador){
      switch (identificador) {
        case '1':
          return $fecha = '<i class = "fa fa-arrow-up"></i>';
        break;
        case '2':
          return $fecha = '<i class = "fa fa-arrow-down"></i>';
        break;
        case '3':
          return $fecha = '<i class = "fa fa-arrow-right"></i>';
        break;
        case '4':
          return $fecha = '<i class = "fa fa-pause-circle-o"></i>';
        break;
        case '5':
          return $fecha = '<i class = "fa fa-window-close"></i>';
        break;
      }
    }

    function tablaEnc(datajson, table, order){
      //console.log(table);
      //console.log(order);
      //console.log(datajson);
      table.DataTable().destroy();

      var vartable = table.dataTable({
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        //
        // dom: "<'row'<'form-inline' <'col-sm-offset-0'B >l>>"
        //       +"<'row' <'form-inline' <'toolbar'> <'col-sm-10'f>>>"
        //       +"<rt>" +"<'row'<'form-inline'"
        //       +" <'col-sm-6 col-md-6 col-lg-6'l>dssd"
        //       +"<'col-sm-6 col-md-6 col-lg-6'p>>>",

        // dom: "<'row'<'form-inline' <'col-sm-offset-5'B>>>"
        //       +"<'row' <'form-inline' <'toolbar'> <'col-sm-10'f>>>"
        //       +"<rt>" +"<'row'<'form-inline'"
        //       +" <'col-sm-6 col-md-6 col-lg-6'l>dssd"
        //       +"<'col-sm-6 col-md-6 col-lg-6'p>>>",
        buttons: [
          // {
          //   text: '<i class="fa fa-user-plus"></i>',
          //   titleAttr: 'Agregar',
          //   className: 'btn btn-success',
          //   action: function(){
          //     agregar_nuevo_usuario();
          //     }
          // },
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Extraer a Excel',
            titleAttr: 'Excel',
            className: 'btn btn-info custombtntable',
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> Extraer a CSV',
            titleAttr: 'CSV',
            className: 'btn btn-danger',
          }
          // ,{
          //   extend: 'pdfHtml5',
          //   text: '<i class="fa fa-file-pdf-o"></i>',
          //   titleAttr: 'PDF',
          //   className: 'btn btn-success',
          // }
        ],
        "order": [[ order, "asc" ]],
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
      $.each(JSON.parse(datajson), function(index, status){//dd(status);
        vartable.fnAddData([
          status.Vertical,
          status.Nombre_hotel,
          status.Mes12,//Enero
          status.Mes11,
          status.Mes10,
          status.Mes9,
          status.Mes8,
          status.Mes7,
          status.Mes6,
          status.Mes5,
          status.Mes4,
          status.Mes3,
          status.Mes2,
          status.Mes1,//Diciembre
          status.anio,
          status.Promedio,
          searchfechas(status.Indicador),
          status.IT,
          '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.idcomentario+'" class="btn btn-default btn-sm" role="button" data-target="#modal-edithotcl"><span class="fa fa-comments"></span></a>',
          ]);
        });

    }

    function enviar(e){
      var valor= e.getAttribute('value');
      var _token = $('input[name="_token"]').val();
      //$('#modal-comments').modal('show');
      $('#comment_a').val('');
      $('#comment_b').val('');
      $('#comment_c').val('');
      $.ajax({
           type: "POST",
           url: './show_comments',
           data: { sector : valor, _token : _token},
           success: function (data) {
            var datos = JSON.parse(data);
            $('#comment_date').val(datos[0].Aux);
            $('#comment_a').val(datos[0].Comentario1);
            $('#comment_b').val(datos[0].Comentario2);
            $('#comment_c').val(datos[0].Comentario3);
             $('#modal-comments').modal('show');
           },
           error: function (data) {
             console.log('Error:', data);
           }
       })
    }
$("#example1").on('search.dt', function() {

});

    function tablaEnctwo(datajson, table, order){
      //console.log(table);
      //console.log(order);
      //console.log(datajson);
      table.DataTable().destroy();

      var vartable = table.dataTable({
        dom: "<'row'<'col-sm-4'B><'col-sm-4'l><'col-sm-4'f>>" +
              "<'row'<'col-sm-12'tr>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        //
        // dom: "<'row'<'form-inline' <'col-sm-offset-0'B >l>>"
        //       +"<'row' <'form-inline' <'toolbar'> <'col-sm-10'f>>>"
        //       +"<rt>" +"<'row'<'form-inline'"
        //       +" <'col-sm-6 col-md-6 col-lg-6'l>dssd"
        //       +"<'col-sm-6 col-md-6 col-lg-6'p>>>",

        // dom: "<'row'<'form-inline' <'col-sm-offset-5'B>>>"
        //       +"<'row' <'form-inline' <'toolbar'> <'col-sm-10'f>>>"
        //       +"<rt>" +"<'row'<'form-inline'"
        //       +" <'col-sm-6 col-md-6 col-lg-6'l>dssd"
        //       +"<'col-sm-6 col-md-6 col-lg-6'p>>>",
        buttons: [
          // {
          //   text: '<i class="fa fa-user-plus"></i>',
          //   titleAttr: 'Agregar',
          //   className: 'btn btn-success',
          //   action: function(){
          //     agregar_nuevo_usuario();
          //     }
          // },
          {
            extend: 'excelHtml5',
            text: '<i class="fa fa-file-excel-o"></i> Extraer a Excel',
            footer: true,
            titleAttr: 'Excel',
            className: 'btn btn-info custombtntable',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
              },
            customize: function(xlsx) {
      				var sheet = xlsx.xl.worksheets['sheet1.xml'];
      				//First row
      				$('row:first c', sheet).attr('s', '7');
      				//Search all cells for a specific text
      				$('row c', sheet).each(function() {
                if ( $(this).text() >= 9 && $(this).text() <= 10) {
                  $(this).attr( 's', '15' );
                }
                else if ( $(this).text() >= 7 && $(this).text() <9) {
                  $(this).attr( 's', '7' );
                }
                else if ($(this).text() >= 0 && $(this).text() <7 ) {
                  $(this).attr( 's', '12' );
                }
      				});
      			}
          },
          {
            extend: 'csvHtml5',
            text: '<i class="fa fa-file-text-o"></i> Extraer a CSV',
            footer: true,
            titleAttr: 'CSV',
            className: 'btn btn-danger',
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
              },
          }
          // ,{
          //   extend: 'pdfHtml5',
          //   text: '<i class="fa fa-file-pdf-o"></i> Extraer a PDF',
          //   footer: true,
          //   titleAttr: 'PDF',
          //   orientation: 'landscape',
          //   pageSize: 'LEGAL',
          //   className: 'btn bg-orange',
          //   exportOptions: {
          //     columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
          //   }
          // }
        ],
        paging: false,
        "order": [[ order, "asc" ]],
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
        },
        "columnDefs": [
          {
          "targets": 0,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData === 'Aeropuerto' ) {
                $(td).css('background-color', '#7030A0').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Educación' ) {
                $(td).css('background-color', '#0070C0').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Eventos' ) {
                $(td).css('background-color', '#2e4053').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Hospitalidad' ) {
                $(td).css('background-color', '#008081').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'MB' ) {
                $(td).css('background-color', '#a93226').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Oficinas' ) {
                $(td).css('background-color', '#333F4F').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Parques' ) {
                $(td).css('background-color', '#92D050').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Plaza' ) {
                $(td).css('background-color', '#757171').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Restaurantes' ) {
                $(td).css('background-color', '#B40431').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Retail' ) {
                $(td).css('background-color', '#F7AC25').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Kidzania' ) {
                $(td).css('background-color', '#FFD966').css('color', 'white').css('font-weight', 'bold');
              }
              if ( cellData === 'Transporte' ) {
                $(td).css('background-color', '#FF4000').css('color', 'white').css('font-weight', 'bold');
              }
            }
          },
          {
            "targets": 1,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 2,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
           },
          {
            "targets": 3,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
           },
          {
            "targets": 4,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 5,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 6,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
           },
          {
            "targets": 7,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
           },
          {
            "targets": 8,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
           },
          {
            "targets": 9,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 10,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 11,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 12,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 13,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 15,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData > 8 ) {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData >= 1 && cellData <= 6 ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
              if ( cellData > 6 && cellData <= 8 ) {
                 $(td).css('background-color', '#F8FB68').css('color', '#D18106').css('font-weight', 'bold');
              }
              if(cellData <= 0){
                $(td).css('background-color', '#cfcfcf');
              }
            }
          },
          {
            "targets": 16,
            "createdCell": function (td, cellData, rowDat1a, row, col) {
              if ( cellData == '🖒') {
                $(td).css('background-color', '#DFF2BF').css('color', 'green').css('font-weight', 'bold');
              }
              if (cellData === '☞'  ) {
                $(td).css('background-color', '#F8FB68').css('color', 'black').css('font-weight', 'bold');
              }
              if ( cellData ==='👎' ) {
                $(td).css('background-color', '#ff8a8a').css('color', 'red').css('font-weight', 'bold');
              }
            }
          }
        ],
        "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function ( i ) {
                      return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                  //CONTADOR DE ZEROS EN CADA COLUMNA
                    var nregister = api.column(2, { search:'applied' }).data().length;

                    var count_ene = api.column(2, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_feb = api.column(3, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_mzo = api.column(4, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_abr = api.column(5, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_myo = api.column(6, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_jun = api.column(7, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_jul = api.column(8, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_agto= api.column(9, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_sept= api.column(10, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_oct = api.column(11, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_nov = api.column(12, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;
                    var count_dic = api.column(13, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;

                  //SUMA EN COLUMNAS
                    var monto_ene = api.column( 2 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_feb = api.column( 3 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_mzo = api.column( 4 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_abr = api.column( 5 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_myo = api.column( 6 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_jun = api.column( 7 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_jul = api.column( 8 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_agto= api.column( 9 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_sept= api.column( 10 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_oct = api.column( 11 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_nov = api.column( 12 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    var monto_div = api.column( 13 , { search:'applied' }).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                  //Columna de Promedio
                  var count_average = api.column(15, { search:'applied' } ).data()
                              .filter( function (value, index) {
                                    return value <= 0 ? true : false;
                              }).length;

                  var monto_average = api.column( 15 , { search:'applied' }).data().reduce( function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0 );


                  //Asignación de valores
                    var nCells = row.getElementsByTagName('th');

                    nCells[1].innerHTML = 'PROMEDIO MENSUAL';
                    nCells[14].innerHTML = 'PROM. INGENIEROS';

                    if (nregister != 0){
                       //nCells[2].innerHTML =  count_ene;
                       //nCells[3].innerHTML =  nregister;
                       //nCells[4].innerHTML =  monto_ene;
                       //nCells[2].innerHTML = parseFloat( monto_ene / (nregister - count_ene) ).toFixed(2);
                       if (monto_ene != 0) { nCells[2].innerHTML = parseFloat( monto_ene / (nregister - count_ene) ).toFixed(1); } else { nCells[2].innerHTML =0; }
                       if (monto_feb != 0) { nCells[3].innerHTML = parseFloat( monto_feb / (nregister - count_feb) ).toFixed(1); } else { nCells[3].innerHTML =0; }
                       if (monto_mzo != 0) { nCells[4].innerHTML = parseFloat( monto_mzo / (nregister - count_mzo) ).toFixed(1); } else { nCells[4].innerHTML =0; }
                       if (monto_abr != 0) { nCells[5].innerHTML = parseFloat( monto_abr / (nregister - count_abr) ).toFixed(1); } else { nCells[5].innerHTML =0; }
                       if (monto_myo != 0) { nCells[6].innerHTML = parseFloat( monto_myo / (nregister - count_myo) ).toFixed(1); } else { nCells[6].innerHTML =0; }
                       if (monto_jun != 0) { nCells[7].innerHTML = parseFloat( monto_jun / (nregister - count_jun) ).toFixed(1); } else { nCells[7].innerHTML =0; }
                       if (monto_jul != 0) { nCells[8].innerHTML = parseFloat( monto_jul / (nregister - count_jul) ).toFixed(1); } else { nCells[8].innerHTML =0; }
                       if (monto_agto != 0){ nCells[9].innerHTML = parseFloat( monto_agto /(nregister -count_agto) ).toFixed(1); } else { nCells[9].innerHTML =0; }
                       if (monto_sept != 0){ nCells[10].innerHTML= parseFloat( monto_sept /(nregister -count_sept) ).toFixed(1); } else { nCells[10].innerHTML =0; }
                       if (monto_oct != 0) { nCells[11].innerHTML = parseFloat( monto_oct / (nregister - count_oct) ).toFixed(1); } else { nCells[11].innerHTML =0; }
                       if (monto_nov != 0) { nCells[12].innerHTML = parseFloat( monto_nov / (nregister - count_nov) ).toFixed(1); } else { nCells[12].innerHTML =0; }
                       if (monto_div != 0) { nCells[13].innerHTML = parseFloat( monto_div / (nregister - count_dic) ).toFixed(1); } else { nCells[13].innerHTML =0; }
                       if (monto_average != 0) { nCells[15].innerHTML = parseFloat( monto_average / (nregister - count_average) ).toFixed(1); } else { nCells[15].innerHTML =0; }
                    }
                    else {
                      nCells[2].innerHTML = 0;
                      nCells[3].innerHTML = 0;
                      nCells[4].innerHTML = 0;
                      nCells[5].innerHTML = 0;
                      nCells[6].innerHTML = 0;
                      nCells[7].innerHTML = 0;
                      nCells[8].innerHTML = 0;
                      nCells[9].innerHTML = 0;
                      nCells[10].innerHTML = 0;
                      nCells[11].innerHTML = 0;
                      nCells[12].innerHTML = 0;
                      nCells[13].innerHTML = 0;
                      nCells[15].innerHTML = 0;
                    }
        }

      });

      vartable.fnClearTable();
      $.each(JSON.parse(datajson), function(index, status){
        vartable.fnAddData([
          status.Vertical,
          status.Nombre_hotel,
          status.Mes12,//Enero
          status.Mes11,
          status.Mes10,
          status.Mes9,
          status.Mes8,
          status.Mes7,
          status.Mes6,
          status.Mes5,
          status.Mes4,
          status.Mes3,
          status.Mes2,
          status.Mes1,//Diciembre
          status.anio,
          status.Promedio,
          status.Indicador,
          status.IT,
          '<a href="javascript:void(0);" onclick="enviar(this)" value="'+status.idcomentario+'" class="btn btn-default btn-sm" role="button" data-target="#modal-edithotcl"><span class="fa fa-comments"></span></a>',
          ]);
        });

    }


  </script>
  <style>
    .nowrap {
    	white-space: nowrap;
    }
    .boton-mini {
      font-size: 14px;
      padding: 2px 6px;
    	height: 26px;
    }
    .row-separation{
      padding-top: 20px;
    }
    .rotar-th{
      -webkit-transform: rotate(-90deg);
      -moz-transform: rotate(-90deg);
      filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }
    table.dataTable thead th {
      font-size: 10px
    }
    table.dataTable tbody td {
      word-wrap:break-word !important;
      font-size: 24px
    }
    .custombtntable{
      margin-right: 3px
    }
    .fa-info {
      color:pink;
    }
    .fa-thumbs-up { color: #449D44; }
    .fa-hand-o-right { color: #EC971F; }
    .fa-thumbs-down { color: #D43F3A;}

    /*.section-hidden {
      visibility: hidden;
    }*/
  </style>

  @endpush
  @section('main-content')
  <div class="modal modal-default fade" id="modal-comments" data-backdrop="static">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>Ultimos Comentarios</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">


                <div class="col-xs-12">
                  <div class="form-group">
                    <label for="inputEditEmail" class="col-sm-12 control-label">Información</label>
                    <div class="col-sm-12">
                      <input id="comment_date" name="comment_date" type="text" class="form-control" readonly>
                    </div>
                  </div>
                </div>


                <div class="col-xs-12">
                  <div class="form-group">
                    <label for="inputEditEmail" class="col-sm-12 control-label">Comercial</label>
                    <div class="col-sm-12">
                      <textarea id="comment_a" name="comment_a"  class="form-control" style="min-width: 100%"readonly></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12">
                  <div class="form-group">
                    <label for="inputEditEmail" class="col-sm-12 control-label">Proyectos e instalaciones</label>
                    <div class="col-sm-12">
                      <textarea id="comment_b" name="comment_b" class="form-control" style="min-width: 100%" readonly></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-xs-12">
                  <div class="form-group">
                    <label for="inputEditEmail" class="col-sm-12 control-label">Soporte Tecnico</label>
                    <div class="col-sm-12">
                      <textarea id="comment_c" name="comment_c" class="form-control" style="min-width: 100%" readonly></textarea>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>

        </div>
      </div>
    </div>
  </div>


  <section class="content">
      <div class="row">
        <!-- <div class="col-md-10">
          <h4>
             Total registros:
             <span id='cifra-total'  class="label label-primary">0</span>
          </h4>
        </div> -->
        <div class="col-md-12">
          <small>Se necesita aplicar un filtro para visualizar datos</small>

        </div>
      </div>
      {!! Form::open(['action' => 'QuizResultsController@filter', 'url' => '/result_filter', 'method' => 'post', 'id' => 'filasasw']) !!}
        <div id="filtration_container" name="filtration_container">
          <div id="filter_year" name="filter_year" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Año</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchyear" name="searchyear" class="form-control">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                @foreach ($selectYear as $infoY)
                  <option value="{{ $infoY->Year1 }}"> {{ $infoY->Year1 }} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div id="filter_month" name="filter_month" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Mes</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchmonth" name="searchmonth" class="form-control">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                <!-- @foreach ($selectYear as $infoY)
                  <option value="{{ $infoY->Year1 }}"> {{ $infoY->Year1 }} </option>
                @endforeach -->
                @for ($i = 1; $i <=12; $i++)
                    <option value="{{ $i }}">
                      <?php
                      $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                      echo $mes = $mes[$i-1];
                      ?>
                    </option>
                @endfor
              </select>
            </div>
          </div>

          <div id="filter_vertical" name="filter_vertical" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Vertical</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchvertical" name="searchvertical" class="form-control" style="width: 100%;">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                @foreach ($selectVertical as $infoV)
                  <option value="{{ $infoV->Vertical }}"> {{ $infoV->Vertical }} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div id="filter_operation" name="filter_operation" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Operación</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchoperation" name="searchoperation" class="form-control" style="width: 100%;">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                <option value="CUN">Wifi Admin</option>
                <option value="CDMX">Wifimedia</option>
              </select>
            </div>
          </div>


          <div id="filter_average" name="filter_average" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Promedio</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchaverage" name="searchaverage" class="form-control" style="width: 100%;">
                <!-- <option value="" selected="selected">{{ trans('message.optionOne') }}</option> -->
                <option value="0">Sin promedio general</option>
                <option value="1">Con promedio general</option>
              </select>
            </div>
          </div>


        </div>

        <div class="form-inline row-separation">

          <button id="boton-aplica-filtro-visitantes" type="button" class="btn btn-primary">
            <i class="glyphicon glyphicon-filter" aria-hidden="true"></i> Aplicar Filtro
          </button>

          <button id='boton_muestra_selectfiltro' type="button" class="btn btn-success">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Añadir Filtro
          </button>

          <select id='selectfiltro'class ='selectFiltro' class="form-control">
            <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
            <option value="filter_year">Año</option>
            <option value="filter_month">Mes</option>
            <option value="filter_vertical">Vertical</option>
            <option value="filter_operation">Operación</option>
            <option value="filter_average">Promedio General * Mes</option>
          </select>

        </div>
      {!! Form::close() !!}

      <div class="row row-separation">
        <div class="col-md-12">
        </div>
        <div class="col-xs-12 table-responsive">
          <table id="example1" name='example1' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
            <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
            <thead >
              <tr class="bg-primary" style="background: #00A5BA;">
                <!-- <th> <small>No.</small> </th> -->
                <th> <small>Vertical</small> </th>
                <th> <small>Sitio</small> </th>
                <th> <small>En.</small> </th>
                <th> <small>Febr.</small> </th>
                <th> <small>Mzo</small> </th>
                <th> <small>Abr.</small> </th>
                <th> <small>My.</small> </th>
                <th> <small>Jun.</small> </th>
                <th> <small>Jul.</small> </th>
                <th> <small>Agto.</small> </th>
                <th> <small>Sept.</small> </th>
                <th> <small>Oct.</small> </th>
                <th> <small>Nov.</small> </th>
                <th> <small>Dic.</small> </th>
                <th> <small>Año.</small> </th>
                <th> <small>Prom.</small> </th>
                <th> <small>Ind.</small> </th>
                <th> <small>Ingeniero</small> </th>
                <th> <small >Comentario</small> </th>
              </tr>
            </thead>
            <tbody style="background: #FFFFFF;">

            </tbody>
            <tfoot id='tfoot_average'>
              <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

  </section>
  @endsection

@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'Encuestador')
  @section('htmlheader_title')
      {{ trans('message.pagenotfound') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.error') }}
  @endsection
  @section('main-content')
      <div class="error-page">
          <h2 class="headline text-yellow"> 404</h2>
          <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> {{ trans('message.emotionOps') }}! {{ trans('message.pagenotfound') }}.</h3>
              <p>
                  {{ trans('message.notfindpage') }}
                  {{ trans('message.mainwhile') }} <a href='{{ url('/home') }}'>{{ trans('message.returndashboard') }}</a>
              </p>
          </div>
      </div>
  @endsection
@endif

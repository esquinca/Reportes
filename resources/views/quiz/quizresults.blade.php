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
      $("#filter_vertical").hide();
      $("#filter_operation").hide();
      $("#filter_average").hide();
      $("#tfoot_average").hide();
    });

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
      $.each(JSON.parse(datajson), function(index, status){
        vartable.fnAddData([
          status.vertical,
          status.hotel,
          status.January,
          status.February,
          status.March,
          status.April,
          status.May,
          status.June,
          status.July,
          status.August,
          status.September,
          status.October,
          status.November,
          status.December,
          status.years,
          //'<span class="fa '+status.indicador+'"></span>'
          status.Promedio,
          status.indicador,
          status.IT
          ]);
        });

    }

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
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
             /*
             * Calculate the total market share for all browsers in this table the pagination
             */
              var iTotalMarket2 = 0;
              var iTotalMarket3 = 0;
              var iTotalMarket4 = 0;
              var iTotalMarket5 = 0;
              var iTotalMarket6 = 0;
              var iTotalMarket7 = 0;
              var iTotalMarket8 = 0;
              var iTotalMarket9 = 0;
              var iTotalMarket10 = 0;
              var iTotalMarket11 = 0;
              var iTotalMarket12 = 0;
              var iTotalMarket13 = 0;
              var iTotalMarket15 = 0;

              var totalmark=aaData.length;
              for ( var i=0 ; i<aaData.length ; i++ )
              {
                iTotalMarket2 += aaData[i][2]*1;
                iTotalMarket3 += aaData[i][3]*1;
                iTotalMarket4 += aaData[i][4]*1;
                iTotalMarket5 += aaData[i][5]*1;
                iTotalMarket6 += aaData[i][6]*1;
                iTotalMarket7 += aaData[i][7]*1;
                iTotalMarket8 += aaData[i][8]*1;
                iTotalMarket9 += aaData[i][9]*1;
                iTotalMarket10 += aaData[i][10]*1;
                iTotalMarket11 += aaData[i][11]*1;
                iTotalMarket12 += aaData[i][12]*1;
                iTotalMarket13 += aaData[i][13]*1;
                iTotalMarket15 += aaData[i][15]*1;
              }
              /* Calculate the market share for browsers on this page */
              var iPageMarket2 = 0;
              var iPageMarket3 = 0;
              var iPageMarket4 = 0;
              var iPageMarket5 = 0;
              var iPageMarket6 = 0;
              var iPageMarket7 = 0;
              var iPageMarket8 = 0;
              var iPageMarket9 = 0;
              var iPageMarket10 = 0;
              var iPageMarket11 = 0;
              var iPageMarket12 = 0;
              var iPageMarket13 = 0;
              var iPageMarket15 = 0;

              for ( var i=iStart ; i<iEnd ; i++ )
              {
                  iPageMarket2 += aaData[ aiDisplay[i] ][2]*1;
                  iPageMarket3 += aaData[ aiDisplay[i] ][3]*1;
                  iPageMarket4 += aaData[ aiDisplay[i] ][4]*1;
                  iPageMarket5 += aaData[ aiDisplay[i] ][5]*1;
                  iPageMarket6 += aaData[ aiDisplay[i] ][6]*1;
                  iPageMarket7 += aaData[ aiDisplay[i] ][7]*1;
                  iPageMarket8 += aaData[ aiDisplay[i] ][8]*1;
                  iPageMarket9 += aaData[ aiDisplay[i] ][9]*1;
                  iPageMarket10 += aaData[ aiDisplay[i] ][10]*1;
                  iPageMarket11 += aaData[ aiDisplay[i] ][11]*1;
                  iPageMarket12 += aaData[ aiDisplay[i] ][12]*1;
                  iPageMarket13 += aaData[ aiDisplay[i] ][13]*1;
                  iPageMarket15 += aaData[ aiDisplay[i] ][15]*1;
              }
              /* Modify the footer row to match what we want */
              var nCells = nRow.getElementsByTagName('th');
              nCells[0].innerHTML = 'No. Registros= '+iEnd;
              nCells[1].innerHTML = 'Promedio Por Mes: ';
              nCells[2].innerHTML = parseFloat(iPageMarket2)/iEnd;
              nCells[3].innerHTML = parseFloat(iPageMarket3)/iEnd;
              nCells[4].innerHTML = parseFloat(iPageMarket4)/iEnd;
              nCells[5].innerHTML = parseFloat(iPageMarket5)/iEnd;
              nCells[6].innerHTML = parseFloat(iPageMarket6)/iEnd;
              nCells[7].innerHTML = parseFloat(iPageMarket7)/iEnd;
              nCells[8].innerHTML = parseFloat(iPageMarket8)/iEnd;
              nCells[9].innerHTML = parseFloat(iPageMarket9)/iEnd;
              nCells[10].innerHTML = parseFloat(iPageMarket10)/iEnd;
              nCells[11].innerHTML = parseFloat(iPageMarket11)/iEnd;
              nCells[12].innerHTML = parseFloat(iPageMarket12)/iEnd;
              nCells[13].innerHTML = parseFloat(iPageMarket13)/iEnd;
              nCells[14].innerHTML = 'Promedio General: ';
              nCells[15].innerHTML = parseFloat(iPageMarket15)/iEnd;

        }
        // "fnFooterCallback": function(nFoot, aData, iStart, iEnd, aiDisplay) {
        //     nFoot.getElementsByTagName('th')[0].innerHTML = "Starting index is " + iStart;
        // }
        // "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //     // Bold the grade for all 'A' grade browsers
        //     if (aData[4]) {
        //         $('td:eq(4)', nRow).html('<b>A</b>');
        //     }
        // },
        // "fnInfoCallback": function (oSettings, iStart, iEnd, iMax, iTotal, sPre) {
        //     return iStart + " to " + iEnd;
        // }
        // "fnHeaderCallback": function (nHead, aData, iStart, iEnd, aiDisplay) {
        //    nHead.getElementsByTagName('th')[0].innerHTML = "Displaying " + (iEnd - iStart) + " records";
        // }


      });

      vartable.fnClearTable();
      $.each(JSON.parse(datajson), function(index, status){
        vartable.fnAddData([
          status.vertical,
          status.hotel,
          status.January,
          status.February,
          status.March,
          status.April,
          status.May,
          status.June,
          status.July,
          status.August,
          status.September,
          status.October,
          status.November,
          status.December,
          status.years,
          //'<span class="fa '+status.indicador+'"></span>'
          status.Promedio,
          status.indicador,
          status.IT
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

          <div id="filter_vertical" name="filter_vertical" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Vertical</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchvertical" name="searchvertical" class="form-control" style="width: 100%;">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                <option value="Educación">Educación</option>
                <option value="Hospitalidad">Hospitalidad</option>
                <option value="Retail">Retail</option>
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
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Operación</strong>
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
                <!--
                <th> <small >Comentario</small> </th> -->
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

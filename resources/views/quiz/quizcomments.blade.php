@extends('layouts.app')

  @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestador')
    @section('htmlheader_title')
        {{ trans('message.resultscomment') }}
    @endsection
    @section('contentheader_title')
        {{ trans('message.resultscomment') }}
    @endsection

    @push('scripts')
    <script src="/js/datatable/dataTables.buttons.min.js"></script>
    <script src="/js/datatable/buttons.flash.min.js"></script>
    <script src="/js/datatable/jszip.min.js"></script>
    <script src="/js/datatable/pdfmake.min.js"></script>
    <script src="/js/datatable/vfs_fonts.js"></script>
    <script src="/js/datatable/buttons.html5.min.js"></script>
    <script src="/js/datatable/buttons.print.min.js"></script>
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
        font-size: 10px
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
    <script type="text/javascript">
      $(function() {
        //table();
        $("#selectfiltro").hide();
        $("#filter_year").hide();
        $("#filter_hotel").hide();
        $("#filter_ingeniere").hide();
        $("#filter_average").hide();
        $("#tfoot_average").hide();

        $('#filasasw')[0].reset();
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
             url: "/result_filter_comments",
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
            status.Nombre_hotel,
            status.Calificacion,
            status.Mes,
            status.Year1,
            status.Comercial,
            status.Proyecto,
            status.Soporte,
            status.IT,
            ]);
          });

      }


    </script>

    @endpush

    @section('main-content')
    <section class="content">
        <div class="row">
          <div class="col-md-12">
            <small>Se necesita aplicar un filtro para visualizar comentarios</small>
          </div>
        </div>
        {!! Form::open(['action' => 'QuizCommentsController@store', 'url' => '/result_filter_comments', 'method' => 'post', 'id' => 'filasasw']) !!}
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

            <div id="filter_hotel" name="filter_hotel" class="row row-separation control-filter">
              <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
                 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Hotel</strong>
              </div>
              <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
                <select id="searchhotel" name="searchhotel" class="form-control" style="width: 100%;">
                  <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                  @foreach ($selectHotel as $infoA)
                    <option value="{{ $infoA->hotels_id }}"> {{ $infoA->Nombre_hotel }} </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div id="filter_ingeniere" name="filter_ingeniere" class="row row-separation control-filter">
              <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
                 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Ingeniero</strong>
              </div>
              <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
                <select id="searchuser" name="searchuser" class="form-control" style="width: 100%;">
                  <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                    @foreach ($selectUser as $infoU)
                      <option value="{{ $infoU->user_reportes_id }}"> {{ $infoU->nombrecomp }} </option>
                    @endforeach

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
              <option value="filter_hotel">Hotel</option>
              <option value="filter_ingeniere">Ingeniero</option>
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
                  <th> <small >Hotel</small> </th>
                  <th> <small>Calificación.</small> </th>
                  <th> <small>Mes.</small> </th>
                  <th> <small>Año.</small> </th>
                  <th> <small>Comentario Comercial</small> </th>
                  <th> <small>Comentario Proyectos e instalaciones</small> </th>
                  <th> <small>Comentario Soporte Tecnico.</small> </th>
                  <th> <small>Ingeniero</small> </th>
                </tr>
              </thead>
              <tbody style="background: #FFFFFF;">

              </tbody>

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

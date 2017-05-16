@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.viewreport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.viewreport') }}
  @endsection

  @push('scripts')
  <!--DataTables-->
  <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/reports/script_reports.js"></script>
  <script src="/plugins/echarts/echarts.js"></script>

  <script type="text/javascript">
  (function ($) {
    $.fn.countTo = function (options) {
      options = options || {};

        return $(this).each(function () {
          // set options for current element
          var settings = $.extend({}, $.fn.countTo.defaults, {
            from:            $(this).data('from'),
            to:              $(this).data('to'),
            speed:           $(this).data('speed'),
            refreshInterval: $(this).data('refresh-interval'),
            decimals:        $(this).data('decimals')
          }, options);

          // how many times to update the value, and how much to increment the value on each update
          var loops = Math.ceil(settings.speed / settings.refreshInterval),
            increment = (settings.to - settings.from) / loops;

          // references & variables that will change with each update
          var self = this,
            $self = $(this),
            loopCount = 0,
            value = settings.from,
            data = $self.data('countTo') || {};

          $self.data('countTo', data);

          // if an existing interval can be found, clear it first
          if (data.interval) {
            clearInterval(data.interval);
          }
          data.interval = setInterval(updateTimer, settings.refreshInterval);

          // initialize the element with the starting value
          render(value);

          function updateTimer() {
            value += increment;
            loopCount++;

            render(value);

            if (typeof(settings.onUpdate) == 'function') {
              settings.onUpdate.call(self, value);
            }

            if (loopCount >= loops) {
              // remove the interval
              $self.removeData('countTo');
              clearInterval(data.interval);
              value = settings.to;

              if (typeof(settings.onComplete) == 'function') {
                settings.onComplete.call(self, value);
              }
            }
          }

          function render(value) {
            var formattedValue = settings.formatter.call(self, value, settings);
            $self.html(formattedValue);
          }
        });
      };

      $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
      };

      function formatter(value, settings) {
        return value.toFixed(settings.decimals);
      }
    }(jQuery));

    jQuery(function ($) {
      // custom formatting example
      $('.count-number').data('countToOptions', {
      formatter: function (value, options) {
        return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
      }
      });

      // start all the timers
      $('.timer').each(count);

      function count(options) {
      var $this = $(this);
      options = $.extend({}, options || {}, $this.data('countToOptions') || {});
      $this.countTo(options);
      }
  });


  require.config({
       paths: {
           echarts: './plugins/echarts/'
       }
   });
   require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/pie',
            'echarts/chart/line',
            'echarts/chart/map'
        ],
        function (ec) {
            //--- Pastel ---
            var myChart = ec.init(document.getElementById('main'));
            optionOne= {
                title : {
                    text: 'Antemas mas utilizadas',
                    subtext: 'Pastel & Lineas',
                    x:'center'
                },
                tooltip : {
                    formatter: "{a} <br/>{b} : {c} ({d}%)",
                    trigger: 'axis'
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['PortoBello','CasaLasIslas','Lobbie','Recepsion','Vip']
                },
                calculable : true,
                series : [
                  {
                      name:'Grafica de pasteles',
                      type:'pie',
                      radius : '55%',
                      center: ['50%', 225],
                      data:[
                          {value:335, name:'PortoBello'},
                          {value:310, name:'CasaLasIslas'},
                          {value:234, name:'Lobbie'},
                          {value:135, name:'Recepsion'},
                          {value:1548, name:'Vip'}
                      ]
                  }

                ]
            };
            myChart.setOption(optionOne);
            // --- Líneas ---
            var myChart2 = ec.init(document.getElementById('mainMap'));
            optionTwo= {
              tooltip : {
                  trigger: 'axis',
                  axisPointer : {
                      type: 'shadow'
                  }
              },
              legend: {
                  data:['PortoBello','CasaLasIslas','Lobbie','Recepsion','Vip']
              },
              toolbox: {
                  show : false,
                  orient : 'vertical',
                  y : 'center',
                  feature : {
                      mark : {show: true},
                      magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                      restore : {show: true},
                      saveAsImage : {show: true}
                  }
              },
              calculable : true,
              xAxis : [
                  {
                      type : 'category',
                      data : ['L','M','M','J','V','S','D']
                  }
              ],
              yAxis : [
                  {
                      type : 'value',
                      splitArea : {show : true}
                  }
              ],
              grid: {
                  x2:40
              },
              series : [
                  {
                      name:'PortoBello',
                      type:'line',
                      stack: 'La cantidad total',
                      data:[320, 332, 301, 334, 390, 330, 320]
                  },
                  {
                      name:'CasaLasIslas',
                      type:'line',
                      stack: 'La cantidad total',
                      data:[120, 132, 101, 134, 90, 230, 210]
                  },
                  {
                      name:'Lobbie',
                      type:'line',
                      stack: 'La cantidad total',
                      data:[220, 182, 191, 234, 290, 330, 310]
                  },
                  {
                      name:'Recepsion',
                      type:'line',
                      stack: 'La cantidad total',
                      data:[150, 232, 201, 154, 190, 330, 410]
                  },
                  {
                      name:'Vip',
                      type:'line',
                      stack: 'La cantidad total',
                      data:[820, 932, 901, 934, 1290, 1330, 1320]
                  }
              ]
            };
            myChart2.setOption(optionTwo);

            // --- Líneas ---
            var myChart3 = ec.init(document.getElementById('maingb'));
            optionThree= {
              title : {
                  text: 'Gigabytes transmitidos por día',
                  subtext: 'Grafica de Lineas'
              },
              tooltip : {
                  trigger: 'axis',
              },
              legend: {
                  x: 'right',
                  data:['PortoBello','CasaLasIslas','Lobbie','Recepsion','Vip']
              },
              toolbox: {
                  show : false,
                  orient : 'vertical',
                  y : 'center',
                  feature : {
                      mark : {show: true},
                      magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                      restore : {show: true},
                      saveAsImage : {show: true}
                  }
              },
              calculable : true,
              xAxis : [
                  {
                      type : 'category',
                      boundaryGap : false,
                      data : ['L','M','M','J','V','S','D']
                  }
              ],
              yAxis : [
                  {
                      type : 'value',

                  }
              ],
              grid: {
                  x2:40
              },
              series : [
                  {
                      name:'PortoBello',
                      type:'line',
                      stack: 'La cantidad total',
                      smooth:true,
                      itemStyle: {normal: {areaStyle: {type: 'default'}}},
                      data:[320, 332, 301, 334, 390, 330, 320]
                  },
                  {
                      name:'CasaLasIslas',
                      type:'line',
                      stack: 'La cantidad total',
                      smooth:true,
                      itemStyle: {normal: {areaStyle: {type: 'default'}}},
                      data:[120, 132, 101, 134, 90, 230, 210]
                  },
                  {
                      name:'Lobbie',
                      type:'line',
                      stack: 'La cantidad total',
                      smooth:true,
                      itemStyle: {normal: {areaStyle: {type: 'default'}}},
                      data:[220, 182, 191, 234, 290, 330, 310]
                  },
                  {
                      name:'Recepsion',
                      type:'line',
                      stack: 'La cantidad total',
                      smooth:true,
                      itemStyle: {normal: {areaStyle: {type: 'default'}}},
                      data:[150, 232, 201, 154, 190, 330, 410]
                  },
                  {
                      name:'Vip',
                      type:'line',
                      stack: 'La cantidad total',
                      smooth:true,
                      itemStyle: {normal: {areaStyle: {type: 'default'}}},
                      data:[820, 932, 901, 934, 1290, 1330, 1320]
                  }
              ]
            };
            myChart3.setOption(optionThree);

            //--- Barras Horizontales---
            var myChart4 = ec.init(document.getElementById('mainuser'));
            optionfour =  {
                title : {
                    text: 'Usuarios registrados por día',
                    subtext: 'Grafica de Barras'
                },
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                    }
                },
                legend: {
                    x: 'right',
                    data:['Usuarios']
                },
                toolbox: {
                    show : false,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'value'
                    }
                ],
                yAxis : [
                    {
                        type : 'category',
                        data : ['1','2','3','4','5','6','7']
                    }
                ],
                series : [
                    {
                        name:'Usuarios',
                        type:'bar',
                        stack: 'La cantidad total',
                        itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                        data:[820, 832, 901, 934, 1290, 1330, 1320]
                    }
                ]
            };
            myChart4.setOption(optionfour);

            myChart.connect(myChart2);
            myChart2.connect(myChart);
            setTimeout(function (){
                window.onresize = function () {
                    myChart.resize();
                    myChart2.resize();
                    myChart3.resize();
                    myChart4.resize();
                }
            },200);

        }
    );

    function tablaComparar(){
      var id= $('#select_one').val();
      var _token = $('input[name="_token"]').val();
      var TablaCompararMes= $('#tabla_comparativa').dataTable({
        "order": [[ 0, "asc" ]],
        paging: false,
    	  bFilter: false,
        "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
    		//ordering: false,
        "pagingType": "simple",
        "pageLength": 5,
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

      /*
      $.ajax({
        type: "POST",
        url: "./generar_comp",
        data: { numero : id , _token : _token },
        success: function (data){
          TablaCompararMes.fnClearTable(); //Este codigo es para la tabla
          $.each(JSON.parse(data),function(index, objdataTable){
            //Inicio el codigo para generar la tabla
            TablaCompararMes.fnAddData([
              objdataTable.Nombre,
              objdataTable.CantidadA,
              objdataTable.CantidadB,
              objdataTable.CantidadC
            ]);
          });
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
      */

      /*
      $.get('/generar_comp',function(data){
            TablaCompararMes.fnClearTable(); //Este codigo es para la tabla
            //Este codigo de abajo es para graficar
            $.each(JSON.parse(data), function(index, objdataTable){
              //Inicio el codigo para generar la tabla
              TablaCompararMes.fnAddData([
    						objdataTable.Nombre,
    						objdataTable.CantidadA,
    						objdataTable.CantidadB,
    						objdataTable.CantidadC
              ]);
            });
      });
      */

    };
    (function(){
    		$('#generateInfo').on('click', function() {
    			$('#tabla_comparativa').DataTable().destroy();
    			tablaComparar();
    		});
    })();

  </script>
  <style type="text/css">
  .bloque{
    color: #F15D24;
    float: left;
    border: 3px solid #09347A;
    padding-top: 40px;
    width: auto;
    height: auto;
    margin: 10px;
    padding-bottom: 40px;
  }
  </style>
  @endpush
  @section('main-content')

  <section class="content">
    <section class="seleccion">
      <div class="row">
        <div class="col-xs-12">

          <!-- SELECT2 EXAMPLE -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Captura</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                   {{ csrf_field() }}
                  <form class="form-inline">
                    <div>
                      <div class="form-group">
                        <label for="select_one">Seleccione el Hotel: </label>
                        <select class="form-control select2" id="select_one">
                          <option value="" selected>{{ trans('message.optionOne')}}</option>
                          @foreach ($selectDatahotel as $info)
                          <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="select_two">Tipo de reporte: </label>
                        <select class="form-control select2" id="select_two">
                          <option value="" selected>{{ trans('message.optionOne')}}</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="select_two">Mes: </label>
                        <select class="form-control select2" id="select_month">
                          <option value="" selected>{{ trans('message.optionOne')}}</option>
                          <option value="" >{{ trans('message.optionOne')}}</option>
                          <option value="" >{{ trans('message.optionOne')}}</option>
                          <option value="" >{{ trans('message.optionOne')}}</option>
                          <option value="" >{{ trans('message.optionOne')}}</option>
                          <option value="" >{{ trans('message.optionOne')}}</option>

                        </select>
                      </div>
                      <div class="form-group">
                        <label for="select_two">Año: </label>
                        <select class="form-control select2" id="select_month">
                          <option value="" selected>{{ trans('message.optionOne')}}</option>
                          <option value="2017" >2017</option>
                        </select>
                      </div>
                      <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> Generar</a>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            </div>
          </div>

        </div>
      </div>
    </section>

    <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-bookmark-o"> Reporte mensual</i>
            <small class="pull-right"> Fecha: <?php $now = new DateTime(); echo $now->format('d-m-Y'); ?></small>
          </h2>
        </div>
      </div>
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <img style="text-align: center;" src="{{ asset ('../img/logo_sit.png') }}" width="50%" height="50%" class="img-responsive">
        </div>
        <div class="col-sm-4 invoice-col">
          <address style="display: inline-block;">
            <strong style="display: inline-block;"><h3> Reporte de uso y estadisticas</h3> </strong><br>
            <strong style="display: inline-block;"><h4> Red wifi huespedes / colaboradores</h4> </strong><br>
            <strong style="display: inline-block;"><h5> Nombre Hotel</h5> </strong>
          </address>
        </div>
        <div class="col-sm-4 invoice-col">
          <img style="text-align: center;" src="{{ asset ('../img/logo_sit.png') }}" width="50%" height="50%" class="img-responsive">
        </div>
      </div>

      <div class="row text-center">
        <div id="graphic" class="col-md-12">
            <div id="main" style="height:400px; width: 50%;float:left; margin-right:0;padding-right:0;border-right-width:0;  "></div>
            <div id="mainMap" style="height:400px; width: 50%;float:right; margin-left:0;padding-left:0;border-left-width:0; "></div>
        </div>
      </div>

      <div id="animated-number" class="row text-center">
        <div class="col-sm-2 bloque" >
          <i class="fa fa-rss fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <strong>Antenas</strong><br>
          <strong>totales</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-upload fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <strong>Gigabytes Max por</strong><br>
          <strong>dia</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-download fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <strong>Gigabytes Min por</strong><br>
          <strong>dia</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-users fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <strong>Promedio de usuario</strong><br>
          <strong>diario</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-calendar fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <strong>Total de usuarios</strong><br>
          <strong>mensual</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-tablet fa-2x"></i>
          <h2 class="timer count-title count-number" data-to="11900" data-speed="1500"></h2>
          <strong>Rogue</strong><br>
          <strong>devices</strong>
        </div>
      </div>

      <div class="row text-center">
        <div id="graphicgbytes" class="col-md-12">
            <div id="maingb" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>
      <div class="row text-center">
        <div id="graphicusers" class="col-md-12">
            <div id="mainuser" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-sm-12">
          <h4><b>Comparativo Mes Actual vs Mes Anterior</b></h4>
        </div>
        <div class="col-sm-4">
          <table id="tabla_comparativa" name='tabla_comparativa' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
            <thead >
              <tr class="bg-primary" style="background: #FF851B; font-size: 11.5px;">
                <th>MES</th>
                <th>Prom. USUARIOS POR DIA</th>
                <th>GIGABYTES POR DÍA</th>
                <th>ROGUE DEVICES</th>
                <th>DIF %</th>
              </tr>
            </thead>
            <tbody style="font-size: 11.5px;">
              <tr>
                <td>Abril</td>
                <td>1934</td>
                <td>4200</td>
                <td>7253</td>
                <td>1%</td>
	            </tr>
              <tr>
                <td>Mayo</td>
                <td>1949</td>
                <td>4000</td>
                <td>7309</td>
                <td>1%</td>
	            </tr>
            </tbody>
          </table>
        </div>
        <div class="col-sm-8">
          <div id="graphicComp" class="col-md-12">
              <div id="maincomp" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
          </div>
        </div>
      </div>
      <div class="row text-center">
        <h4><b>Observaciones</b></h4>
        <div id="textObserv" class="col-md-12">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </p>
        </div>
      </div>

    </section>
  </section>


  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'IT')
  @section('htmlheader_title')
      {{ trans('message.pagenotfound') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.404error') }}
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

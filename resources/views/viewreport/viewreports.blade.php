@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.viewreport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.viewreport') }}
  @endsection

  @push('scripts')
  <script src="/plugins/moment/moment-with-locales.js"></script>
  <!--DataTables-->
  <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/reports/script_reports.js"></script>
  <script src="/plugins/echarts/echarts.js"></script>
  <style>
  .info-box-content{
    margin-left: 70px;
  }
  .info-box-icon{
    height: 70px;
    width: 70px;
    line-height: 70px;
  }
  .info-box {
    min-height:70px;
    box-shadow: 0 0px 0px rgba(0, 0, 0, 0.1);
  }
  .media.service-box {
    margin: 5px 0;
  }
  .media.service-box .pull-left {
    margin-right: 20px;
  }
  .media.service-box .pull-left > i {
    font-size: 24px;
    height: 64px;
    line-height: 64px;
    text-align: center;
    width: 64px;
    border-radius: 100%;
    color: #09347A; /*Cambias el color de los fa icons*/
    box-shadow: inset 0 0 0 1px #d7d7d7;
    -webkit-box-shadow: inset 0 0 0 1px #d7d7d7;
    transition: background-color 400ms, background-color 400ms;
    position: relative;
  }
  .media.service-box .pull-left > i:after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    margin-top: -10px;
    right: -10px;
    border: 4px solid #fff;
    border-radius: 20px;
    background: #FD602D; /*Cambias el color de los circulos junto a los fa icons*/
  }
  .media.service-box:hover .pull-left > i { /*Cambias el fondo de los circulos de los fa icons*/
    /*
    background-image: -moz-linear-gradient(90deg, #fd602d 0%, #fd602d 100%);
    background-image: -webkit-linear-gradient(90deg, #fd602d 0%, #fd602d 100%);
    background-image: -ms-linear-gradient(90deg, #fd602d 0%, #fd602d 100%);
    color: #fff;
    */
    box-shadow: inset 0 0 0 5px rgba(255, 255, 255, 0.8);
    -webkit-box-shadow: inset 0 0 0 5px rgba(255, 255, 255, 0.8);
  }
  .margin_div{
    /*box-shadow: 0px 1px 4px -1PX #27727B;*/
    margin-top: 16px;
  }
  </style>
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

    function graficas(){
      var hotel= $('#select_one').val();
      var tipo_rep= $('#select_two').val();
      var calendario= $('#calendar_fecha').val();
      var _token = $('input[name="_token"]').val();

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
              var myChart = ec.init(document.getElementById('mainuser'));
              var datausergraf1 = [];
              var datausergraf2 = [];

              $.ajax({
                type: "POST",
                url: "./consultshowgrafone",
                data: { number : hotel, mes: calendario,  _token : _token },
                success: function (data){
                  $.each(JSON.parse(data),function(index, objdata){
                    datausergraf1.push(objdata.Dia);
                    datausergraf2.push(objdata.NumClientes);
                  });
                  var optiongrafusuarios= {
                      title : {
                          text: 'Cantidad de Usuarios',
                          subtext: calendario
                      },
                      tooltip : {
                          trigger: 'axis'
                      },
                      legend: {
                          x: 'right',
                          y: 'top',
                          data:['Estatus']
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
                              type : 'category',
                              boundaryGap : false,
                              data: datausergraf1
                              //data : ['1','2','3','4','5','6','7','8', '9']
                          }
                      ],
                      yAxis : [
                          {
                              type : 'value'
                          }
                      ],
                      series : [
                          {
                              name:'Estatus',
                              type:'line',
                              smooth:true,
                              itemStyle: {normal: {areaStyle: {type: 'default'}}},
                              data: datausergraf2
                              //data:[1320, 0, 1132, 601, 234, 120, 90, 20]
                          }
                      ]
                  };
                  myChart.setOption(optiongrafusuarios);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });


              setTimeout(function (){
                  window.onresize = function () {
                      myChart.resize();
                  }
              },200);
            }
      );
    }

    function grafica_radar(){
      var hotel= $('#select_one').val();
      var tipo_rep= $('#select_two').val();
      var calendario= $('#calendar_fecha').val();
      var _token = $('input[name="_token"]').val();

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
              var myChart2 = ec.init(document.getElementById('mainwlan'));
              var datawlangraf1 = [];
              var datawlangraf2 = [];
              var nuevos_valores= [];
              $.ajax({
                type: "POST",
                url: "./consultshowgraftwo",
                data: { number : hotel, mes: calendario,  _token : _token },
                success: function (data){
                  $.each(JSON.parse(data),function(index, objdata){
                    datawlangraf1.push(objdata.NombreWLAN);
                    datawlangraf2.push(objdata.ClientesWLAN);
                  });
                  //alert(datawlangraf2);
                  var datass2 = [];
                  for (var j = 0; j < datawlangraf1.length; j++) {
                    var datoss = datawlangraf2[j];
                    var datass = datawlangraf1[j] + " = " + datawlangraf2[j];
                    var b = {"value": datoss, "name": datass};
                    nuevos_valores.push(b);
                    datass2.push(datass);
                    //{value: i * 8  + 1280, name:'I8-'},
                  }

                  var optiongrafusuarios={
                      title : {
                          text: 'Estado',
                          subtext: 'WLAN',
                          x:'right',
                          y:'bottom'
                      },
                      tooltip : {
                          trigger: 'item',
                          formatter: "{a} <br/>{b} : {c} ({d}%)"
                      },
                      legend: {
                          orient : 'vertical',
                          x : 'left',
                          data: datass2
                          //data:['Chrome','Firefox','Safari','IE9+','IE8-']
                      },
                      toolbox: {
                          show : false,
                          feature : {
                              mark : {show: true},
                              dataView : {show: true, readOnly: false},
                              restore : {show: true},
                              saveAsImage : {show: true}
                          }
                      },
                      calculable : false,
                      series : (function (){
                          var series = [];
                          for (var i = 0; i < 30; i++) {

                              series.push({
                                  name:'Estatus WLAN',
                                  type:'pie',
                                  itemStyle : {normal : {
                                      label : {show : i > 28},
                                      labelLine : {show : i > 28, length:20}
                                  }},
                                  radius : [i * 4 + 40, i * 4 + 43],
                                  data: nuevos_valores
                                  /*
                                  data: [
                                    { value: i * 8 + 0, name:'...WIFIMEDIA_Free'},
                                    { value: i * 8 + 0, name:'DemoSW'},
                                    { value: i * 8 + 0, name:'Fontan_Ixtapa'},
                                    { value: i * 8 + 42, name:'oficina'},
                                    { value: i * 8 + 0, name:'redprueba'},
                                    { value: i * 8 + 41, name:'SITWIF1'}
                                  ]
                                  */
                              })
                          }
                          series[0].markPoint = {
                              symbol:'emptyCircle',
                              symbolSize:series[0].radius[0],
                              effect:{show:true,scaleSize:12,color:'rgba(250,225,50,0.8)',shadowBlur:10,period:30},
                              data:[{x:'50%',y:'50%'}]
                          };
                          return series;
                      })()
                  };
                  myChart2.setOption(optiongrafusuarios);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
              setTimeout(function (){
                  var _ZR = myChart2.getZrender();
                  var TextShape = require('zrender/shape/Text');
                  _ZR.addShape(new TextShape({
                      style : {
                          x : _ZR.getWidth() / 2,
                          y : _ZR.getHeight() / 2,
                          color: '#666',
                          text : '',
                          textAlign : 'center'
                      }
                  }));
                  _ZR.addShape(new TextShape({
                      style : {
                          x : _ZR.getWidth() / 2 + 300,
                          y : _ZR.getHeight() / 2,
                          brushType:'fill',
                          color: 'orange',
                          text : 'Representación',
                          textAlign : 'left',
                          textFont:'normal 20px 微软雅黑'
                      }
                  }));
                  _ZR.refresh();
                  window.onresize = function () {
                    //myChart2.resize();
                  }
              }, 2000);
            }
      );
    };

    function grafica_bar(){
      var hotel= $('#select_one').val();
      var tipo_rep= $('#select_two').val();
      var calendario= $('#calendar_fecha').val();
      var _token = $('input[name="_token"]').val();

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
              var myChart3 = ec.init(document.getElementById('maintopssid'));
              var datawbargraf1 = [];
              var datawbargraf2 = [];
              $.ajax({
                type: "POST",
                url: "./consultshowgrafthree",
                data: { number : hotel, mes: calendario,  _token : _token },
                success: function (data){
                  $.each(JSON.parse(data),function(index, objdata){
                    datawbargraf1.push(objdata.NombreWLAN);
                    datawbargraf2.push(objdata.ClientesWLAN);
                  });
                  var optiongrassid= {
                      title : {
                          text: 'Representación Grafica',
                          //subtext: 'Grafica de Barras'
                      },
                      tooltip : {
                          trigger: 'axis'
                      },
                      legend: {
                          show : false,
                          x: 'right',
                          y: 'bottom',
                          data:['TOP']
                      },
                      toolbox: {
                          show : false,
                          feature : {
                              mark : {show: true},
                              dataView : {show: true, readOnly: false},
                              magicType : {show: true, type: ['line', 'bar']},
                              restore : {show: true},
                              saveAsImage : {show: true}
                          }
                      },
                      calculable : true,
                      xAxis : [
                          {
                              type : 'category',
                              data : datawbargraf1,
                              axisLabel:{
                                           //interval:0,
                                           //rotate:35,
                                           //margin:2,
                                           textStyle:{
                                               color:"#222",
                                               fontSize : '10'
                                           }
                                       },
                          }
                      ],
                      grid: { // 控制图的大小，调整下面这些值就可以，
                                 x: 50,
                                 x2: 50,
                                 y2: 100,// y2可以控制 X轴跟Zoom控件之间的间隔，避免以为倾斜后造成 label重叠到zoom上
                      },
                      yAxis : [
                            {
                                type : 'value',
                                axisLabel : {
                                    //formatter: '{value}%',
                                    textStyle : {
                                      fontSize : '9',
                                      margin:2,
                                    }
                                }
                            }
                      ],
                      series : [
                            {
                                name:'TOP',
                                type:'bar',
                                itemStyle: {
                                              normal: {
                                                label : {
                                                  show: true,
                                                  position: 'top',
                                                formatter: '{c}',
                                                  textStyle: {
                                                    color: '#000',
                                                    fontSize : '9'

                                                  }
                                                },
                                                color: function(params) {
                                                  // build a color map as your need.
                                                  var colorList = [
                                                  '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                                                  '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                                                  '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                                                  ];
                                                  return colorList[params.dataIndex]
                                                }
                                              }
                                            },
                                data: datawbargraf2,
                                //data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                            },
                      ]
                  };
                  myChart3.setOption(optiongrassid);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
              setTimeout(function (){
                  window.onresize = function () {
                    myChart3.resize();
                  }
              }, 2000);

            }
        );
    }

    function grafica_pie(){
      var hotel= $('#select_one').val();
      var tipo_rep= $('#select_two').val();
      var calendario= $('#calendar_fecha').val();
      var _token = $('input[name="_token"]').val();

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
              var myChart4 = ec.init(document.getElementById('mainaps'));
              var datapiegraf1 = [];
              var datapiegraf2 = [];
              $.ajax({
                type: "POST",
                url: "./consultshowgraffour",
                data: { number : hotel, mes: calendario,  _token : _token },
                success: function (data){
                  $.each(JSON.parse(data),function(index, objdata){
                    datapiegraf1.push(objdata.Descripcion);
                    datapiegraf2.push(objdata.NumClientes);
                  });
                  var optiongrafpie= {
                        title : {
                            text: 'Top aps',
                            subtext: '',
                            x:'center'
                        },
                        tooltip : {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            orient : 'vertical',
                            x : 'left',
                            y : 'top',
                            data:['rose1','rose2','rose3','rose4','rose5','rose6','rose7','rose8']
                        },
                        toolbox: {
                            show : true,
                            feature : {
                                mark : {show: true},
                                dataView : {show: true, readOnly: false},
                                magicType : {
                                    show: true,
                                    type: ['pie', 'funnel']
                                },
                                restore : {show: true},
                                saveAsImage : {show: true}
                            }
                        },
                        calculable : true,
                        series : [
                          	 {
                                name:'Estatus',
                                type:'pie',
                                radius : [30, 110],
                                center : ['50%','50%'],
                                roseType : 'area',
                                x: '50%',               // for funnel
                                max: 40,                // for funnel
                                sort : 'ascending',     // for funnel
                                data:[
                                    {value:10, name:'rose1'},
                                    {value:5, name:'rose2'},
                                    {value:15, name:'rose3'},
                                    {value:25, name:'rose4'},
                                    {value:20, name:'rose5'},
                                    {value:35, name:'rose6'},
                                    {value:30, name:'rose7'},
                                    {value:40, name:'rose8'}
                                ]
                            }
                        ]
                  };
                  myChart4.setOption(optiongrafpie);
                },
                error: function (data) {
                  console.log('Error:', data);
                }
              });
              setTimeout(function (){
                  window.onresize = function () {
                    myChart4.resize();
                  }
              }, 2000);

            }
        );
    }

    (function(){
    		$('#generateInfo').on('click', function() {
          /*
          var hotel= $('#select_one').val();
          var tipo_rep= $('#select_two').val();
          var calendario= $('#calendar_fecha').val();
          var _token = $('input[name="_token"]').val();
          */
          grafica_radar();
          graficas();
          grafica_bar();
          grafica_pie();
          //dpsap();
          /*
          $.ajax({
            type: "POST",
            url: "./consultcuadros",
            data: { number : hotel, type: tipo_rep, mes: calendario,  _token : _token },
            success: function (data){
              $.each(JSON.parse(data),function(index, objdata){
                $('#total_aps').attr("data-to", objdata.AP);
                $('#gb_max_dia').attr("data-to", objdata.MaxGBv);
                $('#gb_min_dia').attr("data-to", objdata.MinGBv);
                $('#prom_usuario').attr("data-to", objdata.TOTALUSER);
                $('#total_usuario').attr("data-to", objdata.MaxClientes);
                $('#rogue_mes').attr("data-to", objdata.RogueDevice);
              });
            },
            error: function (data) {
              console.log('Error:', data);
            }
          });

    			$('#tabla_comparativa').DataTable().destroy();
    			tablaComparar();
          */


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
                        <label for="select_two">Tipo: </label>
                        <select class="form-control select2" id="select_two">
                          <option value="" selected>{{ trans('message.optionOne')}}</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="calendar_fecha">Fecha:</label>
                        <input type="text" class="form-control" id="calendar_fecha">
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
            <i style="color: #FC4A00"class="fa fa-th-large"></i> {{ trans('message.empresa') }}.
            <small class="pull-right"> Fecha: <?php $now = new DateTime(); echo $now->format('d-m-Y'); ?></small>
          </h2>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 text-center">
          <div class="row">
            <div class="col-md-4">
                <img src="{{ asset ('../img/logo_sit.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
            </div>
            <div class="col-md-4">
              <i class="fa fa-bookmark-o"> Reporte de uso y estadisticas</i><br>
              <small class="pull-center"> Red wifi huéspedes / colaboradores</small><br>
              <small class="pull-center">d</small>
            </div>
            <div class="col-md-4">
                <img src="{{ asset ('../img/logo_sit.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
            </div>
          </div>
        </div>
      </div>

      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-info"></i>
              </div>
              <div class="media-body">
                  <h3>Información</h3>
              </div>
          </div>
        </div>
      </div>

      <div id="animated-number" class="row text-center">
        <div class="col-sm-2 bloque" >
          <i class="fa fa-rss fa-2x"></i>
          <h3 id="total_aps" name="total_aps" class="timer count-title count-number" data-to="11900" data-speed="1500"></h3>
          <strong>Antenas</strong><br>
          <strong>totales</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-upload fa-2x"></i>
          <h3 id="gb_max_dia" name="gb_max_dia" class="timer count-title count-number" data-to="11900" data-speed="1500"></h3>
          <strong>Gigabytes Max por</strong><br>
          <strong>dia</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-download fa-2x"></i>
          <h3 id="gb_min_dia" name="gb_min_dia" class="timer count-title count-number" data-to="11900" data-speed="1500"></h3>
          <strong>Gigabytes Min por</strong><br>
          <strong>dia</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-users fa-2x"></i>
          <h3 id="prom_usuario" name="prom_usuario" class="timer count-title count-number" data-to="11900" data-speed="1500"></h3>
          <strong>Promedio de usuario</strong><br>
          <strong>diario</strong>
        </div>
        <div class="col-sm-2 bloque">
          <i class="fa fa-calendar fa-2x"></i>
          <h3 id="total_usuario" name="total_usuario" class="timer count-title count-number" data-to="11900" data-speed="1500"></h3>
          <strong>Total de usuarios</strong><br>
          <strong>mensual</strong>
        </div>

        <div class="col-sm-2 bloque">
          <i class="fa fa-tablet fa-2x"></i>
          <h3 id="rogue_mes" name="rogue_mes" class="timer count-title count-number" data-to="11900" data-speed="1500"></h3>
          <strong>Rogue</strong><br>
          <strong>devices</strong>
        </div>
      </div>


      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-wifi"></i>
              </div>
              <div class="media-body">
                  <h3>Numero de clientes conectados a c/u WLAN</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div id="graphicwlan" class="col-md-12">
          <div id="mainwlan" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>Top 5 SSID</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div id="graphictopssid" class="col-md-12">
            <div id="maintopssid" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>Numero de clientes conectados por dia</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div id="graphicuser" class="col-md-12">
            <div id="mainuser" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>Top AP'S Más Utilizadas</h3>
              </div>
          </div>
        </div>
      </div>


      <div class="row margin_div">
        <div id="graphicaps" class="col-md-6">
            <div id="mainaps" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
        <div class="col-md-6">
          <table id="table_det_aps" name='table_det_aps' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
            <thead >
              <tr class="bg-primary" style="background: #0091EB;">
                <th>Descripción</th>
                <th>MAC</th>
                <th>No.Clientes</th>
                <th>Mes</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>Comparativo Mes Actual vs Mes Anterior</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div class="col-md-6">
          <table id="table_det_aps" name='table_det_aps' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
            <thead >
              <tr class="bg-primary" style="background: #FF851B;">
                <th>Mes</th>
                <th>Prom. USUARIOS POR DIA</th>
                <th>GIGABYTES POR DÍA</th>
                <th>ROGUE DEVICES</th>
                <th>DIF %</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div id="graphiccompart" class="col-md-6">
            <div id="maincompart" style="height:400px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>Observaciones</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div class="col-md-12">
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

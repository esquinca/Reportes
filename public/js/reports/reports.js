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

function infohotel(){
  var hotel= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./consultshowconcep",
    data: { number : hotel,  _token : _token },
    success: function (data){
      $.each(JSON.parse(data),function(index, objdataTable){
        $("#name_hotel").text(objdataTable.Nombre_hotel);

        /*Comparo isEmptyObject con el array no esta vacio me devuelve false*/
        if (jQuery.isEmptyObject(objdataTable.dirlogo1) == false) {
          $("#client_hotel").attr("src","../img/hoteles/"+objdataTable.dirlogo1);
        }
        /*Comparo isEmptyObject con el array si esta vacio me devuelve true*/
        if (jQuery.isEmptyObject(objdataTable.dirlogo1) != false) {
          $("#client_hotel").attr("src","../img/hoteles/Sin_imagen.png");
        }

      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function graficas(){
  var hotel= $('#select_one').val();
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
          var cadenaspiep = [];
          $.ajax({
            type: "POST",
            url: "./consultshowgraffour",
            data: { number : hotel, mes: calendario,  _token : _token },
            success: function (data){
              $.each(JSON.parse(data),function(index, objdata){
                datapiegraf1.push(objdata.Descripcion);
                datapiegraf2.push(objdata.NumClientes);
              });
              var uniontitulos = [];
              for (var j = 0; j < datapiegraf1.length; j++) {
                var arraydatanamep = datapiegraf1[j] + '=' + datapiegraf2[j];
                var arraydatavaluep= datapiegraf2[j];
                var concatenarp= {"value": arraydatavaluep, "name": arraydatanamep};
                cadenaspiep.push(concatenarp);
                uniontitulos.push(arraydatanamep);
                //{value:10, name:'rose1'},
              }
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
                        //data:['rose1','rose2','rose3','rose4','rose5','rose6','rose7','rose8']
                        data: uniontitulos
                    },
                    toolbox: {
                        show : false,
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
                            center : ['60%','50%'],
                            roseType : 'area',
                            x: '50%',               // for funnel
                            max: 40,                // for funnel
                            sort : 'ascending',     // for funnel
                            data: cadenaspiep
                            /*
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
                            */
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

var configTableAps={
      "order": [[ 2, "asc" ]],
      paging: false,
      //"pagingType": "simple",
      Filter: false,
      searching: false,
      //"aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
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

function table_graf_pie(){
  var hotel= $('#select_one').val();
  var calendario= $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();
  $.ajax({
    type: "POST",
    url: "./consultshowdetaps",
    data: { number : hotel, mes: calendario,  _token : _token },
    success: function (data){
      $('#table_det_aps').DataTable().destroy();
      var TablaDetallesAps= $('#table_det_aps').dataTable(configTableAps);
      TablaDetallesAps.fnClearTable();
      $.each(JSON.parse(data),function(index, objdataTable){
        TablaDetallesAps.fnAddData([
          objdataTable.Descripcion,
          objdataTable.MAC,
          objdataTable.NumClientes
        ]);
      });

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

function info_cuadros(){
  var hotel= $('#select_one').val();
  var calendario= $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();

  $("#total_aps").attr("data-to", '');
  $("#gb_max_dia").attr("data-to", '');
  $("#gb_min_dia").attr("data-to", '');
  $("#prom_usuario").attr("data-to", '');
  $("#total_usuario").attr("data-to", '');
  $("#rogue_mes").attr("data-to", '');

  $.ajax({
    type: "POST",
    url: "./consultshowinfo",
    data: { number : hotel, mes: calendario,  _token : _token },
    success: function (data){
      $.each(JSON.parse(data),function(index, objdata){
        $("#total_aps").attr("data-to", objdata.AP);
        $("#gb_max_dia").attr("data-to", objdata.MaxGBV0);
        $("#gb_min_dia").attr("data-to", objdata.MinGBV0);
        $("#prom_usuario").attr("data-to", objdata.AVGUSER);
        $("#total_usuario").attr("data-to", objdata.MaxClientes);
        $("#rogue_mes").attr("data-to", objdata.RogueDevice);
        $('.timer').each(count); // Ejecutar el contador despues de recibir valores

        $("#gbmaxid").html(objdata.MaxGBV1 + " Max por");
        $("#gbminid").html(objdata.MinGBV1 + " Min por");

      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}
///No mover funcion de ingremento de contador/////////////////////////////////////////////////////////
var CountTo = function (element, options) {
  this.$element = $(element);
  this.options  = $.extend({}, CountTo.DEFAULTS, this.dataOptions(), options);
  this.init();
};

CountTo.DEFAULTS = {
  from: 0,               // the number the element should start at
  to: 0,                 // the number the element should end at
  speed: 1000,           // how long it should take to count between the target numbers
  refreshInterval: 100,  // how often the element should be updated
  decimals: 0,           // the number of decimal places to show
  formatter: formatter,  // handler for formatting the value before rendering
  onUpdate: null,        // callback method for every time the element is updated
  onComplete: null       // callback method for when the element finishes updating
};

CountTo.prototype.init = function () {
  this.value     = this.options.from;
  this.loops     = Math.ceil(this.options.speed / this.options.refreshInterval);
  this.loopCount = 0;
  this.increment = (this.options.to - this.options.from) / this.loops;
};

CountTo.prototype.dataOptions = function () {
  var options = {
    from:            this.$element.data('from'),
    to:              this.$element.data('to'),
    speed:           this.$element.data('speed'),
    refreshInterval: this.$element.data('refresh-interval'),
    decimals:        this.$element.data('decimals')
  };

  var keys = Object.keys(options);

  for (var i in keys) {
    var key = keys[i];

    if (typeof(options[key]) === 'undefined') {
      delete options[key];
    }
  }

  return options;
};

CountTo.prototype.update = function () {
  this.value += this.increment;
  this.loopCount++;

  this.render();

  if (typeof(this.options.onUpdate) == 'function') {
    this.options.onUpdate.call(this.$element, this.value);
  }

  if (this.loopCount >= this.loops) {
    clearInterval(this.interval);
    this.value = this.options.to;

    if (typeof(this.options.onComplete) == 'function') {
      this.options.onComplete.call(this.$element, this.value);
    }
  }
};

CountTo.prototype.render = function () {
  var formattedValue = this.options.formatter.call(this.$element, this.value, this.options);
  this.$element.text(formattedValue);
};

CountTo.prototype.restart = function () {
  this.stop();
  this.init();
  this.start();
};

CountTo.prototype.start = function () {
  this.stop();
  this.render();
  this.interval = setInterval(this.update.bind(this), this.options.refreshInterval);
};

CountTo.prototype.stop = function () {
  if (this.interval) {
    clearInterval(this.interval);
  }
};

CountTo.prototype.toggle = function () {
  if (this.interval) {
    this.stop();
  } else {
    this.start();
  }
};

function formatter(value, options) {
  return value.toFixed(options.decimals);
}

$.fn.countTo = function (option) {
  return this.each(function () {
    var $this   = $(this);
    var data    = $this.data('countTo');
    var init    = !data || typeof(option) === 'object';
    var options = typeof(option) === 'object' ? option : {};
    var method  = typeof(option) === 'string' ? option : 'start';

    if (init) {
      if (data) data.stop();
      $this.data('countTo', data = new CountTo(this, options));
    }

    data[method].call(data);
  });
};
///Asignacion del contador a los campos////////////////////////////////////////////////////////////
function count(options) {
  var $this = $(this);
  options = $.extend({}, options || {}, $this.data('countToOptions') || {});
  $this.countTo(options);
}

jQuery(function ($) {
  $('#total_aps').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
  $('#gb_max_dia').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
  $('#gb_min_dia').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
  $('#prom_usuario').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
  $('#total_usuario').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
  $('#rogue_mes').data('countToOptions', {
    formatter: function (value, options) {
      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
  });
});
///////////////////////////////////////////////////////////////////////////////////////////////////


function info_observation(){
  var hotel= $('#select_one').val();
  var calendario= $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();
  $("#coment_itc").text('');
  $.ajax({
    type: "POST",
    url: "./consultshowobserv",
    data: { number : hotel, mes: calendario,  _token : _token },
    success: function (data){
      if (data != '') {
        //Existe observacion
        $("#coment_itc").text(data);
      }
      if (data == '') {
        var texto_cont_one= 'Actualmente el numero total de antenas es de ' + $("#total_aps").attr("data-to");
        var texto_cont_two= ', con un total de usuarios mensuales de ' +  $("#total_usuario").attr("data-to");
        var texto_cont_three= ', de los cuales la cantidad de rogue device es de ' + $("#rogue_mes").attr("data-to") + '. ';
        var texto_cont_four=  'La cantidad de Gigabyte maximo presentado en este mes es de ' + $("#gb_max_dia").attr("data-to")  + '.';
        var texto_aleat = texto_cont_one + texto_cont_two + texto_cont_three + texto_cont_four;
        $("#coment_itc").text(texto_aleat);
        //No existe observacion
      }

    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
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
(function(){
    $('#generateInfo').on('click', function() {
        var hal= $('#select_two').val();
        var _token = $('input[name="_token"]').val();
        var a0=validarSelect('select_one');
        var a1=validarSelect('select_two');
        var a2=validarInput('calendar_fecha');

        if (a0 == false || a1 == false  || a2 == false) {
           toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
        }
        if (a0 == true && a1 == true && a2 == true) {
          $.ajax({
            type: "POST",
            url: "./consultnivelreport",
            data: { number : hal, _token : _token },
            success: function (data){
              console.log(data);
              if (data == 'Basico') {
                $("#basico").show();
                infohotel();
                info_cuadros();
                grafica_radar();
                graficas();
                grafica_bar();
                grafica_pie();
                table_graf_pie();
                info_observation();
              }
              if (data == 'Intermedio') {}
              if (data == 'Completo') {}
              if (data == 'Avanzado') {}

            },
            error: function (data) {
              console.log('Error:', data);
            }
          });
        }


    });
})();

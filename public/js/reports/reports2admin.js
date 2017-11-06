$(function() {
  initialization_page();
  reset_quiz_current();
  $(".select2").select2();
});

function initialization_page(){
  $("#contentreport").hide();
  $('#select_one').prop('selectedIndex',0);
  $("#select_one").select2({placeholder: "Elija"});

  $('#select_two').empty();
  $('#select_two').append('<option value="" selected>Elija</option>');
  $("#select_two").select2({placeholder: "Elija"});

  $('#calendar_fecha').attr('disabled', true);
  $('#calendar_fecha').val('');
  $('#calendar_fecha').datepicker({
      language: 'es',
      defaultDate: '',
      format: "mm-yyyy",
      viewMode: "months",
      minViewMode: "months",
      startDate: '01-2016',
      endDate: '1m', //Esto indica que aparecera el mes hasta que termine el ultimo dia del mes.
      autoclose: true
  });
}

function reset_quiz_current(){
  $("#client_hotel").attr("src","../img/hoteles/Sin_imagen.png");
  $("#client_hotel").css({'width' : '160px' , 'height' : '80px'});
  $("#total_aps").text('0');
  $("#gb_max_dia").text('0');
  $("#gb_min_dia").text('0');
  $("#prom_usuario").text('0');
  $("#total_usuario").text('0');
  $("#rogue_mes").text('0');
  $("#total_aps2").text('0');
  $("#total_usuario2").text('0');
  $("#rogue_mes2").text('0');
  $("#gb_max_dia2").text('0');
  $("#diversos_mes").text('0');
  $("#prom_dia").text('0');

  $("#mainwlan").empty();
  $("#maintopssid").empty();
  $("#mainuser").empty();
  $("#maingbdia").empty();
  $("#mainaps").empty();
  $("#anchobanda").empty();


  $('#table_det_aps').DataTable().destroy();
  $('#table_det_aps').DataTable(configTableAps).clear().draw();

  $("#anchobanda").attr("src","../img/hoteles/Sin_imagen.png");

  $('#table_detalle').DataTable().destroy();
  $('#table_detalle').DataTable(configTableAps).clear().draw();
}

function reset_quiz_all(){
  $('#select_one').attr('disabled', false);
  $('#select_two').attr('disabled', false);
  initialization_page();
  reset_quiz_current();
}

function resetcalent() {
  $('#calendar_fecha').val('');
  $('#calendar_fecha').attr('disabled', true);
}

$('#select_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  if (id != ''){
      $.ajax({
        type: "POST",
        url: "./typereport",
        data: { numero : id , _token : _token },
        success: function (data){
          $('#select_two').empty();
          $('#select_two').append('<option value="" selected>Elije</option>');

          $('#calendar_fecha').val('');
          $('#calendar_fecha').datepicker('setDate', null);
          $('#calendar_fecha').attr('disabled', false);

          $.each(JSON.parse(data),function(index, objdata){
            if (objdata.Nombre == 'Basico') {
              $("#select_two option").prop("selected", false);
              $('#select_two').append('<option value="'+objdata.Nombre+'" selected>'+ objdata.Nombre +'</option>');
              $('#select_two').val(objdata.Nombre).trigger('change');
            }
            else {
              $('#select_two').append('<option value="'+objdata.Nombre+'">'+ objdata.Nombre +'</option>');
            }
          });
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      $('#select_two').empty();
      $('#select_two').append('<option value="" selected>Elije</option>');
      $("#select_two").select2({placeholder: "Elija"});
  }
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
function obtenerAncho(){
  var ax1= $('#select_one').val();
  var ax2= $('#select_two').val();
  var ax3= $('#calendar_fecha').val();
  var _token = $('input[name="_token"]').val();

  $.ajax({
    type: "POST",
    url: "./consultimgzd",
    data: { aa1 : ax1,  aa2 : ax2,  aa3 : ax3,  _token : _token },
    success: function (data){
      if (data == '0') {
        $("#content_img_report").css({'display' : 'none' , 'visibility' : 'hidden'});
        $("#anchobanda").attr("src","../img/hoteles/Sin_imagen.png");
      }
      if (data == '1') {
        $.ajax({
          type: "POST",
          url: "./restartimgzd",
          data: { aa1 : ax1,  aa2 : ax2,  aa3 : ax3, _token : _token },
          success: function (data){
            var imagen = '../img/anchobanda/'+data;
            $("#anchobanda").attr("src",imagen);
            $("#content_img_report").css({'display' : 'block' , 'visibility' : 'visible'});
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

$('#generateInfo').on('click', function() {
    var ax1= $('#select_one').val();
    var ax2= $('#select_two').val();
    var ax3= $('#calendar_fecha').val();
    var _token = $('input[name="_token"]').val();
    var a0=validarSelect('select_one');
    var a1=validarSelect('select_two');
    var a2=validarInput('calendar_fecha');
    // console.log(a0);

    if (a0 == false || a1 == false  || a2 == false) {
      if (a1 == false) {
        toastr.error('Verifica que tengas asociado el tipo de reporte al hotel seleccionado. !!', 'Mensaje', {timeOut: 1000});
      }
      else {
        toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
      }
    }
    if (a0 == true && a1 == true && a2 == true) {

      $.ajax({
        type: "POST",
        url: "./consultnivelreportadmin",
        data: { aa1 : ax1,  aa2 : ax2,  aa3 : ax3, _token : _token },
        success: function (data){

          if (data == '0') {
            toastr.error('Este hotel no tiene asociado un tipo de reporte.!!', 'Mensaje', {timeOut: 1000});
            $("#contentreport").hide();
            reset_quiz_current();
          }
          if (data == '1') {
            toastr.success('Este hotel si tiene asociado un tipo de reporte..!!', 'Mensaje', {timeOut: 1000});
            $("#contentreport").show(10);
            reset_quiz_current();

            if (ax2 == 'Basico') {
              $("#basico").show();
              setTimeout((function() {
                obtenerAncho();
                infohotel();
                info_cuadros();
                grafica_radar();
                grafica_bar();

                graficas_user();
                graficas_gb();
                grafica_pie();
                table_graf_pie();
              }), 300);

              // info_observation();
            }
            if (ax2 == 'Intermedio') {}
            if (ax2 == 'Completo') {}
            if (ax2 == 'Avanzado') {}
          }
        //  console.log(data);
        //  console.log(ax2);

        },
        error: function (data) {
          console.log('Error:', data);
        }
      });


    }
});

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
          $("#mainwlan").css({'width' : 'width: 100%;' , 'height' : '225px', 'margin-right' : '0',  'padding-right' : '0', 'border-right-width' : '0' });
          var myChart2 = ec.init(document.getElementById('mainwlan'));
          myChart2.showLoading({
              text : "Cargando...",
              effect : 'whirling',
              textStyle : {
                  fontSize : 20
              }
          });
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
                     show : false,
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
                      orient : 'horizontal',
                      x : 'center',
                       y : 'bottom',
                      data: datass2,
                      textStyle: {
            	            fontSize: 9
            	        }
                      //data:['Chrome','Firefox','Safari','IE9+','IE8-']
                  },
                  toolbox: {
                      show : true,
                      orient: 'horizontal',  // 'horizontal' ¦ 'vertical'
                      x: 'left',  // 'center' ¦ 'left' ¦ 'right'
                      y: 'top',  // 'top' ¦ 'bottom' ¦ 'center'
                      feature : {
                          mark : {show: false},
                          dataView : {show: false, readOnly: false},
                          restore : {show: true, title : 'Recargar'},
                          saveAsImage : {show: false}
                      }
                  },
                  calculable : false,
                  series : (function (){
                      var series = [];
                      for (var i = 0; i < 14; i++) {

                          series.push({
                              name:'Estatus WLAN',
                              type:'pie',
                              itemStyle : {normal : {
                                  label : {
                                    show : i > 12,
                                    textStyle: {
                                      fontSize: 10
                                    }
                                  },
                                  labelLine : {show : i > 12, length:10}
                              }},
                              radius : [i * 4 + 11, i * 4 + 14],
                              data: nuevos_valores,
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
                          effect:{show:true,scaleSize:7,color:'rgba(250,225,50,0.8)',shadowBlur:10,period:60},
                          data:[{x:'50%',y:'50%'}]
                      };
                      return series;
                  })()
              };
              myChart2.clear();
              myChart2.setOption(optiongrafusuarios, true);
            },
            error: function (data) {
              myChart2.clear();
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
                      text : '',
                      textAlign : 'left',
                      textFont:'normal 20px 微软雅黑'
                  }
              }));
              _ZR.refresh();
              window.onresize = function () {
                // myChart2.resize();
              }
              myChart2.hideLoading();
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
          myChart3.showLoading({
              text : "Cargando...",
              effect : 'whirling',
              textStyle : {
                  fontSize : 20
              }
          });
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
                      show : false,
                      //subtext: 'Grafica de Barras'
                  },
                  tooltip : {
                      trigger: 'axis'
                  },
                  noDataLoadingOption: {
                       text: 'Información no disponible',
                       textStyle:{
          							fontSize:20,
          					    },
                        effect: 'whirling',
                        effectOption: {
                            effect: {
                                n: 0
                            }
                        }
                  },
                  legend: {
                      show : false,
                      x: 'right',
                      y: 'bottom',
                      data:['TOP']
                  },
                  toolbox: {
                      show : true,
                      orient: 'horizontal',  // 'horizontal' ¦ 'vertical'
                      x: 'left',  // 'center' ¦ 'left' ¦ 'right'
                      y: 'top',  // 'top' ¦ 'bottom' ¦ 'center'
                      feature : {
                          mark : {show: false},
                          dataView : {show: false, readOnly: false},
                          magicType : {show: false, type: ['line', 'bar']},
                          restore : {show: true, title : 'Recargar'},
                          saveAsImage : {show: false}
                      }
                  },
                  calculable : true,
                  xAxis : [
                      {
                          type : 'category',
                          data : datawbargraf1,
                          axisLabel:{
                                       //interval:0,
                                       rotate:10,
                                       margin:2,
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
              myChart3.clear();
              myChart3.setOption(optiongrassid);
            },
            error: function (data) {
              console.log('Error:', data);
              myChart3.clear();
            }
          });
          setTimeout(function (){
              window.onresize = function () {
              // myChart3.resize();
              }
              myChart3.hideLoading();
          }, 200);

        }
    );
}

function graficas_user(){
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
          myChart.showLoading({
              text : "Cargando...",
              effect : 'whirling',
              textStyle : {
                  fontSize : 20
              }
          });
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
                      subtext: calendario,
                      show : false,
                  },
                  tooltip : {
                      trigger: 'axis'
                  },
                  noDataLoadingOption: {
                       text: 'Información no disponible',
                       textStyle:{
          							fontSize:20,
          					    },
                        effect: 'whirling',
                        effectOption: {
                            effect: {
                                n: 0
                            }
                        }
                  },
                  legend: {
                      x: 'center',
                      y: 'bottom',
                      data:['Estatus'],
                      show : false,
                  },
                  toolbox: {
                      show : true,
                      orient: 'horizontal',  // 'horizontal' ¦ 'vertical'
                      x: 'left',  // 'center' ¦ 'left' ¦ 'right'
                      y: 'top',  // 'top' ¦ 'bottom' ¦ 'center'
                      feature : {
                          mark : {show: false},
                          dataView : {show: false, readOnly: false},
                          magicType : {show: false, type: ['line', 'bar', 'stack', 'tiled']},
                          restore : {show: true, title : 'Recargar'},
                          saveAsImage : {show: false}
                      }
                  },
                  calculable : true,
                  xAxis : [
                      {
                          type : 'category',
                          boundaryGap : false,
                          data: datausergraf1,
                          axisLabel:{
                                       interval:0,
                                       rotate:90,
                                      //  margin:2,
                                       textStyle:{
                                           color:"#222",
                                           fontSize : '10'
                                       }
                                   },
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
                  // myChart.resize();
              }
              myChart.hideLoading();
          },200);
        }
  );
}

function graficas_gb(){
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
          var myChartfour = ec.init(document.getElementById('maingbdia'));
          myChartfour.showLoading({
              text : "Cargando...",
              effect : 'whirling',
              textStyle : {
                  fontSize : 20
              }
          });
          var datausergraf1 = [];
          var datausergraf2 = [];

          $.ajax({
            type: "POST",
            url: "./consultshowgrafgbdia",
            data: { number : hotel, mes: calendario,  _token : _token },
            success: function (data){
              $.each(JSON.parse(data),function(index, objdata){
                datausergraf1.push(objdata.FechaCaptura);
                datausergraf2.push(objdata.GBxDia);
              });
              var optiongrafusuarios= {
                  title : {
                      text: 'Cantidad de GB',
                      subtext: calendario,
                      show : false,
                  },
                  tooltip : {
                      trigger: 'axis'
                  },
                  noDataLoadingOption: {
                       text: 'Información no disponible',
                       textStyle:{
          							fontSize:20,
          					    },
                        effect: 'whirling',
                        effectOption: {
                            effect: {
                                n: 0
                            }
                        }
                  },
                  legend: {
                      x: 'center',
                      y: 'bottom',
                      data:['GB'],
                      show : false,
                  },
                  toolbox: {
                      show : true,
                      orient: 'horizontal',  // 'horizontal' ¦ 'vertical'
                      x: 'left',  // 'center' ¦ 'left' ¦ 'right'
                      y: 'top',  // 'top' ¦ 'bottom' ¦ 'center'
                      feature : {
                          mark : {show: false},
                          dataView : {show: false, readOnly: false},
                          magicType : {show: false, type: ['line', 'bar', 'stack', 'tiled']},
                          restore : {show: true, title : 'Recargar'},
                          saveAsImage : {show: false}
                      }
                  },
                  calculable : true,
                  xAxis : [
                      {
                          type : 'category',
                          boundaryGap : false,
                          data: datausergraf1,
                          axisLabel:{
                                       interval:0,
                                       rotate:90,
                                      //  margin:2,
                                       textStyle:{
                                           color:"#222",
                                           fontSize : '8'
                                       }
                                   },
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
                          name:'GB',
                          type:'line',
                          smooth:true,
                          itemStyle: {normal: { color: "blue", areaStyle: { color: "rgba(100, 148, 237, 0.62)"}}},
                          data: datausergraf2,

                          //data:[1320, 0, 1132, 601, 234, 120, 90, 20]
                      }
                  ]
              };
              myChartfour.setOption(optiongrafusuarios);
            },
            error: function (data) {
              console.log('Error:', data);
            }
          });


          setTimeout(function (){
              window.onresize = function () {
                  // myChartfour.resize();
              }
              myChartfour.hideLoading();
          },200);
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
          var myChartfive = ec.init(document.getElementById('mainaps'));
          myChartfive.showLoading({
              text : "Cargando...",
              effect : 'whirling',
              textStyle : {
                  fontSize : 20
              }
          });
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
                        show: false,
                        text: 'Top aps',
                        subtext: '',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    noDataLoadingOption: {
                         text: 'Información no disponible',
                         textStyle:{
            							fontSize:20,
            					    },
                          effect: 'whirling',
                          effectOption: {
                              effect: {
                                  n: 0
                              }
                          }
                    },
                    legend: {
                       orient : 'horizontal',
                       x : 'center',
                       y : '60%',
                        //data:['rose1','rose2','rose3','rose4','rose5','rose6','rose7','rose8']
                        data: uniontitulos,
                        textStyle: {
              	            fontSize: 8
              	        }
                    },
                    toolbox: {
                        show : true,
                        orient: 'horizontal',  // 'horizontal' ¦ 'vertical'
                        x: 'left',  // 'center' ¦ 'left' ¦ 'right'
                        y: 'top',  // 'top' ¦ 'bottom' ¦ 'center'
                        feature : {
                            mark : {show: false},
                            dataView : {show: false, readOnly: false},
                            magicType : {
                                show: false,
                                type: ['pie', 'funnel']
                            },
                            restore : {show: true, title : 'Recargar'},
                            saveAsImage : {show: false}
                        }
                    },
                    calculable : true,
                    series : [
                         {
                            name:'Estatus',
                            type:'pie',
                            radius : [20, 35],
                            center : ['50%','30%'],
                            roseType : 'area',
                            x: '50%',               // for funnel
                            max: 40,                // for funnel
                            sort : 'ascending',     // for funnel
                            data: cadenaspiep,
                            itemStyle : {normal : {
                                label : {
                                  textStyle: {
                                    fontSize: 10,
                                  }
                                },
                            }},
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
              myChartfive.setOption(optiongrafpie);
            },
            error: function (data) {
              console.log('Error:', data);
            }
          });
          setTimeout(function (){
              window.onresize = function () {
                // myChartfive.resize();
              }
          }, 2000);
          myChartfive.hideLoading();

        }
    );
}

var configTableAps={
      "order": [[ 0, "desc" ]],
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
      if (data == '[]'){

      }
      else {
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
      }
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });
}

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
          $("#client_hotel").css({'width' : '160px' , 'height' : '80px'});

        }
        /*Comparo isEmptyObject con el array si esta vacio me devuelve true*/
        if (jQuery.isEmptyObject(objdataTable.dirlogo1) != false) {
          $("#client_hotel").attr("src","../img/hoteles/Sin_imagen.png");
          $("#client_hotel").css({'width' : '160px' , 'height' : '80px'});
        }

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

  $.ajax({
    type: "POST",
    url: "./consultshowinfo",
    data: { number : hotel, mes: calendario,  _token : _token },
    success: function (data){
      $.each(JSON.parse(data),function(index, objdata){
        $("#total_aps").text(objdata.AP);
        $("#gb_max_dia").text(objdata.MAXGB);
        $("#gb_min_dia").text(objdata.MINGB);
        $("#prom_usuario").text(objdata.AVGClientes);
        $("#total_usuario").text(objdata.MaxClientes);
        $("#rogue_mes").text(objdata.CantidadRogue);
        $("#diversos_mes").text('10');
        $("#prom_dia").text('10');

      });
    },
    error: function (data) {
      console.log('Error:', data);
    }
  });

}

$('#generatePdf').on('click', function() {
  //$("body").addClass('sidebar-collapse'); //Comprimir siderbar
  //$('.seleccion').hide();

  // Le añado las clases
  // $('#oficina_lg').parent().addClass('col-xs-3');
  // $('#name_hotel').parent().addClass('col-xs-6');
  // $('#client_hotel').parent().addClass('col-xs-3');
  //
  // //Le añado clases a los cuadros
  // $('#total_aps').parent().parent().addClass('col-xs-1');
  // $('#gb_max_dia').parent().parent().addClass('col-xs-1');
  // $('#gb_min_dia').parent().parent().addClass('col-xs-1');
  // $('#prom_usuario').parent().parent().addClass('col-xs-1');
  // $('#total_usuario').parent().parent().addClass('col-xs-1');
  // $('#rogue_mes').parent().parent().addClass('col-xs-1');
  //
  // $('#total_aps').css("font-size", "10px");
  // $('#gb_max_dia').css("font-size", "10px");
  // $('#gb_min_dia').css("font-size", "10px");
  // $('#prom_usuario').css("font-size", "10px");
  // $('#total_usuario').css("font-size", "10px");
  // $('#rogue_mes').css("font-size", "10px");
  //
  // $('#total_aps').parent().css("font-size", "10px");
  // $('#gb_max_dia').parent().css("font-size", "10px");
  // $('#gb_min_dia').parent().css("font-size", "10px");
  // $('#prom_usuario').parent().css("font-size", "10px");
  // $('#total_usuario').parent().css("font-size", "10px");
  // $('#rogue_mes').parent().css("font-size", "10px");

  // $('#title_w').css({'margin-top' : ''});
  // $('#title_s').css({'margin-top' : ''});
  // $('#title_cgs').css({'margin-top' : ''});
  // $('#title_aps').css({'margin-top' : ''});
  // $('#title_obs').css({'margin-top' : ''});
  //
  // $('#title_s').css("margin-top", "100px");
  // $('#title_aps').css("margin-top", "180px");

  window.print();

  // $('#total_aps').parent().css("font-size", "14px");
  // $('#gb_max_dia').parent().css("font-size", "14px");
  // $('#gb_min_dia').parent().css("font-size", "14px");
  // $('#prom_usuario').parent().css("font-size", "14px");
  // $('#total_usuario').parent().css("font-size", "14px");
  // $('#rogue_mes').parent().css("font-size", "14px");

  // $('#total_aps').css("font-size", "24px");
  // $('#gb_max_dia').css("font-size", "24px");
  // $('#gb_min_dia').css("font-size", "24px");
  // $('#prom_usuario').css("font-size", "24px");
  // $('#total_usuario').css("font-size", "24px");
  // $('#rogue_mes').css("font-size", "24px");
  //
  // $('#title_s').css("margin-top", "16px");
  // $('#title_aps').css("margin-top", "16px");

});

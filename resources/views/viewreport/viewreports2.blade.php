@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT' || Auth::user()->Privilegio == 'Cliente' || Auth::user()->Privilegio == 'Encuestador')
  @section('htmlheader_title')
      {{ trans('message.viewreport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.viewreport') }}
  @endsection

  @push('scripts')
  <link href="{{ asset('/css/viewreports0.css') }}" rel="stylesheet" type="text/css" />
  <script src="/plugins/momentupdate/moment-with-locales.js"></script>
  <!--DataTables-->
  <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
  <!-- <script src="/js/reports/script_reports.js"></script> -->
  <script src="/plugins/echarts/echarts.js"></script>
  <!-- <script src="/js/reports/reports.js"></script> -->

  @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  <script src="/js/reports/reports2admin.js"></script>
  @endif

  @if (Auth::user()->Privilegio == 'Encuestador')
  <script src="/js/reports/reports2admin.js"></script>
  @endif

  @if (Auth::user()->Privilegio == 'Cliente')
  <script src="/js/reports/reports2client.js"></script>
  @endif

  <style media="screen">
    .colornaranja{
      color: #FC4A00
    }
    .col-sm-4.invoice-col h1,p {
      text-align: center
    }
    .col-sm-4.invoice-col h1{
      font-size: 18px;
    }
    .col-sm-4.invoice-col p{
      margin: 0;
    }
    .bloque{
      color: #F15D24;
      margin-top: 1%;
      border: 3px solid #09347A;
      float: left;
      margin-left: 1em;
      text-align: center;
      width: auto;
    }
    .information-icon i.fa.fa-comments {
          font-size: 5em;
          color: #F15D24;
    }
    .information-icon{
        margin-top: 0.5em;
      	float:center;
      	/*width:5%*/
    }
    .information-info{
        float: center;
        /*margin-left: 0.5em;*/
        text-align: center;
        margin-bottom: 0.5em;
        /*width: 95%*/
    }
    .information-info h3{
    	font-size:1em;
    	margin:0;
      font-weight: bold;
    }
    .information-info strong{
    	font-size:1em !important;
    	color:#09347A !important;
    	margin:0 !important;
    	letter-spacing:1px;
    	text-decoration:none;
    }
  </style>
  @endpush
  @section('main-content')

  <section class="content">
    <section class="seleccion no-print">
      <div class="row">
        <div class="col-xs-12">

          <!-- SELECT2 EXAMPLE -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.required_view')}}</h3>
              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
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
                        <label for="select_one">{{ trans('message.selecthotel')}}: </label>
                        <select class="form-control select2" id="select_one" name="select_one">
                          @if(Auth::user()->Privilegio == 'Cliente')
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->id_hotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          @endif

                          @if(Auth::user()->Privilegio == 'IT')
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          @endif

                          @if (Auth::user()->Privilegio == 'Encuestador')
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          @endif

                          @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Helpdesk')
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          @endif

                        </select>
                      </div>
                      <div class="form-group">
                        <label for="select_two">{{ trans('message.tipo')}}: </label>
                        <select class="form-control select2" id="select_two" name="select_two">
                          <option value="" selected>{{ trans('message.optionOne')}}</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="calendar_fecha">{{ trans('message.fecha')}}:</label>
                        <input type="text" class="form-control" id="calendar_fecha" name="calendar_fecha" maxlength="7" title="{{ trans('message.maxcarsiete')}}">
                      </div>
                      <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.generar')}}</a>
                      <a id="generatePdf" class="btn bg-navy"><i class="fa fa-file-pdf-o"></i> {{ trans('message.generar')}} PDF</a>

                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <strong>{{ trans('message.nota')}}:</strong> <small>{{ trans('message.notareportes')}}.</small>
            </div>
          </div>
        </div>

        <div class="col-xs-12">
          @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Helpdesk' || Auth::user()->Privilegio == 'IT')
            <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-warning"></i> Mensaje!</h4>
              {{ trans('message.textone')}}  "{{ Auth::user()->Privilegio }}" {{ trans('message.texttwo')}}.
              {{ trans('message.textthre')}}
            </div>
          @endif
        </div>

      </div>
    </section>


    <!-- Main content -->
    <section id="contentreport" class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-th-large colornaranja"></i> {{ trans('message.empresa') }}.
            <small class="pull-right">{{ trans('message.date') }}: <?php $now = new DateTime(); echo $now->format('d-m-Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <img id='oficina_lg' name='oficina_lg'src="{{ asset ('../img/logo_sit.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <h1><i class="fa fa-bookmark-o"></i> {{ trans('message.titulorepbasic') }}</h1>
          <p>{{ trans('message.subtitulorepbasic') }}</p>
          <p id="name_hotel" name="name_hotel"></p>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <img id='client_hotel' name='client_hotel' src="{{ asset ('../img/hoteles/Sin_imagen.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- information row -->
      <div class="row invoice-info">
        <div class="col-xs-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-info"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.info') }}</h4>
              </div>
          </div>
        </div>
      </div>

      <div class="row invoice-info">
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-rss"></i>
						</div>
						<div class="information-info">
              <h3 id="total_aps" name="total_aps"></h3>
              <strong>{{ trans('message.cuadro_unoa') }}</strong><br>
              <strong>{{ trans('message.cuadro_unob') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-upload"></i>
						</div>
						<div class="information-info">
              <h3 id="gb_max_dia" name="gb_max_dia"></h3>
              <strong id="gbmaxid">{{ trans('message.cuadro_dosa') }}</strong><br>
              <strong>{{ trans('message.cuadro_dosb') }}</strong>
						</div>
					</div>
        </div>
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-database "></i>
						</div>
						<div class="information-info">
              <h3 id="gb_avg_dia" name="gb_avg_dia"></h3>
              <strong id="gbavgdia">{{ trans('message.cuadro_cuatroa') }}</strong><br>
              <strong>{{ trans('message.gb_info') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-download"></i>
						</div>
						<div class="information-info">
              <h3 id="gb_min_dia" name="gb_min_dia"></h3>
              <strong id="gbminid">{{ trans('message.cuadro_tresa') }}</strong><br>
              <strong>{{ trans('message.cuadro_tresb') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-level-up"></i><i class="fa fa-user"></i>
						</div>
						<div class="information-info">
              <h3 id="max_usuario" name="max_usuario" ></h3>
              <strong>{{ trans('message.cuadro_cuatroc') }}</strong><br>
              <strong>{{ trans('message.cuadro_tresb') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-users"></i>
						</div>
						<div class="information-info">
              <h3 id="prom_usuario" name="prom_usuario" ></h3>
              <strong>{{ trans('message.cuadro_cuatroa') }}</strong><br>
              <strong>{{ trans('message.cuadro_cuatrob') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-calendar"></i>
						</div>
						<div class="information-info">
              <h3 id="total_usuario" name="total_usuario"></h3>
              <strong>{{ trans('message.cuadro_cincoa') }}</strong></br>
              <strong>{{ trans('message.cuadro_cincob') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-tablet"></i>
						</div>
						<div class="information-info">
              <h3 id="rogue_mes" name="rogue_mes"></h3>
              <strong>{{ trans('message.cuadro_seisa') }}</strong><br>
              <strong>{{ trans('message.cuadro_seisb') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-desktop"></i>
						</div>
						<div class="information-info">
              <h3 id="diversos_mes" name="diversos_mes">54545</h3>
              <strong>{{ trans('message.dispmes') }}</strong><br>
              <strong>{{ trans('message.cuadro_tresb') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col bloque">
          <div class="comments">
						<div class="information-icon">
								<i class="fa fa-building-o"></i>
						</div>
						<div class="information-info">
              <h3 id="prom_dia" name="prom_dia">54545</h3>
              <strong>{{ trans('message.promdisa') }}</strong><br>
              <strong>{{ trans('message.promdisb') }}</strong>
						</div>
					</div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- WLAN row -->
      <div class="row invoice-info">
        <!--Mixed: Mobile, Tablet-->
        <div class="col-xs-12 col-sm-12 col-lg-6">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-user-secret"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.titlewlanrgbas') }}</h4>
              </div>
          </div>
          <div id="graphicwlan">
            <div id="mainwlan" style="height:225px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-6">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.titletopwlan') }}</h4>
              </div>
          </div>
          <div id="graphictopssid">
            <div id="maintopssid" style="height:225px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
          </div>
        </div>
      </div>


      <!-- Historico row -->
      <div class="row invoice-info">
        <!--Mixed: Mobile, Tablet-->
        <div class="col-xs-12 col-sm-12 col-lg-6">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-line-chart"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.titleclienxdiargbas') }}</h4>
              </div>
          </div>
          <div id="graphicuser">
            <div id="mainuser" style="height:225px; width: 110%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-6">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-line-chart"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.titlegbxdiaconsum') }}</h4>
              </div>
          </div>
          <div id="graphicgbdia">
            <div id="maingbdia" style="height:225px; width: 110%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
          </div>
        </div>
      </div>

      <!-- APS row -->
      <div class="row invoice-info">
        <!--Mixed: Mobile, Tablet-->
        <div class="col-xs-12 col-sm-12 col-lg-6">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-line-chart"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.titletopaprgbas') }}</h4>
              </div>
          </div>
          <div id="graphicaps">
            <div id="mainaps" style="height:200px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
          </div>
        </div>
        <div class="saltopagina"></div>
        <div class="col-xs-12 col-sm-12 col-lg-6">
            <table class="table table-striped table-bordered" id="table_det_aps" name="table_det_aps">
              <thead style="background-color: #0091EB; color: white;">
                <tr >
                  <th>{{ trans('message.description') }}</th>
                  <th>{{ trans('message.dirmac') }}</th>
                  <th>{{ trans('message.nclientd') }}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
      </div>

      <div class="row invoice-info">
        <div class="col-xs-12 col-sm-12 col-lg-6" id="content_img_report">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-exchange"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.anchobanda') }}</h4>
              </div>
          </div>
          <div class="contentanchobanda">
            <img id='anchobanda' name='anchobanda'src="{{ asset ('../img/anchobanda/123456.png') }}" width="400px" height="400px" style="display:flex; margin:0 auto;" class="img-responsive">
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-6" id="content_img_type_device">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-pie-chart"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.clienttype') }}</h4>
              </div>
          </div>
          <div class="contenttypedevice">
            <img id='typedevice' name='typedevice'src="{{ asset ('../img/devicetype/1511276883.png') }}" width="400px" height="400px" style="display:flex; margin:0 auto;" class="img-responsive">
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-6">
            <div class="media service-box">
                <div class="pull-left">
                    <i class="fa fa-compress"></i>
                </div>
                <div class="media-body">
                    <h4>{{ trans('message.comparativoantvsact') }}</h4>
                </div>
            </div>
            <table class="table table-striped table-bordered" id="table_detalle" name="table_detalle">
              <thead style="background-color: #0091EB; color: white;">
                <tr >
                  <th><p>{{ trans('message.concepto') }}</p></th>
                  <th><p id="dato_two" name="dato_two">Mes Uno</p></th>
                  <th><p id="dato_three" name="dato_three">Mes Dos</p></th>
                  <th><p>{{ trans('message.identcambio') }}</p></th>
                </tr>
              </thead>
              <tbody>
          <!--  <tr>
                  <td>USUARIOS MÁXIMOS POR HORA</td>
                  <td>dd</td>
                  <td>dd</td>
                  <td>(Y)</td>
                </tr>
                <tr>
                  <td>USUARIOS PROMEDIO POR HORA</td>
                  <td>dd</td>
                  <td>dd</td>
                  <td>(Y)</td>
                </tr>
                <tr>
                  <td>GIGABYTES POR DÍA</td>
                  <td>dd</td>
                  <td>dd</td>
                  <td>(Y)</td>
                </tr>
                <tr>
                  <td>ANCHO DE BANDA PROMEDIO</td>
                  <td>dd</td>
                  <td>dd</td>
                  <td>(Y)</td>
                </tr>
                <tr>
                  <td>DISPOSITIVOS POR MES</td>
                  <td>dd</td>
                  <td>dd</td>
                  <td>(Y)</td>
                </tr> -->
              </tbody>
            </table>
        </div>
      </div>



    </section>

  </section>


  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'IT' || Auth::user()->Privilegio != 'Encuestador')
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

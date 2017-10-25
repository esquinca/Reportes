@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT' || Auth::user()->Privilegio == 'Cliente')
  @section('htmlheader_title')
      {{ trans('message.viewreport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.viewreport') }}
  @endsection

  @push('scripts')
  <link href="{{ asset('/css/viewreports.css') }}" rel="stylesheet" type="text/css" />
  <script src="/plugins/moment/moment-with-locales.js"></script>
  <!--DataTables-->
  <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
  <script src="/js/reports/script_reports.js"></script>
  <script src="/plugins/echarts/echarts.js"></script>
  <script src="/js/reports/reports.js"></script>
  @endpush
  @section('main-content')

  <section class="content">
    <section class="seleccion no-print">
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
                        <label for="select_one">{{ trans('message.selecthotel')}}: </label>
                        <select class="form-control select2" id="select_one">
                          @if(Auth::user()->Privilegio == 'Cliente')
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->id_hotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          @else
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
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
                        <input type="text" class="form-control" id="calendar_fecha" maxlength="7" title="{{ trans('message.maxcarsiete')}}">
                      </div>
                      <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.generar')}}</a>
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

    <section id="basico" name="basico" class="invoice">
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
                <img id='oficina_lg' name='oficina_lg'src="{{ asset ('../img/logo_sit.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
            </div>
            <div class="col-md-4 text-center">
              <h1 style="font-size: 22px;"><i class="fa fa-bookmark-o"></i> {{ trans('message.titulorepbasic') }}</h1>
              <p style="margin: 0;">{{ trans('message.subtitulorepbasic') }}</p>
              <p id="name_hotel" name="name_hotel" style="margin: 0;"></p>
            </div>
            <div class="col-md-4">
                <img id='client_hotel' name='client_hotel' src="{{ asset ('../img/logo_sit.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
            </div>
          </div>
        </div>
      </div>

      <div class="row" >
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-info"></i>
              </div>
              <div class="media-body">
                  <h3>{{ trans('message.info') }}</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div text-center">
        <div class="col-sm-2">
          <div class="col-sm-12 bloque">
            <i class="fa fa-rss fa-2x"></i>
            <!--<h3 id="total_aps" name="total_aps" class="timer" data-to="11900" data-speed="10500"></h3>-->
            <h3 id="total_aps" name="total_aps"></h3>
            <strong>{{ trans('message.cuadro_unoa') }}</strong><br>
            <strong>{{ trans('message.cuadro_unob') }}</strong>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="col-sm-12 bloque">
            <i class="fa fa-upload fa-2x"></i>
            <!--<h3 id="gb_max_dia" name="gb_max_dia" class="timer" data-to="" data-speed="5000"></h3>-->
            <h3 id="gb_max_dia" name="gb_max_dia"></h3>
            <strong id="gbmaxid">{{ trans('message.cuadro_dosa') }}</strong><br>
            <strong>{{ trans('message.cuadro_dosb') }}</strong>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="col-sm-12 bloque">
            <i class="fa fa-download fa-2x"></i>
            <!--<h3 id="gb_min_dia" name="gb_min_dia" class="timer" data-to="" data-speed="5000"></h3>-->
            <h3 id="gb_min_dia" name="gb_min_dia"></h3>
            <strong id="gbminid">{{ trans('message.cuadro_tresa') }}</strong><br>
            <strong>{{ trans('message.cuadro_tresb') }}</strong>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="col-sm-12 bloque">
            <i class="fa fa-users fa-2x"></i>
            <!--<h3 id="prom_usuario" name="prom_usuario" class="timer" data-to="" data-speed="5000"></h3>-->
            <h3 id="prom_usuario" name="prom_usuario" ></h3>
            <strong>{{ trans('message.cuadro_cuatro') }}</strong><br>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="col-sm-12 bloque">
            <i class="fa fa-calendar fa-2x"></i>
            <!--<h3 id="total_usuario" name="total_usuario" class="timer" data-to="" data-speed="5000"></h3>-->
            <h3 id="total_usuario" name="total_usuario"></h3>
            <strong>{{ trans('message.cuadro_cinco') }}</strong>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="col-sm-12 bloque">
            <i class="fa fa-tablet fa-2x"></i>
            <!--<h3 id="rogue_mes" name="rogue_mes" class="timer" data-to="" data-speed="10500"></h3>-->
            <h3 id="rogue_mes" name="rogue_mes"></h3>
            <strong>{{ trans('message.cuadro_seisa') }}</strong><br>
            <strong>{{ trans('message.cuadro_seisb') }}</strong>
          </div>
        </div>
      </div>

      <div id="title_w" name="title_w" class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-wifi"></i>
              </div>
              <div class="media-body">
                  <h3>{{ trans('message.titlewlanrgbas') }}</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div id="graphicwlan" class="col-md-12 col-xs-10">
          <div id="mainwlan" style="height:300px; width: 75%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div id="title_s" name="title_s" class="row" style="margin-top: 16px;">
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
        <div id="graphictopssid" class="col-md-12 col-xs-10">
            <div id="maintopssid" style="height:300px; width: 75%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div id="title_cgs" name="title_cgs" class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>{{ trans('message.titleclienxdiargbas') }}</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div id="graphicuser" class="col-md-12 col-xs-10">
            <div id="mainuser" style="height:300px; width: 75%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
      </div>

      <div id="title_aps" name="title_aps" class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>{{ trans('message.titletopaprgbas') }}</h3>
              </div>
          </div>
        </div>
      </div>


      <div class="row margin_div">
        <div id="graphicaps" class="col-md-7 col-xs-10">
            <div id="mainaps" style="height:300px; width: 100%; margin-right:0;padding-right:0;border-right-width:0;  "></div>
        </div>
        <div class="col-md-5">
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

    <!--
      <div class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>{{ trans('message.comparativoantvsact') }}</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div class="col-md-6">
          <table id="ddsdfsd" name='dsdfsd' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
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
    -->
      <div id="title_obs" name="title_obs"  class="row" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-users"></i>
              </div>
              <div class="media-body">
                  <h3>{{ trans('message.observation') }}</h3>
              </div>
          </div>
        </div>
      </div>

      <div class="row margin_div">
        <div class="col-md-12">
            <p id='coment_itc' name='coment_itc'></p>
            <p id="coment_gen" name="coment_gen" style="display: inline-block;">
             Actualmente el numero total de antenas es de <small id='total_aps2' name='total_aps2'></small>
             con un total de usuarios mensuales de <small id='total_usuario2' name='total_usuario2'></small>,
             de los cuales la cantidad de rogue device es de <small id='rogue_mes2' name='rogue_mes2'></small>.
             La cantidad de Gigabyte maximo presentado en este mes es de <small id="gb_max_dia2" name="gb_max_dia2"></small>.
             </p>
        </div>
      </div>

      <div class="row no-print" style="margin-top: 16px;">
        <div class="col-md-12">
          <div class="media service-box">
              <div class="media-body">
                  <a id="generatePdf" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.generar')}} PDF</a>
              </div>
          </div>
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

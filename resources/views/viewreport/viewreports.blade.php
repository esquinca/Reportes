@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT' || Auth::user()->Privilegio == 'Cliente' || Auth::user()->Privilegio == 'Encuestador')

  @section('htmlheader_title')
      {{ trans('message.viewreport') }} concatenado.
  @endsection
  @section('contentheader_title')
      {{ trans('message.viewreport') }} concatenado.
  @endsection

  @push('scripts')
    <link href="{{ asset('/css/viewreports0.css') }}" rel="stylesheet" type="text/css" />
    <script src="/js/reportConcatenado/concatenado.js"></script>
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
                  <form class="form-inline">
                    <div>
                      <div class="form-group">
                        <label for="select_one">{{ trans('message.selecthotel')}}: </label>
                        <select class="form-control select2" id="select_one" name="select_one">
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
      <!-- /.row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <img id='oficina_lg' name='oficina_lg'src="{{ asset ('../img/logo_sit.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <h1><i class="fa fa-bookmark-o"></i>Reporte de uso y estadisticas.</h1>
          <p>Red Wifi Huespedes</p>
          <p>Acumulado</p>
          <p id="name_hotel" name="name_hotel">Marzo 2016- Febrero 2017</p>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <img id='client_hotel' name='client_hotel' src="{{ asset ('../img/hoteles/Sin_imagen.png') }}" width="160px" height="80px" style="display:flex; margin:0 auto;" class="img-responsive">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <div class="row invoice-info">
        <div class="col-xs-12 col-sm-12 col-lg-12">
          <div class="media service-box">
            <div class="pull-left">
              <i class="fa fa-compress"></i>
            </div>
            <div class="media-body">
              <h4>{{ trans('message.disppormes') }}</h4>
            </div>
          </div>
          <table class="table table-striped table-bordered" id="table_detalle" name="table_detalle">
            <thead style="background-color: #0091EB; color: white;">
              <tr >
                <th><p>{{ trans('message.hotel') }}</p></th>
                <th><p>Enero 2017</p></th>
                <th><p>Febrero 2017</p></th>
                <th><p>Marzo 2017</p></th>
                <th><p>Abril 2017</p></th>
                <th><p>Mayo 2017</p></th>
                <th><p>Junio 2017</p></th>
                <th><p>Julio 2017</p></th>
                <th><p>Agosto 2017</p></th>
                <th><p>Septiembre 2017</p></th>
                <th><p>Octubre 2017</p></th>
                <th><p>Noviembre 2017</p></th>
                <th><p>Diciembre 2017</p></th>
                <th><p>Promedio</p></th>
              </tr>
            </thead>
            <tbody>
              <tr>
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
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-exchange"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.anchobanda') }}</h4>
              </div>
          </div>
          <table class="table table-striped table-bordered" id="table_detalle" name="table_detalle">
            <thead style="background-color: #0091EB; color: white;">
              <tr >
                <th><p>{{ trans('message.hotel') }}</p></th>
                <th><p>Enero 2017</p></th>
                <th><p>Febrero 2017</p></th>
                <th><p>Marzo 2017</p></th>
                <th><p>Abril 2017</p></th>
                <th><p>Mayo 2017</p></th>
                <th><p>Junio 2017</p></th>
                <th><p>Julio 2017</p></th>
                <th><p>Agosto 2017</p></th>
                <th><p>Septiembre 2017</p></th>
                <th><p>Octubre 2017</p></th>
                <th><p>Noviembre 2017</p></th>
                <th><p>Diciembre 2017</p></th>
                <th><p>Promedio</p></th>
              </tr>
            </thead>
            <tbody>
              <tr>
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
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-exchange"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.anchobanda') }}</h4>
              </div>
          </div>
          <table class="table table-striped table-bordered" id="table_detalle" name="table_detalle">
            <thead style="background-color: #0091EB; color: white;">
              <tr >
                <th><p>{{ trans('message.hotel') }}</p></th>
                <th><p>Enero 2017</p></th>
                <th><p>Febrero 2017</p></th>
                <th><p>Marzo 2017</p></th>
                <th><p>Abril 2017</p></th>
                <th><p>Mayo 2017</p></th>
                <th><p>Junio 2017</p></th>
                <th><p>Julio 2017</p></th>
                <th><p>Agosto 2017</p></th>
                <th><p>Septiembre 2017</p></th>
                <th><p>Octubre 2017</p></th>
                <th><p>Noviembre 2017</p></th>
                <th><p>Diciembre 2017</p></th>
                <th><p>Promedio</p></th>
              </tr>
            </thead>
            <tbody>
              <tr>
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
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-lg-12">
          <div class="media service-box">
              <div class="pull-left">
                  <i class="fa fa-exchange"></i>
              </div>
              <div class="media-body">
                  <h4>{{ trans('message.anchobanda') }}</h4>
              </div>
          </div>
          <table class="table table-striped table-bordered" id="table_detalle" name="table_detalle">
            <thead style="background-color: #0091EB; color: white;">
              <tr >
                <th><p>{{ trans('message.hotel') }}</p></th>
                <th><p>Enero 2017</p></th>
                <th><p>Febrero 2017</p></th>
                <th><p>Marzo 2017</p></th>
                <th><p>Abril 2017</p></th>
                <th><p>Mayo 2017</p></th>
                <th><p>Junio 2017</p></th>
                <th><p>Julio 2017</p></th>
                <th><p>Agosto 2017</p></th>
                <th><p>Septiembre 2017</p></th>
                <th><p>Octubre 2017</p></th>
                <th><p>Noviembre 2017</p></th>
                <th><p>Diciembre 2017</p></th>
                <th><p>Promedio</p></th>
              </tr>
            </thead>
            <tbody>
              <tr>
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
              </tr>
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

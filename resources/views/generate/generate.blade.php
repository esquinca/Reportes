@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.generatereport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.generatereport') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/generate/generate.js"></script>
  @endpush

  @section('main-content')

  <section class="content">

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
                <label for="fecha_nueva">Fecha: </label>
                <input type="text" class="form-control" id="fecha_nueva" name="fecha_nueva" placeholder=" " maxlength="10" title='Máximo 60 Caracteres' title='Formato: dd-mm-yyyy Ejemplo: 02-01-2017' pattern="^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$">
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

  {!! Form::open(['action' => 'GenerateController@rdata', 'url' => '/insertCaptura', 'method' => 'post', 'id' => 'formsnmp']) !!}
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Capturar</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal">
      <div class="box-body">
        <div class="form-group row">
          <div class="col-xs-2">
            <label for="ex1">Numero Total de usuarios</label>
            <input class="form-control" id="ex1" type="text">
          </div>
          <div class="col-xs-3">
            <label for="ex2">Numero de Gigabytes transmitidos 24hrs</label>
            <input class="form-control" id="ex2" type="text">
          </div>
        </div>

        <h4>Top 5 de AP'S</h4><hr>
        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 1</h4>
          </div>
          <div class="col-xs-2">
            <label for="mac1">Mac</label>
            <input class="form-control" id="mac1" type="text">
          </div>
          <div class="col-xs-3">
            <label for="modelo1">Modelo</label>
            <input class="form-control" id="modelo1" type="text">
          </div>
          <div class="col-xs-4">
            <label for="cliente1">No. Clientes</label>
            <input class="form-control" id="cliente1" type="text">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 2</h4>
          </div>
          <div class="col-xs-2">
            <label for="mac2">Mac</label>
            <input class="form-control" id="mac2" type="text">
          </div>
          <div class="col-xs-3">
            <label for="modelo2">Modelo</label>
            <input class="form-control" id="modelo2" type="text">
          </div>
          <div class="col-xs-4">
            <label for="cliente2">No. Clientes</label>
            <input class="form-control" id="cliente2" type="text">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 3</h4>
          </div>
          <div class="col-xs-2">
            <label for="mac3">Mac</label>
            <input class="form-control" id="mac3" type="text">
          </div>
          <div class="col-xs-3">
            <label for="modelo3">Modelo</label>
            <input class="form-control" id="modelo3" type="text">
          </div>
          <div class="col-xs-4">
            <label for="cliente3">No. Clientes</label>
            <input class="form-control" id="cliente3" type="text">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 4</h4>
          </div>
          <div class="col-xs-2">
            <label for="mac4">Mac</label>
            <input class="form-control" id="mac4" type="text">
          </div>
          <div class="col-xs-3">
            <label for="modelo4">Modelo</label>
            <input class="form-control" id="modelo4" type="text">
          </div>
          <div class="col-xs-4">
            <label for="cliente4">No. Clientes</label>
            <input class="form-control" id="cliente4" type="text">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 5</h4>
          </div>
          <div class="col-xs-2">
            <label for="mac5">Mac</label>
            <input class="form-control" id="mac5" type="text">
          </div>
          <div class="col-xs-3">
            <label for="modelo5">Modelo</label>
            <input class="form-control" id="modelo5" type="text">
          </div>
          <div class="col-xs-4">
            <label for="cliente5">No. Clientes</label>
            <input class="form-control" id="cliente5" type="text">
          </div>
        </div>

        <h4>Top 5 de WLAN'S</h4><hr>
        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 1</h4>
          </div>
          <div class="col-xs-2">
            <label for="nombrew1">Nombre</label>
            <input class="form-control" id="nombrew1" type="text">
          </div>
          <div class="col-xs-3">
            <label for="clientew1">No. Clientes</label>
            <input class="form-control" id="clientew1" type="text">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 2</h4>
          </div>
          <div class="col-xs-2">
            <label for="nombrew2">Nombre</label>
            <input class="form-control" id="nombrew2" type="text">
          </div>
          <div class="col-xs-3">
            <label for="clientew2">No. Clientes</label>
            <input class="form-control" id="clientew2" type="text">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 3</h4>
          </div>
          <div class="col-xs-2">
            <label for="nombrew3">Nombre</label>
            <input class="form-control" id="nombrew3" type="text">
          </div>
          <div class="col-xs-3">
            <label for="clientew3">No. Clientes</label>
            <input class="form-control" id="clientew3" type="text">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 4</h4>
          </div>
          <div class="col-xs-2">
            <label for="nombrew4">Nombre</label>
            <input class="form-control" id="nombrew4" type="text">
          </div>
          <div class="col-xs-3">
            <label for="clientew4">No. Clientes</label>
            <input class="form-control" id="clientew4" type="text">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-xs-1">
            <h4>Reg. 5</h4>
          </div>
          <div class="col-xs-2">
            <label for="nombrew5">Nombre</label>
            <input class="form-control" id="nombrew5" type="text">
          </div>
          <div class="col-xs-3">
            <label for="clientew5">No. Clientes</label>
            <input class="form-control" id="clientew5" type="text">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-default">Limpiar</button>
        <button type="submit" class="btn btn-info pull-right">Guardar</button>
      </div>
      <!-- /.box-footer -->
    </form>
  </div>
  {!! Form::close() !!}
</section>





<section id="contenido">

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

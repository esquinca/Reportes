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
                <label for="fecha_nueva2">Fecha: </label>
                <input type="text" class="form-control" id="fecha_nueva2" name="fecha_nueva2" placeholder=" " maxlength="10" title='Máximo 60 Caracteres' title='Formato: dd-mm-yyyy Ejemplo: 02-01-2017' pattern="^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$">
              </div>

              <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> Generar</a>
              <a id="generateClear" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>

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

  {!! Form::open(['action' => 'GenerateController@rdata', 'url' => '/insertCaptura', 'method' => 'post', 'id' => 'formcapt']) !!}
  <div class="panel panel-info">
      <div class="panel-heading">
          <h3 class="panel-title">
              Información requerida</h3>
      </div>
      <ul class="list-group">
          <div class="list-group-item form-inline">
              <div class="form-group">
                <label for="userxday">Numero Total de usuarios</label>
                <div class="input-group">
                  <input class="form-control" name="userxday" id="userxday" type="text">
                </div>
              </div>
              <div class="form-group">
                <label for="gigxday">Numero de Gigabytes transmitidos 24hrs</label>
                <div class="input-group">
                  <input class="form-control" name="gigxday" id="gigxday" type="text">
                </div>
                <input type="text" id="idhotel" name="idhotel">
                <input type="text" id="fecha_nueva" name="fecha_nueva">
              </div>
          </div>

          <a href="javascript:void(0)" class="list-group-item " style="color: rgb(49, 112, 143); background-color: #D9EDF7;">Top 5 AP'S</a>

          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 1 - AP </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="mac1" name="mac1" type="text" class="form-control" placeholder="Ingresar MAC">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo1" name="modelo1"type="text" class="form-control" placeholder="Ingresar Modelo">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente1" name="cliente1"type="text" class="form-control" placeholder="Ingresar No.Clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 2 - AP </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="mac2" name="mac2" type="text" class="form-control" placeholder="Ingresar MAC">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo2" name="modelo2"type="text" class="form-control" placeholder="Ingresar Modelo">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente2" name="cliente2"type="text" class="form-control" placeholder="Ingresar No.Clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 3 - AP </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="mac3" name="mac3" type="text" class="form-control" placeholder="Ingresar MAC">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo3" name="modelo3"type="text" class="form-control" placeholder="Ingresar Modelo">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente3" name="cliente3"type="text" class="form-control" placeholder="Ingresar No.Clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 4 - AP </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="mac4" name="mac4" type="text" class="form-control" placeholder="Ingresar MAC">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo4" name="modelo4"type="text" class="form-control" placeholder="Ingresar Modelo">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente4" name="cliente4"type="text" class="form-control" placeholder="Ingresar No.Clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 5 - AP </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="mac5" name="mac5" type="text" class="form-control" placeholder="Ingresar MAC">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo5" name="modelo5"type="text" class="form-control" placeholder="Ingresar Modelo">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente5" name="cliente5"type="text" class="form-control" placeholder="Ingresar No.Clientes">
              </div>
            </div>
          </div>

          <a href="javascript:void(0)" class="list-group-item " style="color: rgb(49, 112, 143); background-color: #D9EDF7;">Top 5 WLAN'S</a>

          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 1 - WLAN </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="nombrew1" name="nombrew1" type="text" class="form-control" placeholder="Ingresar nombre de WLAN">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="clientew1" name="clientew1"type="text" class="form-control" placeholder="Ingresar num. de clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 2 - WLAN </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus" ></span></button>
                </span>
                <input id="nombrew2" name="nombrew2" type="text" class="form-control" placeholder="Ingresar nombre de WLAN">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus" ></span></button>
                </span>
                <input id="clientew2" name="clientew2"type="text" class="form-control" placeholder="Ingresar num. de clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 3 - WLAN </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="nombrew3" name="nombrew3" type="text" class="form-control" placeholder="Ingresar nombre de WLAN">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="clientew3" name="clientew3"type="text" class="form-control" placeholder="Ingresar num. de clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 4 - WLAN </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="nombrew4" name="nombrew4" type="text" class="form-control" placeholder="Ingresar nombre de WLAN">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="clientew4" name="clientew4"type="text" class="form-control" placeholder="Ingresar num. de clientes">
              </div>
            </div>
          </div>
          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 5 - WLAN </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="nombrew5" name="nombrew5" type="text" class="form-control" placeholder="Ingresar nombre de WLAN">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="clientew5" name="clientew5"type="text" class="form-control" placeholder="Ingresar num. de clientes">
              </div>
            </div>
          </div>

          <div class="list-group-item form-inline">
            <div class="form-group">
              <button id='subform' type="button" class="btn btn-info pull-right">Guardar</button>
            </div>
          </div>
      </ul>
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

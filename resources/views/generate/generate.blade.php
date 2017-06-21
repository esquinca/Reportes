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
                <label for="select_one" class="control-label">{{ trans('message.selecthotel')}}: </label>
                <div class="">
                  <select class="form-control select2" id="select_one">
                    <option value="" selected>{{ trans('message.optionOne')}}</option>
                    @foreach ($selectDatahotel as $info)
                    <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="fecha_nueva2"  class="control-label">{{ trans('message.fecha')}}: </label>
                <div class="">
                  <input type="text" class="form-control" id="fecha_nueva2" name="fecha_nueva2" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                </div>
              </div>

              <div class="form-group">
                <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                <a id="generateClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
              </div>

            </div>
          </form>
        </div>
        <div class="col-sm-12">
          <b><span>Simbologia</span><b><br>
          <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"> {{ trans('message.requerido')}}</span></button>
          <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"> {{ trans('message.nrequerido')}}</span></button>

        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <strong>Nota:</strong> Este apartado solo se utiliza cuando no se captura ninguna informacion de su hotel asignado.
    </div>
  </div>

  {!! Form::open(['action' => 'GenerateController@rdata', 'url' => '/insertCaptura', 'method' => 'post', 'id' => 'formcapt']) !!}
  <div class="panel panel-info">
      <div class="panel-heading">
          <h3 class="panel-title">{{ trans('message.inforeq')}}</h3>
      </div>
      <ul class="list-group">
          <div class="list-group-item form-inline">
              <div class="form-group">
                <label for="userxday">{{ trans('message.ntuser')}}</label>
                <div class="input-group">
                  <input class="form-control" name="userxday" id="userxday" type="text">
                </div>
              </div>
              <div class="form-group">
                <label for="gigxday">{{ trans('message.ntuser24')}}</label>
                <div class="input-group">
                  <input class="form-control" name="gigxday" id="gigxday" type="text">
                </div>
                <input type="hidden" id="idhotel" name="idhotel">
                <input type="hidden" id="fecha_nueva" name="fecha_nueva">
              </div>
          </div>

          <a href="javascript:void(0)" class="list-group-item " style="color: rgb(49, 112, 143); background-color: #D9EDF7;">{{ trans('message.topcinco')}}</a>

          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 1 - AP </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="mac1" name="mac1" type="text" class="form-control" placeholder="{{ trans('message.ingmac')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo1" name="modelo1"type="text" class="form-control" placeholder="{{ trans('message.ingmod')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente1" name="cliente1"type="text" class="form-control" placeholder="{{ trans('message.ingnclien')}}">
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
                <input id="mac2" name="mac2" type="text" class="form-control" placeholder="{{ trans('message.ingmac')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo2" name="modelo2"type="text" class="form-control" placeholder="{{ trans('message.ingmod')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente2" name="cliente2"type="text" class="form-control" placeholder="{{ trans('message.ingnclien')}}">
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
                <input id="mac3" name="mac3" type="text" class="form-control" placeholder="{{ trans('message.ingmac')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo3" name="modelo3"type="text" class="form-control" placeholder="{{ trans('message.ingmod')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente3" name="cliente3"type="text" class="form-control" placeholder="{{ trans('message.ingnclien')}}">
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
                <input id="mac4" name="mac4" type="text" class="form-control" placeholder="{{ trans('message.ingmac')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo4" name="modelo4"type="text" class="form-control" placeholder="{{ trans('message.ingmod')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente4" name="cliente4"type="text" class="form-control" placeholder="{{ trans('message.ingnclien')}}">
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
                <input id="mac5" name="mac5" type="text" class="form-control" placeholder="{{ trans('message.ingmac')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="modelo5" name="modelo5"type="text" class="form-control" placeholder="{{ trans('message.ingmod')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="cliente5" name="cliente5"type="text" class="form-control" placeholder="{{ trans('message.ingnclien')}}">
              </div>
            </div>
          </div>

          <a href="javascript:void(0)" class="list-group-item " style="color: rgb(49, 112, 143); background-color: #D9EDF7;">{{ trans('message.topcincow')}}</a>

          <div class="list-group-item form-inline">
            <div class="form-group">
              <label>Top 1 - WLAN </label>
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="nombrew1" name="nombrew1" type="text" class="form-control" placeholder="{{ trans('message.ingnombw')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-asterisk"></span></button>
                </span>
                <input id="clientew1" name="clientew1"type="text" class="form-control" placeholder="{{ trans('message.ingnumcw')}}">
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
                <input id="nombrew2" name="nombrew2" type="text" class="form-control" placeholder="{{ trans('message.ingnombw')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus" ></span></button>
                </span>
                <input id="clientew2" name="clientew2"type="text" class="form-control" placeholder="{{ trans('message.ingnumcw')}}">
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
                <input id="nombrew3" name="nombrew3" type="text" class="form-control" placeholder="{{ trans('message.ingnombw')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="clientew3" name="clientew3"type="text" class="form-control" placeholder="{{ trans('message.ingnumcw')}}">
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
                <input id="nombrew4" name="nombrew4" type="text" class="form-control" placeholder="{{ trans('message.ingnombw')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="clientew4" name="clientew4"type="text" class="form-control" placeholder="{{ trans('message.ingnumcw')}}">
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
                <input id="nombrew5" name="nombrew5" type="text" class="form-control" placeholder="{{ trans('message.ingnombw')}}">
              </div>
            </div>
            <div class="form-group">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <div class="input-group">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-minus"></span></button>
                </span>
                <input id="clientew5" name="clientew5"type="text" class="form-control" placeholder="{{ trans('message.ingnumcw')}}">
              </div>
            </div>
          </div>

          <div class="list-group-item form-inline">
            <div class="form-group">
              <button id='subform' type="button" class="btn btn-info pull-right">{{ trans('message.guardar')}}</button>
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

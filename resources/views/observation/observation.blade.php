@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.observation') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.observation') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/observation/observation.js"></script>
  @endpush

  @section('main-content')
  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"></h3>

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
                  <label for="select_one"  class="control-label">{{ trans('message.selecthotel')}}: </label>
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
                  <label for="fecha_nueva"  class="control-label">{{ trans('message.fecha')}}: </label>
                  <div class="">
                    <input type="text" class="form-control" id="fecha_nueva" name="fecha_nueva" placeholder=" " maxlength="7" title="{{ trans('message.maxcarsiete')}}">
                  </div>
                </div>
                
                <div class="form-group">
                  <a id="generateInfo" class="btn btn-primary"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                  <a id="generateClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                </div>
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

    {!! Form::open(['action' => 'observationController@obsdata', 'url' => '/observationdata', 'method' => 'post', 'id' => 'fobservation']) !!}
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">{{ trans('message.inforeq')}}</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
               <label for="comment">{{ trans('message.comment')}}:</label>
               <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
               <input type="hidden" id="idhotel" name="idhotel">
               <input type="hidden" id="fecha_nueva2" name="fecha_nueva2">
              </div>
              <div class="form-group">
                <button id='subform' type="button" class="btn btn-success pull-left">{{ trans('message.guardar')}}</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    {!! Form::close() !!}

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

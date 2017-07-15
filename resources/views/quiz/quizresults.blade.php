@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestador')
  @section('htmlheader_title')
      {{ trans('message.results') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.results') }}
  @endsection

  @push('scripts')
  <script src="/js/quiz/results.js"></script>
  <style>
  .nowrap {
  	white-space: nowrap;
  }
  .boton-mini {
    font-size: 14px;
    padding: 2px 6px;
  	height: 26px;
  }
  .row-separation{
    padding-top: 20px;
  }
</style>

  @endpush
  @section('main-content')
  <section class="content">
      <div class="row">
        <div class="col-md-10">
          <h4>
             Total registros:
             <span id='cifra-total'  class="label label-primary">0</span>
          </h4>
        </div>
        <div class="col-md-2">
        </div>
      </div>

      {!! Form::open(['action' => 'QuizResultsController@filter', 'url' => '/result_filter', 'method' => 'post', 'id' => 'filter_result']) !!}
        <div id="filtration_container" name="filtration_container">
          <div class="row">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Año</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchyear" class="form-control">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
              </select>
            </div>
          </div>

          <div class="row row-separation">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Vertical</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchyear" class="form-control" style="width: 100%;">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
              </select>
            </div>
          </div>

          <div class="row row-separation">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
  						 <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>Rango</strong>
  					</div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchyear" class="form-control">
                <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
              </select>
            </div>
          </div>

        </div>

        <div class="form-inline">

          <button type="button" class="btn btn-primary">
            <i class="glyphicon glyphicon-filter" aria-hidden="true"></i> Aplicar Filtro
          </button>

          <button type="button" class="btn btn-success">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Añadir Filtro
          </button>

          <select class="form-control">
            <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
            <option value="year">Año</option>
            <option value="vertical">Vertical</option>
            <option value="ranges">Rangos</option>
          </select>

        </div>

      {!! Form::close() !!}

  </section>
  @endsection

@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'Encuestador')
  @section('htmlheader_title')
      {{ trans('message.pagenotfound') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.error') }}
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

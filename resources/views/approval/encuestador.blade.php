@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestador' )
  @section('htmlheader_title')
      {{ trans('message.approval') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.approval') }}
  @endsection

  @push('scripts')
  <script src="/js/datatable/dataTables.buttons.min.js"></script>
  <script src="/js/datatable/buttons.flash.min.js"></script>
  <script src="/js/datatable/jszip.min.js"></script>
  <script src="/js/datatable/pdfmake.min.js"></script>
  <script src="/js/datatable/vfs_fonts.js"></script>
  <script src="/js/datatable/buttons.html5.min.js"></script>
  <script src="/js/datatable/buttons.print.min.js"></script>
  <script src="/js/approval/encuestador.js"></script>
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
  {{ csrf_field() }}
  <div class="modal modal-default fade" id="modal-deltype" data-backdrop="static">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-bookmark" style="margin-right: 4px;"></i>{{ trans('message.confirmacion') }}</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                  <input id='recibidoconf' name='recibidoconf' type="hidden" class="form-control" placeholder="">
                  <input id='recibidoconfD' name='recibidoconfD' type="hidden" class="form-control" value="{{Auth::user()->email}}">
                  <h4 style="font-weight: bold;">{{ trans('message.preguntaconf') }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id='delete_type_rep'><i class="fa fa-trash" style="margin-right: 4px;"></i>{{ trans('message.eliminar') }}</button>

          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>

        </div>
      </div>
    </div>
  </div>

  <section class="content">
      <div class="row">
        <div class="col-md-12">
          <small>{{ trans('message.needfilters')}}</small>
        </div>
      </div>
      {!! Form::open(['action' => 'QuizCommentsController@store', 'url' => '/result_filter_comments', 'method' => 'post', 'id' => 'filasasw']) !!}
        <div id="filtration_container" name="filtration_container">
          <div id="filter_year" name="filter_year" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
               <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>{{ trans('message.year')}}</strong>
            </div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchyear" name="searchyear" class="form-control">
                <option value="" selected>{{ trans('message.optionOne')}}</option>
                @foreach ($selectDatayear as $information)
                <option value="{{ $information->Year1 }}"> {{ $information->Year1 }} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div id="filter_status" name="filter_status" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
               <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>{{ trans('message.estatus')}}</strong>
            </div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchestatus" name="searchestatus" class="form-control" style="width: 100%;">
                <option value="" selected>{{ trans('message.optionOne')}}</option>
                <option value="0">{{ trans('message.pendiente')}}</option>
                <option value="1">{{ trans('message.aprobado')}}</option>
              </select>
            </div>
          </div>

          <div id="filter_hotel" name="filter_hotel" class="row row-separation control-filter">
            <div class="nowrap col-xs-4 col-sm-2 col-md-1 col-lg-1">
               <button id='' type="button" class="boton-mini btn btn-warning" ><i class="fa fa-minus-square" aria-hidden="true"></i></button> <strong>{{ trans('message.hotel')}}</strong>
            </div>
            <div class="col-xs-8 col-sm-2 col-md-11 col-lg-1">
              <select id="searchhotel" name="searchhotel" class="form-control" style="width: 100%;">
                <option value="" selected>{{ trans('message.optionOne')}}</option>
                @foreach ($selectDatahotel as $info)
                <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

        <div class="form-inline row-separation">

          <button id="boton-aprobar_todopendientes" type="button" class="btn bg-olive">
            <span id="buttonpendientes" class="badge bg-teal">0</span>
            <i class="fa fa-exclamation"></i>{{ trans('message.approvalpend')}}
          </button>
          <button id="boton-aplica-filtro-visitantes" type="button" class="btn bg-orange">
            <i class="glyphicon glyphicon-filter" aria-hidden="true"></i> {{ trans('message.approvalfilt')}}
          </button>

          <button id='boton_muestra_selectfiltro' type="button" class="btn bg-navy">
            <i class="fa fa-plus-square" aria-hidden="true"></i> {{ trans('message.addapprovalfilt')}}
          </button>

          <select id='selectfiltro'class ='selectFiltro' class="form-control">
            <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
            <option value="filter_year">{{ trans('message.year')}}</option>
            <option value="filter_status">{{ trans('message.estatus')}}</option>
            <option value="filter_hotel">{{ trans('message.hotel')}}</option>

          </select>

        </div>
      {!! Form::close() !!}
      <div class="row row-separation">
        <div class="col-md-12">
        </div>
        <div class="col-xs-12 table-responsive">
          <table id="example1" name='example1' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
            <thead style="background-color: #3D4A5D; color: white;">
              <tr >
                <th>{{ trans('message.hotel') }}</th>
                <th>{{ trans('message.typereport') }}</th>
                <th>{{ trans('message.mesverif') }}</th>
                <th>{{ trans('message.estatus') }}</th>
                <th>{{ trans('message.optionsP') }}</th>
              </tr>
            </thead>
            <tbody style="background: #FFFFFF;">

            </tbody>

          </table>
        </div>
      </div>

  </section>
  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'Encuestador')
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

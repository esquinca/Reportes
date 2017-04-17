@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.wlan') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.regwlan') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/wlan/wlan.js"></script>
  <style media="screen">
      .table > thead > tr:first-child > th{
        /*border: hidden;*/
      }
      .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        z-index: 2;
        color: #ffffff;
        background-color: #3a5c7e;
        border-color: #3a5c7e;
        cursor: default;
    }
    </style>
  @endpush
  @section('main-content')
  <div class="modal modal-default fade" id="modal-editstatuswlan" data-backdrop="static">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.editstatus') }}</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                    {!! Form::open(['action' => 'WlanController@updatestatus', 'url' => '/conf_estado_wlan', 'method' => 'post', 'id' => 'formrewrite', 'class' => 'form-horizontal' ]) !!}
                        <input id='id_recibido' name='id_recibido' type="hidden" class="form-control" placeholder="">
                        <div class="form-group">
                          <label for="selectEditwlan" class="col-sm-4 control-label">{{ trans('message.estatus') }}<span style="color: red;">*</span></label>
                          <div class="col-sm-8">
                            <select id="selectEditwlan" name="selectEditwlan"  class="form-control" required>
                                <option value="">{{ trans('message.selectopt') }}</option>
                                <option value="0">Deshabilitada</option>
                                <option value="1">Habilitada</option>
                            </select>
                          </div>
                        </div>
                    {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-navy" id='update_wlan'><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>


  <section class="content">

  <!-- SELECT2 EXAMPLE -->
  <div class="box box-primary">
    <!--
    <div class="box-header with-border">
      <h3 class="box-title">Captura</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
      </div>
    </div>
    -->
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">

            <div class="col-xs-12 col-md-3 col-sm-2">
              <div class="form-group">
                <label for="selecthotel" class="col-xs-12 col-md-12 col-sm-12">Seleccionar el hotel:</label>
                <div class="col-xs-12 col-md-12 col-sm-12">
                  <select class="form-control select2" id="selecthotel" name="selecthotel">
                    <option value="" selected="selected">Elija</option>
                    @foreach ($selectDatahotel as $info)
                    <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-2">
              <div class="form-group">
                <label for="namewlan" class="col-xs-12 col-md-12 col-sm-12">Nombre de la wlan</label>
                 <div class="col-xs-12 col-md-12 col-sm-12">
                   <input type="text" class="form-control" id="namewlan" name="namewlan" placeholder="">
                 </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-6 col-sm-8">
              <div class="form-group">
                <div class="btn-group" style="margin-top: 23px;">
                  <button id="clearInput" name="clearInput" type="button" class="btn btn-default"><span class="fa fa-eraser" style="margin-right: 4px;"></span>{{ trans('message.limpiar') }}</button>
                  <button id="btnregedit" name="btnregedit" type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok" style="margin-right: 4px;"></span>{{ trans('message.registrar') }}</button>
                </div>
              </div>
            </div>

        </div>
      </div>

      <div class="col-md-12">
        <div class="row"><hr></div>
      </div>
      <div class="col-md-10">
        <div class="col-md-12 table-responsive" style="width: 80">
          <table id="tableWLAN" name='tableWLAN' class="display nowrap table table-bordered table-hover" cellspacing="0">
            <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
            <thead >
              <tr class="bg-primary" style="background: #34495E;">
                <th>Nombre de la wlan</th>
                <th style="width:100px;">Estado</th>
                <th style="width:100px;">{{ trans('message.operation') }}</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
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

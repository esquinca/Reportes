@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
  @section('htmlheader_title')
      {{ trans('message.textasighotel') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.textasighotel') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
  <script src="/js/assigntype/type.js"></script>
  @endpush

  @section('main-content')
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
    <section class="seleccion no-print">
      <div class="row">
        <div class="col-xs-12">
          <!-- SELECT2 EXAMPLE -->
          <div class="box box-primary">
            <!-- <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.approval') }}</h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <form id="lambda" role="form">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="select_one">{{ trans('message.selecthotel')}}: </label>
                  <select class="form-control select2" id="select_one" name="select_one">
                      <option value="" selected>{{ trans('message.optionOne')}}</option>
                      @foreach ($selectDatahotel as $info)
                      <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="select_two">{{ trans('message.tipo')}}: </label>
                  <select class="form-control select2" id="select_two" name="select_two">
                    <option value="" selected>{{ trans('message.optionOne')}}</option>
                    @foreach ($selectTypeRep as $info)
                    <option value="{{ $info->id }}"> {{ $info->Nombre }} </option>
                    @endforeach
                  </select>
                </div>

                <a id="approvalInfo" class="btn btn-success"><i class="fa fa-check-square"></i> {{ trans('message.approval')}}</a>
                <a id="clearinfo" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-xs-12">
          <table class="table table-striped table-bordered" id="table_type_reports" name="table_type_reports">
            <thead style="background-color: #001A36; color: white;">
              <tr >
                <th>{{ trans('message.hotel') }}</th>
                <th>{{ trans('message.typereport') }}</th>
                <th>{{ trans('message.optionsP') }}</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </section>


  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin')
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

@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
  @section('htmlheader_title')
      {{ trans('message.asigconcierge') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.asigconcierge') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/assign/assign.js"></script>
  <style media="screen">
      .table > thead > tr:first-child > th{
        /*border: hidden;*/
      }
      .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        z-index: 2;
        color: #ffffff;
        background-color: #f39c12;
        border-color: #f39c12;
        cursor: default;
    }
    </style>
  @endpush
  @section('main-content')

  <div class="modal modal-default fade" id="modal-editItconcierge" data-backdrop="static">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.edititconcierge') }}</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                    {!! Form::open(['action' => 'AssignConciergeController@update', 'url' => '/config_hotel', 'method' => 'post', 'id' => 'formrewrite', 'class' => 'form-horizontal' ]) !!}
                        <input id='id_recibido' name='id_recibido' type="text" class="form-control" placeholder="">
                        <div class="form-group">
                          <label for="inputhotel" class="col-sm-4 control-label">{{ trans('message.hotel')}}</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputhotel" name="inputhotel" maxlength="60" title="" readonly/>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="selectEditItconcierge" class="col-sm-4 control-label">{{ trans('message.concierge') }}<span style="color: red;">*</span></label>
                          <div class="col-sm-8">
                            <select id="selectEditItconcierge" name="selectEditItconcierge"  class="form-control" required>
        				                <option value="">{{ trans('message.selectopt') }}</option>
                                @foreach ($selectDataUser as $userreport)
                                <option value="{{ $userreport->IDUsuario }}"> {{ $userreport->Encargado }} </option>
                                @endforeach
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
          <button type="button" class="btn bg-navy" id='update_user_assign'><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>

  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-building-o"></i> {{ trans('message.listahoteles') }}
          <small class="pull-right">{{ trans('message.dateAct') }} <?php $now = new \DateTime();
          echo $now->format('d-m-Y');?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <div class="row invoice-info">
      <div class="col-xs-12 table-responsive">
        <table id="tableHotel" name='tableHotel' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
          <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
          <thead >
            <tr class="bg-primary" style="background: #f39c12;">
              <th>{{ trans('message.hotel') }}</th>
              <th>{{ trans('message.concierge') }}</th>
              <th  style="width:100px; ">{{ trans('message.operation') }}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin')
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

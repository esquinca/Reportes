@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
  @section('htmlheader_title')
      {{ trans('message.asigclient') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.asigclient') }}
  @endsection

  @push('scripts')
  <script src="/js/assigncl/assigncl.js"></script>

  @endpush
  @section('main-content')
  <!--Modal editar-->
  <div class="modal modal-default fade" id="modal-edithotcl" data-backdrop="static">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.asigclient') }}</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                    {!! Form::open(['action' => 'assignclientController@update', 'url' => '/assignclupdate', 'method' => 'post', 'id' => 'formclupdate', 'class' => 'form-horizontal' ]) !!}
                        <input id='id_recibido' name='id_recibido' type="hidden" class="form-control" placeholder="">

                        <div class="form-group">
                          <label for="inputhotel" class="col-sm-4 control-label">{{ trans('message.hotel')}}</label>

                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputhotel" name="inputhotel" maxlength="60" title="" readonly/>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="selectEditClient" class="col-sm-4 control-label">{{ trans('message.cliente') }}<span style="color: red;">*</span></label>
                          <div class="col-sm-8">
                            <select id="selectEditClient" name="selectEditClient"  class="form-control" required>
                                <option value="">{{ trans('message.selectopt') }}</option>
                                @foreach ($selectDataCliente as $infoC)
                                <option value="{{ $infoC->idc }}"> {{ $infoC->cliente }} </option>
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
          <button type="button" class="btn bg-navy" id='update_client_assign'><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>
  <!--Modal eliminar -->
  <div class="modal modal-default fade" id="modal-delhotcl" data-backdrop="static">
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
                  <h4 style="font-weight: bold;">{{ trans('message.preguntaconf') }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id='delete_client_data'><i class="fa fa-trash" style="margin-right: 4px;"></i>{{ trans('message.eliminar') }}</button>

          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>

        </div>
      </div>
    </div>
  </div>



  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Asignar</h3>


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
                  <label for="select_two"  class="control-label">{{ trans('message.selectclient')}}: </label>
                  <div class="">
                    <select class="form-control select2" id="select_two">
                      <option value="" selected>{{ trans('message.optionOne')}}</option>
                      @foreach ($selectDataCliente as $infoC)
                      <option value="{{ $infoC->idc }}"> {{ $infoC->cliente }} </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <a id="capInfo" class="btn btn-primary"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                  <a id="capClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
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

    <!-- Section table client -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table id="tableclient" name='tableclient' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
          <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
          <thead >
            <tr class="bg-primary" style="background: #337AB7;">
              <th>{{ trans('message.hotel') }}</th>
              <th>{{ trans('message.cliente') }}</th>
              <th  style="width:100px; ">{{ trans('message.operation') }}</th>
            </tr>
          </thead>
          <tbody style="background: #ffff;">
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

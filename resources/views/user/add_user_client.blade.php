@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')

  @section('htmlheader_title')
      {{ trans('message.addUserclient') }}
  @endsection

  @section('contentheader_title')
      {{ trans('message.addUserclient') }}
  @endsection

  @push('scripts')
  <script src="/js/user/user_client.js"></script>
  @endpush

  @section('main-content')
    <div class="modal modal-default fade" id="modal-editUserClien" data-backdrop="static">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.visualizarinfoenc') }}</h4>
          </div>
          <div class="modal-body">
            <div class="box-body table-responsive">
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    {!! Form::open(['id' => 'formrewrite', 'class' => 'form-horizontal' ]) !!}
                        <input id='id_recibido' name='id_recibido' type="hidden" class="form-control" placeholder="">
                        <div class="form-group">
                          <label for="inpuEditnick" class="col-sm-4 control-label">{{ trans('message.nick')}}<span style="color: red;">*</span></label>
                          <div class="col-sm-8">
                            <input type="email" class="form-control" id="inpuEditnick" name="inpuEditnick" placeholder="{{ trans('message.nick') }}" maxlength="20">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEditName" class="col-sm-4 control-label">{{ trans('message.fullname')}}<span style="color: red;">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEditName" name="inputEditName" placeholder="{{ trans('message.addfullname') }}" maxlength="60" title=""/>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEditEmail" class="col-sm-4 control-label">{{ trans('message.emailaddress') }}</label>
                          <div class="col-sm-8">
                            <input type="email" class="form-control" id="inputEditEmail" name="inputEditEmail" placeholder="{{ trans('message.enteremail') }}" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="selectEditPriv" class="col-sm-4 control-label">{{ trans('message.privilegio') }}</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="selectEditPriv" name="selectEditPriv" Value="Encuestado" readonly>
                          </div>
                        </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <!--<button type="button" class="btn bg-navy" id='update_user_data'><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>-->
            <button type="button" class="btn bg-orange" id='update_edituser_data'><i class="fa fa-pencil-square-o " style="margin-right: 4px;"></i>Cambiar datos</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>

          </div>
        </div>
      </div>
    </div>

  <!--Modal eliminar relacion hotel encuestado-->
  <div class="modal modal-default fade" id="modal-delhotenc" data-backdrop="static">
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
          <button type="button" class="btn btn-danger" id='delete_cliente_data'><i class="fa fa-trash" style="margin-right: 4px;"></i>{{ trans('message.eliminar') }}</button>
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" style="margin-right: 4px;"></i>{{ trans('message.ccmodal') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!--Modal editar relacion hotel encuestado-->
  <div class="modal modal-default fade" id="modal-edithotenc" data-backdrop="static">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-id-card-o" style="margin-right: 4px;"></i>{{ trans('message.editreghotelenc') }}</h4>
        </div>
        <div class="modal-body">
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                    {!! Form::open(['id' => 'formeditrelhotenc', 'class' => 'form-horizontal' ]) !!}
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
          <button type="button" class="btn bg-navy" id='update_cliente_assign'><i class="fa fa-pencil-square-o" style="margin-right: 4px;"></i>{{ trans('message.actualizar') }}</button>
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
            <i class="fa fa-user-circle-o"></i> {{ trans('message.registerclient') }}
            <small class="pull-right">{{ trans('message.dateAct') }} <?php $now = new \DateTime();
            echo $now->format('d-m-Y');?></small>
          </h2>
        </div>
        <!-- /.col -->

        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-12 invoice-col">
            <!--<form class="form-horizontal" id='form_user'>-->
            <!-- {!! Form::open(['action' => '@create', 'url' => '/config_two_c', 'method' => 'post', 'id' => 'formadduser', 'class' => 'form-horizontal' ]) !!}-->
            {!! Form::open(['action' => 'UserClientController@store', 'url' => '/config_two_c', 'method' => 'post', 'id' => 'formadduserclien', 'class' => 'form-horizontal' ]) !!}
              <div class="form-group">
                <label for="inputNick" class="col-sm-2 control-label">{{ trans('message.nick')}}<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputNick" name="inputNick" placeholder="{{ trans('message.nick') }}" maxlength="20"/>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">{{ trans('message.fullname')}}<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputName" name="inputName" placeholder="{{ trans('message.addfullname') }}" maxlength="60" title="{{ trans('message.maxcarname')}}"/>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">{{ trans('message.emailaddress') }}<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="{{ trans('message.enteremail') }}" maxlength="60" title="{{ trans('message.maxcarname')}}">
                </div>
              </div>
              <div class="form-group">
                <label for="selectpriv" class="col-sm-2 control-label">{{ trans('message.privilegio') }}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="selectpriv" name="selectpriv" value="Cliente" readonly/>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button id='btnregister' name='btnregister' type="button" class="btn btn-danger">{{ trans('message.registrar') }}</button>
                </div>
              </div>
            {!! Form::close() !!}
          </div>
        </div>


        <!-- /.row -->
        <div class="row invoice-info">

          <div class="col-sm-12 invoice-col">
            <div class="callout callout-warning">
               <h4>Información importante!</h4>
               <p>Si usted registro un cliente, y luego no asigno un hotel a dicho cliente, no podrá ver sus reportes de sus hoteles.</p>
             </div>
          </div>

          <div class="col-sm-12 invoice-col">
            {!! Form::open(['id' => 'formassinguserht', 'class' => 'form-horizontal' ]) !!}
              <div class="form-group">
                <label for="select_one" class="col-sm-2 control-label">{{ trans('message.selecthotel')}}<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                  <select class="form-control select2" id="select_one" name="select_one">
                    <option value="" selected>{{ trans('message.optionOne')}}</option>
                    @foreach ($selectonedata as $infoH)
                    <option value="{{ $infoH->id }}"> {{ $infoH->Nombre_hotel }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="select_two" class="col-sm-2 control-label">{{ trans('message.selectencuest')}}<span style="color: red;">*</span></label>
                <div class="col-sm-10">
                  <select class="form-control select2" id="select_two" name="select_two">
                    <option value="" selected>{{ trans('message.optionOne')}}</option>
                    @foreach ($selecttwodata as $infoE)
                    <option value="{{ $infoE->id }}"> {{ $infoE->email }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button id='btnregasig' name='btnregasig' type="button" class="btn btn-danger">{{ trans('message.registrar') }}</button>
                </div>
              </div>
            {!! Form::close() !!}
          </div>

          <div class="col-sm-12 invoice-col">
            <table id="tableURClient" name='tableURClient' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
              <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
              <thead >
                <tr class="bg-primary" style="background: #00A274;">
                  <th>{{ trans('message.hotel') }}</th>
                  <th>{{ trans('message.email') }}</th>
                  <th>{{ trans('message.ope1') }}</th>
                  <th>{{ trans('message.ope2') }}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

        </div>

        <!-- /.row -->
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-users"></i> {{ trans('message.viewuser') }}
          </h2>
        </div>
        <!-- /.row -->

        <!-- /.row -->
        <div class="row invoice-info">
          <div class="col-xs-12 table-responsive">
            <table id="tableUserClien" name='tableUserClien' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
              <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
              <thead >
                <tr class="bg-primary" style="background: #001934;">
                  <th>{{ trans('message.nick') }}</th>
                  <th>{{ trans('message.email') }}</th>
                  <th>{{ trans('message.privilegio') }}</th>
                  <th>{{ trans('message.ope1') }}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.col -->






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

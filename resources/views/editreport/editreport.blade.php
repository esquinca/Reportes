@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT' || Auth::user()->Privilegio == 'Cliente' || Auth::user()->Privilegio == 'Encuestador')

  @section('htmlheader_title')
      {{ trans('message.editreport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.editreport') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/plugins/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
  <script src="/js/editreport/editar.js"></script>
  @endpush

  @section('main-content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <!--Inicio Apartado GB Transmitidos-->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.contentgbtrans')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  <form id="form_gb" name="form_gb" class="form-inline">
                    {{ csrf_field() }}
                    <div>
                      <div class="form-group">
                        <label for="fecha_ngb"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="fecha_ngb" name="fecha_ngb" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="select_onet"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                        <div class="">
                          <select class="form-control" id="select_onet" >
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="select_typezd"  class="control-label">{{ trans('message.selectzoned')}}: </label>
                        <div class="">
                          <select class="form-control" id="select_typezd" >
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="valorgb_trans"  class="control-label">Cant. Actual de GB Registrados: </label>
                        <div class="">
                          <input type="number" class="form-control" id="valorgb_trans" name="valorgb_trans" placeholder=" " maxlength="10" title="{{ trans('message.gbtrans')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="new_valorgb_tran"  class="control-label">Nueva Cant. de GB Transmitidos: </label>
                        <div class="">
                          <input type="text" class="form-control" id="new_valorgb_tran" name="new_valorgb_tran" placeholder=" " maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" title="{{ trans('message.gbtrans')}}" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <a id="generateGbInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateGbClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <strong>Nota: Cualquier cambio realizado tarda aproximadamente 20 minutos en refrescarse.</strong>
            </div>
          </div>
        <!--Fin Apartado GB Transmitidos-->
      </div>

      <div class="col-xs-12">
        <!--Inicio Apartado usuarios -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.contentnumberdevice')}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  <form id="form_user" name="form_user" class="form-inline">
                    <div>
                      <div class="form-group">
                        <label for="fecha_nuser"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="fecha_nuser" name="fecha_nuser" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="select_two"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                        <div class="">
                          <select class="form-control" id="select_two" name="select_two">
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="val_user"  class="control-label">Cant. Actual de usuarios: </label>
                        <div class="">
                          <input type="number" class="form-control" id="val_user" name="val_user" placeholder=" " maxlength="10" title="{{ trans('message.nusuario')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="new_val_user"  class="control-label">Nueva Cant. de usuarios: </label>
                        <div class="">
                          <input type="text" class="form-control" id="new_val_user" name="new_val_user" placeholder=" " maxlength="10" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="{{ trans('message.nusuario')}}">
                        </div>
                      </div>


                      <div class="form-group">
                        <a id="generateUserInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateUserClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <strong>Nota: Cualquier cambio realizado tarda aproximadamente 20 minutos en refrescarse.</strong>
            </div>
          </div>
        <!--Fin Apartado usuarios -->
      </div>

      <div class="col-xs-12">
        <!--Inicio Apartado subir ancho de banda-->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.clienttype')}}.</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  {{ csrf_field() }}
                  <form id="form_edit_upload_type" name="form_edit_upload_type" class="form-inline" enctype="multipart/form-data" action="/editimagentypeband" method="POST">
                    <div>
                      <div class="form-group">
                        <label for="select_one_type"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                        <div class="">
                          <select class="form-control select2" id="select_one_type" name="select_one_type">
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      {{ csrf_field() }}

                      <div class="form-group">
                        <label for="month_upload_type"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="month_upload_type" name="month_upload_type" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="upload_img_type"  class="control-label">{{ trans('message.importarimg')}}: </label>
                        <div class="">
                          <input type="file" class="form-control" id="upload_img_type" name="upload_img_type" title="{{ trans('message.importarimg')}}" onchange="control(this)">
                        </div>
                      </div>

                      <div class="form-group">
                        <a id="" class="btn btn-success" type="submit" onclick="$(this).closest('form').submit()"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateimgtypeClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <strong>Resolución Recomendada: Anchura: 380 píxeles. Altura: 220 píxeles.</strong>
            </div>
          </div>
        <!--Fin Apartado GB Transmitidos-->
      </div>

      <div class="col-xs-12">
        <!--Inicio Apartado subir ancho de banda-->
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.contentimgband')}}.</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  {{ csrf_field() }}
                  <form id="form_edit_img_upload" name="form_edit_img_upload" class="form-inline" enctype="multipart/form-data" action="/resetimagenband" method="POST">
                    <div>
                      <div class="form-group">
                        <label for="select_one_band"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                        <div class="">
                          <select class="form-control select2" id="select_one_band" name="select_one_band">
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->IDHotels }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      {{ csrf_field() }}

                      <div class="form-group">
                        <label for="month_upload"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="month_upload" name="month_upload" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="upload_img"  class="control-label">{{ trans('message.importarimg')}}: </label>
                        <div class="">
                          <input type="file" class="form-control" id="upload_img" name="upload_img" title="{{ trans('message.importarimg')}}" onchange="control(this)">
                        </div>
                      </div>

                      <div class="form-group">
                        <a id="" class="btn btn-success" type="submit" onclick="$(this).closest('form').submit()"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                        <a id="generateimgClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <strong>Resolución Recomendada: Anchura: 600 píxeles. Altura: 200 píxeles.</strong>
            </div>
          </div>
        <!--Fin Apartado GB Transmitidos-->
      </div>

    </div>
  </section>
  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'IT' || Auth::user()->Privilegio != 'Encuestador')
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

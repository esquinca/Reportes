@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.captureindiv') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.captureindiv') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/individual/individual.js"></script>
  <style>
   .removebord {
     border-top: 0 none;
     border-left: 0 none;
     border-right: 0 none;
   }
  </style>
  @endpush

  @section('main-content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <!--Inicio Apartado GB Transmitidos-->
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Apartado de captura para el número de Gigabytes transmitidos en 24hrs</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  {{ csrf_field() }}
                  <form id="form_gb" name="form_gb" class="form-inline">
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
                        <label for="fecha_ngb"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="fecha_ngb" name="fecha_ngb" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="valorgb_trans"  class="control-label">{{ trans('message.gbtrans')}}: </label>
                        <div class="">
                          <input type="number" class="form-control" id="valorgb_trans" name="valorgb_trans" placeholder=" " maxlength="10" title="{{ trans('message.gbtrans')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <a id="generateGbInfo" class="btn btn-default"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
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
            </div>
          </div>
        <!--Fin Apartado GB Transmitidos-->
      </div>

      <div class="col-xs-12">
        <!--Inicio Apartado usuarios -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Apartado de captura para el número de dispositivos cliente autorizados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  {{ csrf_field() }}
                  <form id="form_user" name="form_user" class="form-inline">
                    <div>
                      <div class="form-group">
                        <label for="select_two"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                        <div class="">
                          <select class="form-control select2" id="select_two">
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="fecha_nuser"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="fecha_nuser" name="fecha_nuser" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="val_user"  class="control-label">{{ trans('message.nusuario')}}: </label>
                        <div class="">
                          <input type="number" class="form-control" id="val_user" name="val_user" placeholder=" " maxlength="10" title="{{ trans('message.nusuario')}}">
                        </div>
                      </div>


                      <div class="form-group">
                        <a id="generateUserInfo" class="btn btn-default"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
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
            </div>
          </div>
        <!--Fin Apartado usuarios -->
      </div>

      <div class="col-xs-12">
        <!--Inicio Apartado de top aps -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Apartado de captura para el top 5 de ap‘s mas utilizados </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- row -->
              <div class="row">
                <div class="col-sm-12">
                  {{ csrf_field() }}
                  <form id="form_aps" name="form_aps" class="form-inline">
                    <ul class="list-group">
                      <div class="list-group-item form-inline removebord">
                        <div class="form-group">
                          <label for="select_three"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                          <div class="">
                            <select class="form-control select2" id="select_three">
                              <option value="" selected>{{ trans('message.optionOne')}}</option>
                              @foreach ($selectDatahotel as $info)
                              <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="fecha_aps"  class="control-label">{{ trans('message.fecha')}}: </label>
                          <div class="">
                            <input type="text" class="form-control" id="fecha_aps" name="fecha_aps" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                          </div>
                        </div>
                      </div>

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
                    </ul>
                    <div>
                      <a id="generateapsInfo" class="btn btn-default"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                      <a id="generateapsClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <strong> * Significa requerido. - Significa no requerido.</strong>
            </div>
          </div>
        <!--Fin Apartado de top aps -->
      </div>

      <div class="col-xs-12">
        <!--Inicio Apartado de top de wlan -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Apartado de captura para el top 5 de wlan‘s mas usadas </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- row -->
            <div class="row">
              <div class="col-sm-12">
                {{ csrf_field() }}
                <form id="form_wlan" name="form_wlan" class="form-inline">
                  <ul class="list-group">
                    <div class="list-group-item form-inline removebord">
                      <div class="form-group">
                        <label for="select_four"  class="control-label">{{ trans('message.selecthotel')}}: </label>
                        <div class="">
                          <select class="form-control select2" id="select_four">
                            <option value="" selected>{{ trans('message.optionOne')}}</option>
                            @foreach ($selectDatahotel as $info)
                            <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="fecha_nwlan"  class="control-label">{{ trans('message.fecha')}}: </label>
                        <div class="">
                          <input type="text" class="form-control" id="fecha_nwlan" name="fecha_nwlan" placeholder=" " maxlength="10" title="{{ trans('message.maxcardiez')}}">
                        </div>
                      </div>

                    </div>

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

                  </ul>
                  <div>
                    <a id="generatewlanInfo" class="btn btn-default"><i class="fa fa-bookmark-o"></i> {{ trans('message.capturar')}}</a>
                    <a id="generatewlanClear" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <strong> * Significa requerido. - Significa no requerido.</strong>
          </div>
        </div>
        <!--Fin Apartado de top de wlan -->
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

@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestado')
  @section('htmlheader_title')
      {{ trans('message.quiz') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.quiztest') }}
  @endsection

  @push('scripts')
    <!--<script src="/js/quiz/questions.js"></script>-->
    <link href="{{ asset('/plugins/jquery-bar-rating-master/dist/themes/bars-1to10.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/plugins/jquery-bar-rating-master/dist/jquery.barrating.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('/css/quizservice.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/plugins/bootstrap-multiselect-master/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/plugins/bootstrap-multiselect-master/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>

    <style>
      .box-body span {
        font-weight: normal;
        font-style: oblique;
      }
    </style>
    @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
      <!--<script src="/js/quiz/question_enc_preview.js"></script>-->
    @endif

    @if (Auth::user()->Privilegio == 'Encuestado')
      <?php
        if (!empty($selecdatanew)) {
      ?>
        <script src="/js/quiz/question_enc.js"></script>
      <?php
        }
      ?>
    @endif
  @endpush
  @section('main-content')

   @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
      <p>Preview sin funcionalidad </p>
   @endif

   @if (Auth::user()->Privilegio == 'Encuestado')
    <?php
      if (empty($selecdatanew)) {
    ?>
      <section class="content">
        <div class="row">
          <div class="callout callout-success">
            <h4>Felicitaciones!</h4>
            <p>Encuesta completada con éxito. <i class="fa fa-thumbs-up" aria-hidden="true"></i></p>
          </div>
        </div>
      </section>
    <?php
      }
      else {
        //var_dump($selecdatanew);
    ?>

        <!-- Encabezado de opciones de encuestas de servicio -->
        <div class="row">
          <div class="col-sm-12">
            {{ csrf_field() }}
            <form id="xa_encuesta" name="xa_encuesta" class="form-inline" method="POST">
              <div class="form-group">
                <label for="selecthotelofclient">Elija el hotel<span style="color: red;">*</span></label>
                <select id="selecthotelofclient" name="selecthotelofclient"  class="form-control" multiple="multiple" required>
                  @foreach ($selecdatanew as $infoH)
                    <option value="{{ $infoH[0]->id_hotels }}"> {{ $infoH[0]->Nombre_hotel }} </option>
                  @endforeach
                </select>
              </div>

              <!-- <span class="button-checkbox">
                <button type="button" class="btn" data-color="success">Seleccionar todos</button>
                <input type="checkbox" class="hidden" />
              </span> -->

              <div class="btn-group">
                <a id="generatequizquest" class="btn btn-primary"><i class="fa fa-dot-circle-o "></i> Generar encuesta </a>
                <a id="clearquizquest" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
              </div>


            </form>
          </div>
        </div>
        <!-- /.Encabezado de opciones de encuestas de servicio -->

        <!---Apartado nuevo de preguntas -->
        <section class="content">
          <section class="seleccion no-print">
            <div class="row">
              <div id="content_satisfaction" class="col-xs-12">
                <!-- SELECT2 EXAMPLE -->
                <div id="satisfaccion_cliente" class="box box-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('message.satisfaccioncliente') }}</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="row">
                      <div class="col-xs-12">
                        <span>
                          Con base en el servicio que le brindamos durante el mes de
                          <?php
                            $now = new \DateTime();
                            $date= $now->format('Y/m/d');
                            $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                            $numMes = date ("m", strtotime($date));
                            echo $meses[$numMes-2];
                          ?>
                          , quisiera pedirle que respondiera a las siguientes preguntas.
                        </span>
                      </div>

                      <div class="col-xs-12">
                        {!! Form::open(['action' => 'QuizQuestionsController@createdata', 'url' => '/quiz_data_ifn', 'method' => 'post', 'id' => 'lambda']) !!}
                          <div class="form-group">
                            <div class="col-sm-12">
                              <input type="hidden" id="xqb" name="xqb" />
                              <input type="hidden" id="check_a" name="check_a" value="">
                              <input type="hidden" id="check_b" name="check_b" value="">
                              <input type="hidden" id="check_c" name="check_c" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="select_one">1.- ¿Qué probabilidad existe de que usted recomiende nuestros servicios con sus familiares, colegas o amigos? </label>
                            <div>
                              <select class="form-control" id="select_one" name="select_one">
                                  <option value="" selected>{{ trans('message.optionOne')}}</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                                  <option value="8">8</option>
                                  <option value="9">9</option>
                                  <option value="10">10</option>
                              </select>
                            </div>
                          </div>
                          <div id="content_select_question_inconforme" class="form-group">
                            <label for="select_question_inconforme">2.- ¿Cualés son lo aspectos del servicio con los que está inconforme y debemos mejorar? </label>
                            <select class="form-control" id="select_question_inconforme" name="select_question_inconforme" multiple="multiple" style="width: 100%;">
                                <option value="comment_xa">{{ trans('message.comercial') }}</option>
                                <option value="comment_xb">{{ trans('message.proyeceinst') }}</option>
                                <option value="comment_xc">{{ trans('message.soportetec') }}</option>
                            </select>
                          </div>
                          <div id="content_select_question_mejorar" class="form-group">
                            <label for="select_question_mejorar">2.- ¿Qué aspectos debemos mejorar para lograr la mayor probabilidad de que nos pueda recomendar? </label>
                            <select class="form-control" id="select_question_mejorar" name="select_question_mejorar" multiple="multiple" style="width: 100%;">
                              <option value="comment_xa">{{ trans('message.comercial') }}</option>
                              <option value="comment_xb">{{ trans('message.proyeceinst') }}</option>
                              <option value="comment_xc">{{ trans('message.soportetec') }}</option>
                            </select>
                          </div>
                          <div id="content_select_question_add" class="form-group">
                            <label for="select_question_add">2.- Deseas añadir un comentario adicional a </label>
                            <select class="form-control" id="select_question_add" name="select_question_add" multiple="multiple" style="width: 100%;">
                              <option value="comment_xa">{{ trans('message.comercial') }}</option>
                              <option value="comment_xb">{{ trans('message.proyeceinst') }}</option>
                            </select>
                          </div>

                          <div id="comment_ab" class="form-group">
                            <label for="comment_a" class="col-sm-12 control-label" style="text-align: left;"> {{ trans('message.text_help_question') }} {{ trans('message.comercial') }}</label>
                            <div class="col-sm-12">
                              <textarea id="comment_a" name="comment_a" class='form-control' cols="50" rows="3" maxlength="150" style="width: 100%;"></textarea>
                              <div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div>
                            </div>
                          </div>

                          <div id="comment_bc" class="form-group">
                            <label for="comment_b" class="col-sm-12 control-label" style="text-align: left;"> {{ trans('message.text_help_question') }} {{ trans('message.proyeceinst') }}</label>
                            <div class="col-sm-12">
                              <textarea id="comment_b" name="comment_b" class='form-control' cols="50" rows="3" maxlength="150" style="width: 100%;"></textarea>
                              <div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div>
                            </div>
                          </div>


                          <div id="comment_cd" class="form-group">
                            <label for="comment_c" class="col-sm-12 control-label" style="text-align: left;"> {{ trans('message.text_help_question') }} {{ trans('message.soportetec') }}</label>
                            <div class="col-sm-12">
                              <textarea id="comment_c" name="comment_c" class='form-control' cols="50" rows="3" maxlength="150" style="width: 100%;"></textarea>
                              <div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="select_evaluation">Evalua el servicio del mes de
                              <?php
                              $now = new \DateTime();
                              $date= $now->format('Y/m/d');
                              $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                              $numMes = date ("m", strtotime($date));
                              echo $meses[$numMes-2];
                            ?> con respecto a soporte.
                            </label>
                            <div>
                              <select class="form-control select2" id="select_evaluation" name="select_evaluation">
                                <option value="" selected>{{ trans('message.optionOne')}}</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                              </select>
                            </div>
                          </div>
                          <a id="approvalInfo" class="btn btn-success"><i class="fa fa-check-square"></i> {{ trans('message.approval')}}</a>
                          <a id="clearinfo" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                        {!! Form::close() !!}
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
            </div>
          </section>
        </section>
        <!--- Apartado nuevo de preguntas-->



        <!-- Apartado preguntas -->

        <!-- /.Apartado preguntas -->
    <?php
      }
    ?>



   @endif

  @endsection

@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'Encuestado')
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

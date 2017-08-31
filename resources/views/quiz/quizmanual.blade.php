@extends('layouts.app')
	
	@push('scripts')
	    <!--<script src="/js/quiz/questions.js"></script>-->
	    <link href="{{ asset('/plugins/jquery-bar-rating-master/dist/themes/bars-1to10.css') }}" rel="stylesheet" type="text/css" />
	    <script src="{{ asset('/plugins/jquery-bar-rating-master/dist/jquery.barrating.min.js') }}" type="text/javascript"></script>
	    <link href="{{ asset('/css/quizservice.css') }}" rel="stylesheet" type="text/css" />
	    <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  		<script src="/plugins/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
    @endpush

	@section('main-content')
        <!-- Encabezado de opciones de encuestas de servicio -->
        <div class="row">
          <div class="col-sm-12">
            <form id="xa_encuesta" name="xa_encuesta" class="form-horizontal">
	          	<div class="form-group">
		            <label for="selecthotelofclient">Elija el hotel<span style="color: red;">*</span></label>
		            <select id="selecthotelofclient" name="selecthotelofclient"  class="form-control select2" required>
		            <option value="" selected>{{ trans('message.optionOne')}}</option>
		            @foreach ($sql as $hotels)
		            	<option value="{{ $hotels->id_hotels }}">{{$hotels->Nombre_hotel}}</option>
		            @endforeach
		            </select>
		          </div>

		          <div class="form-group">
                    <label for="calendar_fecha">{{ trans('message.fecha')}}:</label>
                    <input type="text" class="form-control" id="calendar_fecha" maxlength="7" title="{{ trans('message.maxcarsiete')}}">
		          </div>
		          <div class="btn-group">
		            <a id="generatequizquest" class="btn btn-primary"><i class="fa fa-dot-circle-o "></i> Generar encuesta </a>
		            <a id="clearquizquest" class="btn btn-danger"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
		        </div>
            </form>
          </div>
        </div>
        <!-- /.Encabezado de opciones de encuestas de servicio -->

        <!-- Apartado preguntas -->
        <div class="row col-top" id="xy_quiz">
          <div class="col-sm-12">
            <div class="box box-solid">
              <!-- header quiz questions -->
              <div class="box-header with-border">
                <small class="pull-right">{{ trans('message.dateAct') }} <?php $now = new \DateTime();
                echo $now->format('d-m-Y');?><i class="fa fa-comments -o"></i> </small>
              </div>
              <!-- /.header quiz questions -->
              <!-- quiz questions -->
              <div class="box-body">
                <div class="row center">
                  {!! Form::open(['action' => 'QuizQuestionsController@store', 'url' => '/survey_form', 'method' => 'post', 'id' => 'delta']) !!}
                    <!-- Question One -->
                    <input type="hidden" id="xqb" name="xqb" />
                    <div class="col-sm-12">
                      <h4>
                          Con base en el servicio que le brindamos durante el mes de
                          <?php
                          $now = new \DateTime();
                          $date= $now->format('Y/m/d');
                          $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                          $numMes = date ("m", strtotime($date));
                          echo $meses[$numMes-1];
                          ?>
                          ¿Qué probabilidad existe de que usted recomiende nuestros servicios con sus familiares, colegas o amigos?
                      </h4>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                      <div id="answer_one" class="row">
                        <div class="col-sm-4">
                          <input type="radio" name="radio" id="radio1" value="100" class="radio"/>
                          <label class="borderlistradio" for="radio1">100 %</label>
                        </div>
                        <div class="col-sm-4">
                          <input type="radio" name="radio" id="radio2" value="0" class="radio"/>
                          <label class="borderlistradio" for="radio2">0 %</label>
                        </div>
                        <div class="col-sm-4">
                          <input type="radio" name="radio" id="radio3" value="ninguna" class="radio"/>
                          <label class="borderlistradio" for="radio3">Ninguna de las anteriores</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-2"></div>
                    <!-- Question One -->

                    <!-- Question Two Detractor-->
                    <div id="answer_two" class="col-sm-12 evaluation">
                      <h4>
                        ¿Cualés son lo aspectos del servicio con los que está inconforme y debemos mejorar?
                      </h4>
                      <div class="row">
                        <div class="col-sm-4">
                          <input type="checkbox" name="radiob2" id="radiob2" class="radio boxb" value='Comercial'/>
                          <label class="borderlistradio" for="radiob2">Comercial</label>
                        </div>
                        <div class="col-sm-4">
                          <input type="checkbox" name="radiob3" id="radiob3" class="radio boxb" value='ProyectoseInstalaciones'/>
                          <label class="borderlistradio" for="radiob3">Proyectos e instalaciones</label>
                        </div>
                        <div class="col-sm-4">
                          <input type="checkbox" name="radiob1" id="radiob1" class="radio boxb" value='SoporteTecnico'/>
                          <label class="borderlistradio" for="radiob1">Soporte Tecnico</label>
                        </div>
                      </div>
                    </div>
                    <!-- /.Question Two Detractor-->

                    <!-- Question Three Pasivo-->
                    <div id="answer_three" class="col-sm-12 evaluation">
                      <h4>
                        ¿Qué aspectos debemos mejorar para lograr la mayor probabilidad de que nos pueda recomendar?
                      </h4>
                      <div class="row">
                        <div class="col-sm-4">
                          <input type="checkbox" name="radioc2" id="radioc2" class="radio" value='Comercial'/>
                          <label class="borderlistradio" for="radioc2">Comercial</label>
                        </div>

                        <div class="col-sm-4">
                          <input type="checkbox" name="radioc3" id="radioc3" class="radio" value='ProyectoseInstalaciones'/>
                          <label class="borderlistradio" for="radioc3">Proyectos e instalaciones</label>
                        </div>

                        <div class="col-sm-4">
                          <input type="checkbox" name="radioc1" id="radioc1" class="radio" value='SoporteTecnico'/>
                          <label class="borderlistradio" for="radioc1">Soporte Tecnico</label>
                        </div>
                      </div>
                    </div>
                    <!-- /.Question Three Pasivo-->

                    <!-- Question Four Promotor-->
                    <div id="answer_four" class="col-sm-12 evaluation">
                      <div class="row row-separation">
                        <div class="col-sm-3"> <h5 class="interlineado-title"> Por favor ayúdanos con un comentario sobre tu experiencia con el servicio de Comercial </h5></div>
                        <div class="col-sm-9"><textarea id="comment_a" name="comment_a" cols="50" rows="5" maxlength="150"></textarea><div id="validation1"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div></div>
                      </div>

                      <div class="row row-separation">
                        <div class="col-sm-3"> <h5 class="interlineado-title"> Por favor ayúdanos con un comentario sobre tu experiencia con el servicio de Proyectos e instalaciones </h5></div>
                        <div class="col-sm-9"><textarea id="comment_b" name="comment_b" cols="50" rows="5" maxlength="150"></textarea><div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div></div>
                      </div>

                      <div class="row row-separation">
                        <div class="col-sm-3"> <h5 class="interlineado-title"> Por favor ayúdanos con un comentario sobre tu experiencia con el servicio de Soporte Tecnico </h5></div>
                        <div class="col-sm-9"><textarea id="comment_c" name="comment_c" cols="50" rows="5" maxlength="150"></textarea><div id="validation3"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div></div>
                      </div>
                    </div>
                    <!-- /.Question Four Promotor-->

                    <!-- Question Five Calificacion-->
                    <div id="answer_five" class="col-sm-12 evaluation">
                      <h4>Evalua el servicio del mes de <?php
                      $now = new \DateTime();
                      $date= $now->format('Y/m/d');
                      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                      $numMes = date ("m", strtotime($date));
                      echo $meses[$numMes-1];
                      ?> con respecto a soporte</h4>
                      <select id="example-1to10" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9" selected="selected">9</option>
                            <option value="10">10</option>
                      </select>
                    </div>
                    <!-- /.Question Five Calificacion-->

                    <!-- Question Button-->
                    <div class="col-sm-12 col-top">
                      <button id="register_quiz" type="button" class="btn bg-navy"><span class="fa fa-check-square" style="margin-right: 4px;"></span>Evaluar</button>
                      <button id="reload_quiz" type="button" class="btn bg-orange"><span class="fa fa-refresh" style="margin-right: 4px;"></span>Reiniciar</button>
                    </div>
                    <!-- ./Question Button-->


                  {!! Form::close() !!}
                </div>
              </div>
              <!-- /.quiz questions -->
            </div>
          </div>
        </div>
        <!-- /.Apartado preguntas -->
    @endsection

    @push('scripts')
    	<script src="/js/quiz/question_enc_manual.js"></script>
    @endpush
@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestado')
  @section('htmlheader_title')
      {{ trans('message.quiz') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.quiztest') }}
  @endsection

  @push('scripts')
  <link href="{{ asset('/plugins/bootstrap-multiselect-master/css/bootstrap-multiselect.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/bootstrap-multiselect-master/js/bootstrap-multiselect.js') }}" type="text/javascript"></script>

	<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="/plugins/datepicker/locales/bootstrap-datepicker.es.js" charset="UTF-8"></script>
	<script src="/js/quiz/question_individual.js"></script>

  @endpush

  @section('main-content')

   @if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
	 <section class="seleccion no-print">
		 <div class="row">
			 <div class="col-xs-12">

				 <!-- SELECT2 EXAMPLE -->
				 <div class="box box-primary">
					 <div class="box-header with-border">
						 <h3 class="box-title">Captura la información solicitada</h3>
					 </div>
					 <!-- /.box-header -->
					 <div class="box-body">
						 <!-- row -->
						 <div class="row">
							 {!! Form::open(['method' => 'post']) !!}
							 <div class="col-md-3 col-sm-6 col-xs-12">
								 <div class="form-group">
									 <label for="select_one" class="col-sm-12 control-label" style="text-align: left;">Hotel</label>
									 <div class="col-sm-12">
										 <select class="form-control select2" id="select_one" style="width: 100%;">
											 <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
											 @foreach ($sql as $info_enc)
											 <option value="{{ $info_enc->id_hotels }}"> {{ $info_enc->Nombre_hotel }} </option>
											 @endforeach
										 </select>
									 </div>
								 </div>
							 </div>

							 <div class="col-md-3 col-sm-6 col-xs-12">
								 <div class="form-group">
									 <label for="select_two" class="col-sm-12 control-label" style="text-align: left;">Cliente</label>
									 <div class="col-sm-12">
										 <select class="form-control select2" id="select_two"  style="width: 100%;"></select>
									 </div>
								 </div>
							 </div>

							 <div class="col-md-3 col-sm-6 col-xs-12">
								 <div class="form-group">
									 <label for="dolar" class="col-sm-12 control-label" style="text-align: left;">{{ trans('message.fecha') }}</label>
									 <div class="col-sm-12">
										 <input id="calendar_fecha" type="text" class="form-control" style="width: 100%;" maxlength="7" title="{{ trans('message.maxcarsiete')}}">
									 </div>
								 </div>
							 </div>

							 <div class="col-md-3 col-sm-6 col-xs-12">
								 <div class="form-group">
									 <div class="col-sm-12">
										 <div class="btn-group" style="margin-top: 23px;">
											 <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> {{ trans('message.generar')}}</a>
											 <a id="generateClear" class="btn btn-danger"><i class="fa fa-trash"></i> {{ trans('message.limpiar')}}</a>
										 </div>
									 </div>
								 </div>
							 </div>
							 {!! Form::close() !!}
						 </div>
						 <!-- /.row -->
					 </div>
					 <!-- /.box-body -->
					 <div class="box-footer">
						 <small><b>Nota: </b> Solo aparecen los hoteles que tengan asignado uno o mas encuestados</small>
					 </div>
				 </div>

			 </div>
		 </div>

     <div id="gama" class="row">
         <div class="col-xs-12">
           <div class="box box-info">
             <div class="box-header">
               <h3 class="box-title"> {{ trans('message.informacion') }}</h3>
             </div>
             <div class="box-body">
            {!! Form::open(['method' => 'post', 'id' => 'delta']) !!}
               <div class="form-group">
                 <label for="select_quest_one" class="col-sm-8 control-label" style="text-align: left;">{{ trans('message.text_title_questions') }} {{ trans('message.text_questions_one') }}</label>
                 <div class="col-sm-4">
                   <select class="form-control" id="select_quest_one" style="width: 100%;">
                     <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                     <option value="cien">{{ trans('message.cienporcentaje') }}</option>
                     <option value="cero">{{ trans('message.ceroporcentaje') }}</option>
                     <option value="ninguno">{{ trans('message.naporcentaje') }}</option>
                   </select>
                 </div>
               </div>

               <div class="form-group question_tone">
                 <label for="select_quest_two" class="col-sm-8 control-label" style="text-align: left;"> {{ trans('message.text_questions_two') }} </label>
                 <div class="col-sm-4">
                   <select id="select_quest_two" name="select_quest_two"  class="form-control" multiple="multiple" style="width: 100%;">
                     <option value="comment_xa">{{ trans('message.comercial') }}</option>
                     <option value="comment_xb">{{ trans('message.proyeceinst') }}</option>
                     <option value="comment_xc">{{ trans('message.soportetec') }}</option>
                   </select>
                 </div>
               </div>

               <div id="" class="form-group question_ttwo">
                 <label for="select_quest_three" class="col-sm-8 control-label" style="text-align: left;"> {{ trans('message.text_questions_three') }} </label>
                 <div class="col-sm-4">
                   <select id="select_quest_three" name="select_quest_three"  class="form-control" multiple="multiple" style="width: 100%;">
                     <option value="comment_xa">{{ trans('message.comercial') }}</option>
                     <option value="comment_xb">{{ trans('message.proyeceinst') }}</option>
                     <option value="comment_xc">{{ trans('message.soportetec') }}</option>
                   </select>
                 </div>
               </div>

               <div class="form-group comment_ab">
                 <label for="comment_a" class="col-sm-12 control-label" style="text-align: left;"> {{ trans('message.text_help_question') }} {{ trans('message.comercial') }}</label>
                 <div class="col-sm-12">
                   <textarea id="comment_a" name="comment_a" cols="50" rows="3" maxlength="150" style="width: 100%;"></textarea><div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div>
                 </div>
               </div>

               <div class="form-group comment_bc">
                 <label for="comment_b" class="col-sm-12 control-label" style="text-align: left;"> {{ trans('message.text_help_question') }} {{ trans('message.proyeceinst') }}</label>
                 <div class="col-sm-12">
                   <textarea id="comment_b" name="comment_b" cols="50" rows="3" maxlength="150" style="width: 100%;"></textarea><div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div>
                 </div>
               </div>

               <div class="form-group comment_cd">
                 <label for="comment_c" class="col-sm-12 control-label" style="text-align: left;"> {{ trans('message.text_help_question') }} {{ trans('message.soportetec') }}</label>
                 <div class="col-sm-12">
                   <textarea id="comment_c" name="comment_c" cols="50" rows="3" maxlength="150" style="width: 100%;"></textarea><div id="validation2"><small class="pull-right">Caracteres mínimo 4 y caracteres máximo 150.</small></div>
                 </div>
               </div>

               <div class="form-group question_tthree">
                 <label for="select_quest_calf" class="col-sm-8 control-label" style="text-align: left;">{{ trans('message.text_eval_month_general') }} {{ trans('message.soportetec') }}</label>
                 <div class="col-sm-4">
                   <select class="form-control" id="select_quest_calf" style="width: 100%;">
                     <option value="" selected="selected">{{ trans('message.optionOne') }}</option>
                     <?php
                     for ($i=1; $i <= 10 ; $i++) {
                       # code...
                    ?>
                     <option value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php
                     }
                    ?>
                   </select>
                 </div>
               </div>



               <div class="col-sm-12 col-top">
                 <button id="register_quiz" type="button" class="btn bg-navy"><span class="fa fa-check-square" style="margin-right: 4px;"></span>Evaluar</button>
                 <button id="reload_quiz" type="button" class="btn bg-orange"><span class="fa fa-refresh" style="margin-right: 4px;"></span>Reiniciar</button>
               </div>
            {!! Form::close() !!}


             </div>
           </div>
         </div>
     </div>

	 </section>


   @endif

   @if (Auth::user()->Privilegio == 'Encuestado')

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

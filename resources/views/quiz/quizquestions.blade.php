@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'Encuestado')
  @section('htmlheader_title')
      {{ trans('message.quiz') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.quiztest') }}
  @endsection

  @push('scripts')
  <script src="/js/quiz/questions.js"></script>
  <link href="{{ asset('/plugins/jquery-bar-rating-master/dist/themes/bars-1to10.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ asset('/plugins/jquery-bar-rating-master/dist/jquery.barrating.min.js') }}" type="text/javascript"></script>
  <style>
    h3{
      line-height: 1.5;
    }
    .center{
      text-align: center;
    }

    .borderlistradio {
      width: 200px;
      border-radius: 3px;
      border: 1px solid #D1D3D4;
    }

    /* hide input */
    input.radio:empty {
      display: none;
    	/*margin-left: -999px;*/
    }

    /* style label */
    input.radio:empty ~ label {
    	position: relative;
    	float: left;
    	/*line-height: 2.5em;
    	text-indent: 3.25em;*/
      line-height: 2.5em;
      text-indent: 2.6em;
    	margin-top: 2em;
    	cursor: pointer;
    	-webkit-user-select: none;
    	-moz-user-select: none;
    	-ms-user-select: none;
    	user-select: none;
    }

    input.radio:empty ~ label:before {
    	position: absolute;
    	display: block;
    	top: 0;
    	bottom: 0;
    	left: 0;
    	content: '';
    	width: 2.5em;
    	background: #D1D3D4;
    	border-radius: 3px 0 0 3px;
    }

    /* toggle hover */
    input.radio:hover:not(:checked) ~ label:before {
    	/*content:'\2714';*/
    	text-indent: .9em;
    	color: #C2C2C2;
    }

    input.radio:hover:not(:checked) ~ label {
    	color: #888;
    }

    /* toggle on */
    input.radio:checked ~ label:before {
    	/*content:'\2714';*/
    	text-indent: .9em;
    	color: #9CE2AE;
    	background-color: #ff851b;
    }

    input.radio:checked ~ label {
    	color: #000;
      background-color:rgba(242, 223, 156, 0.63);

    }

    textarea {
    	-webkit-box-sizing: border-box;
    	-moz-box-sizing: border-box;
    	box-sizing: border-box;
    	width: 100%;
    }

    .br-theme-bars-1to10 .br-widget a {
          width: 90px;
    }
    .col-top{
      margin-top: 2em;
    }
    .row-separation{
      padding-top: 20px;
    }
    .interlineado-title{
      line-height: 1.6;
    }
  </style>
  <script type="text/javascript">
    $(function() {
      // if($("input[name='radio']").is(':checked')) {
      //   var card_type = $('input[name=radio]:checked').val();
      //   alert(card_type);
      // }
      $('#example-1to10').barrating({
        theme: 'bars-1to10'
      });
      // $("#answer_one").hide();
      $("#answer_two").hide();
      $("#answer_three").hide();
      $("#answer_four").hide();
      $("#answer_five").hide();
      $('#comment_a').parent().parent().hide();
      $('#comment_b').parent().parent().hide();
      $('#comment_c').parent().parent().hide();

    });

    $('#answer_one input[name="radio"]').on('click', function() {
      if($('input:radio[name=radio]:checked').val() == "100"){
          $(".evaluation").hide();
          $("#answer_four").show()
          $("#answer_five").show();

          $('#comment_a').parent().parent().hide(100);
          $('#comment_a').val('');
          $('#comment_b').parent().parent().hide(100);
          $('#comment_b').val('');
          $('#comment_c').parent().parent().show(100);
          $('#comment_c').val('');
      }
      if($('input:radio[name=radio]:checked').val() == "0"){
          $(".evaluation").hide();
          $("#answer_two").show();
          $('input:checkbox').prop('checked', false);
          $("#answer_five").show();


          $('#comment_a').parent().parent().hide(100);
          $('#comment_a').val('');
          $('#comment_b').parent().parent().hide(100);
          $('#comment_b').val('');
          $('#comment_c').parent().parent().hide(100);
          $('#comment_c').val('');
      }
      if($('input:radio[name=radio]:checked').val() == "ninguna"){
          $(".evaluation").hide();
          $("#answer_three").show();
          $('input:checkbox').prop('checked', false);
          $("#answer_five").show();


          $('#comment_a').parent().parent().hide(100);
          $('#comment_a').val('');
          $('#comment_b').parent().parent().hide(100);
          $('#comment_b').val('');
          $('#comment_c').parent().parent().hide(100);
          $('#comment_c').val('');
      }
    });

    $('input[type="checkbox"]').click(function() {
        var id = $(this).prop('id');
        var status = $(this).is(':checked');
        //$(this).is(':checked') ? alert('checked ' + id) : alert('unchecked ' + id);

        selected_check(id, status, radiob2, comment_a);
        selected_check(id, status, radiob3, comment_b);
        selected_check(id, status, radiob1, comment_c);

        selected_check(id, status, radioc2, comment_a);
        selected_check(id, status, radioc3, comment_b);
        selected_check(id, status, radioc1, comment_c);
    });


     function selected_check(identificador, estado, idverificar, campoarea) {

      if( identificador == idverificar.id && estado == true){
          $('#answer_four').show(300);
          $('#'+campoarea.id).parent().parent().show(300);
          $('#'+campoarea.id).val('');
          //alert('true mostrar');
      }
      if( identificador == idverificar.id && estado == false){
          $('#'+campoarea.id).parent().parent().hide(100);
          $('#'+campoarea.id).val('');
          //alert('false ocultar');
      }
    }


    $("#register_quiz").click(function(event) {

		  var objData = $("#delta").serialize();
      //alert(objData);
      $.ajax({
           url: "/survey_form",
           type: "POST",
           data: objData,
           success: function (data) {
             alert(data);

           },
           error: function (data) {
             console.log('Error:', data);
           }
       });
    });




  </script>
  @endpush
  @section('main-content')
  <section class="content">
    <div class="row">
      <div class="col-md-12">


        <div class="box box-solid">
            <div class="box-header with-border">
              <div class="col-sm-10">
                <!--<h3 class="box-title"></h3>-->
              </div>
              <div class="col-sm-2">
                <i class="fa fa-comments -o"></i>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row center">
                {!! Form::open(['id' => 'delta']) !!}
                <div class="col-sm-12">
                  <h3>
                      Con base en el servicio que le brindamos durante el mes de
                      <?php
                      $now = new \DateTime();
                      $date= $now->format('Y/m/d');
                      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                      $numMes = date ("m", strtotime($date));
                      echo $meses[$numMes-1];
                      ?>
                      ¿Qué probabilidad existe de que usted recomiende nuestros servicios con sus familiares, colegas o amigos?
                  </h3>
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
                <!-- Detractor -->
                <div id="answer_two" class="col-sm-12 evaluation">
                  <h3>
                    ¿Cualés son lo aspectos del servicio con los que está inconforme y debemos mejorar?
                  </h3>

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
                <!-- Pasivo -->
                <div id="answer_three" class="col-sm-12 evaluation">
                  <h3>
                    ¿Qué aspectos debemos mejorar para lograr la mayor probabilidad de que nos pueda recomendar?
                  </h3>
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
                <!-- Promotor -->
                <div id="answer_four" class="col-sm-12 evaluation">
                  <div class="row row-separation">
                    <div class="col-sm-3"> <h4 class="interlineado-title"> Por favor ayúdanos con un comentario sobre tu experiencia con el servicio de Comercial </h4></div>
                    <div class="col-sm-9"><textarea id="comment_a" name="comment_a" cols="50" rows="5"></textarea></div>
                  </div>

                  <div class="row row-separation">
                    <div class="col-sm-3"> <h4 class="interlineado-title"> Por favor ayúdanos con un comentario sobre tu experiencia con el servicio de Proyectos e instalaciones </h4></div>
                    <div class="col-sm-9"><textarea id="comment_b" name="comment_b" cols="50" rows="5"></textarea></div>
                  </div>

                  <div class="row row-separation">
                    <div class="col-sm-3"> <h4 class="interlineado-title"> Por favor ayúdanos con un comentario sobre tu experiencia con el servicio de Soporte Tecnico </h4></div>
                    <div class="col-sm-9"><textarea id="comment_c" name="comment_c" cols="50" rows="5"></textarea></div>
                  </div>

                </div>
                <!-- Calificacion -->
                <div id="answer_five" class="col-sm-12 evaluation">
                  <h3>Evalua el servicio del mes de <?php
                  $now = new \DateTime();
                  $date= $now->format('Y/m/d');
                  $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                  $numMes = date ("m", strtotime($date));
                  echo $meses[$numMes-1];
                  ?></h3>
                  <select id="example-1to10" name="rating" autocomplete="off">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8" selected="selected">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                </div>
                {!! Form::close() !!}
                <div class="col-sm-12 col-top">
                  <button id="register_quiz" type="button" class="btn bg-navy"><span class="fa fa-check-square" style="margin-right: 4px;"></span>Evaluar</button>
                  <button id="reload_quiz" type="button" class="btn bg-orange"><span class="fa fa-refresh" style="margin-right: 4px;"></span>Reiniciar evaluación</button>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


      </div>
    </div>
  </section>
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

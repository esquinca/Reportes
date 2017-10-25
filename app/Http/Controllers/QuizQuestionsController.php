<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DateTime;

use \Crypt;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

class QuizQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index2($id)
     {
      $sin_encriptar =Crypt::encrypt($id);
      return $sin_encriptar;
     }
    public function index($id)
    {
      $id_encriptado = $id;
      $sin_encriptar =Crypt::decrypt($id);

      $shell_session = Auth::user()->shell;
      $id_session = Auth::user()->id;

      $mes = date("F");
      $year = date("Y");

      if ( $id_session != $sin_encriptar || $shell_session != $id_encriptado ) {
        # code...
        Auth::logout();
        notificationMsg('danger', 'Esta url no pertenece a su usuario o ha expirado..!!');
        return redirect('/');
      }
      else {
        $sql = DB::table('user_reportes')
              ->where([
                ['id', '=', $sin_encriptar],
                ['shell', '=', $id_encriptado],
                ['Privilegio', '=', 'Encuestado']])
              ->orWhere('Privilegio','=', 'Programador')
              ->orWhere('Privilegio','=', 'Admin')
              ->count();

        if ($sql == 0) {
          # code...
          return $respuesta = 'FALSE';
        }
        else{

          $selectdata = DB::table('relacionclientes')
                        ->select('id_hotels')
                        ->where('id_clientes', '=', $sin_encriptar)
                        ->orderBy('id', 'asc')
                        ->get();

          $selecdatanew= array();

          $resp_data_size= count($selectdata);

          $dataew = array('name' => 'San Juan',
                 'date' => date('Y-m-d'));

          if ( $resp_data_size == 0 ) {
            return view('quiz.quizquestions',compact('selecdatanew'));
          }
          else {
            for ($j=0; $j < $resp_data_size; $j++) {
              $identificador_hotel=$selectdata[$j]->id_hotels;
              $pregunta_califico_este_mes = DB::table('calificaciones')
                ->where('Mes', '=', $mes)
                ->where('Year1', '=', $year)
                ->where('hotels_id', '=', $identificador_hotel)
                ->get();

              if (empty($pregunta_califico_este_mes)) {

                $data_no_calif= DB::table('relacionclientes')
                              ->select('id_hotels', 'Nombre_hotel')
                              ->where('id_hotels', '=', $identificador_hotel)
                              ->where('id_clientes', '=', $sin_encriptar)
                              ->get();
                array_push($selecdatanew, $data_no_calif);
              }

            }
            return view('quiz.quizquestions',compact('selecdatanew'));
          }
        }
      }
      //return view('quiz.quizquestions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $correo = Auth::user()->email;

        $calificar_hotel_id = $request->xqb;

        $req_radio = $request->radio;

        $req_com_a = $request->comment_a;
        $req_com_b = $request->comment_b;
        $req_com_c = $request->comment_c;

        $req_radb1 = $request->radiob1;
        $req_radb2 = $request->radiob2;
        $req_radb3 = $request->radiob3;

        $req_radc1= $request->radioc1;
        $req_radc2= $request->radioc2;
        $req_radc3= $request->radioc3;

        $req_rating = $request->rating;
        $var_nps = "";
        if ($req_rating >= 9) { $var_nps = "PR"; }
        if ($req_rating >= 7) { $var_nps = "PS"; }
        if ($req_rating <= 6) { $var_nps = "D"; }

        $fechain = date("Y-m-d");
        $fecha_format= date("d F Y");
        $mes = date("F");
        $year = date("Y");

        $array_calif = explode(",", $calificar_hotel_id);
        $size_array_calif= count($array_calif);
        for ($i=0; $i < $size_array_calif; $i++) {
           $id_hotel_calificando = $array_calif[$i];
           # Base code...
           $consulta_nomb_hotel= DB::table('listarhoteles')->select('Nombre_hotel')->where('id', '=', $id_hotel_calificando)->value('Nombre_hotel');
           $auxiliar_calif = $consulta_nomb_hotel.' '.$fecha_format;

           if($req_radio === '100'){
             $sql= DB::table('calificaciones')->insert([
               ['Calificacion' => $req_rating,
                'Mes' => $mes,
                'Year1' => $year,
                'Pregunta1' => 'SoporteTecnico',
                'Probabilidad' =>  $var_nps,
                'Comentario3' =>  $req_com_c,
                'Cadena' => $correo,
                'Fecha' =>  $fechain,
                'hotels_id' =>  $id_hotel_calificando,
                'Aux' => $auxiliar_calif]
             ]);
           }
           if($req_radio === '0'){
             #Comercial       #Proyectos e Instalaciones     #Soporte tecnico
             #Condicion uno - Todos los comentarios
             if (!empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radb2 . "|" . $req_radb3 . "|" . $req_radb1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                    'Mes' => $mes,
                    'Year1' => $year,
                    'Pregunta1' => $valores,
                    'Probabilidad' =>  $var_nps,
                    'Comentario1' =>  $req_com_a,
                    'Comentario2' =>  $req_com_b,
                    'Comentario3' =>  $req_com_c,
                    'Cadena' => $correo,
                    'Fecha' =>  $fechain,
                    'hotels_id' =>  $id_hotel_calificando,
                    'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion dos - Solo el comentario negativo comercial
             if (!empty($req_com_a) && empty($req_com_b) && empty($req_com_c)) {
                 $valores = $req_radb2;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta1' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario1' =>  $req_com_a,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion tres - Solo el comentario negativo a comercial y proyectos e instalaciones
             if (!empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
                 $valores = $req_radb2 . "|" . $req_radb3;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                     'Mes' => $mes,
                     'Year1' => $year,
                     'Pregunta1' => $valores,
                     'Probabilidad' =>  $var_nps,
                     'Comentario1' =>  $req_com_a,
                     'Comentario2' =>  $req_com_b,
                     'Cadena' => $correo,
                     'Fecha' =>  $fechain,
                     'hotels_id' =>  $id_hotel_calificando,
                     'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion cuatro - Solo el comentario negativo a comercial y soporte
             if (!empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radb2 . "|" . $req_radb1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta1' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario1' =>  $req_com_a,
                   'Comentario3' =>  $req_com_c,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion cinco - Solo el comentario negativo a proyectos e instalaciones
             if (empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
                 $valores = $req_radb3;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta1' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario2' =>  $req_com_b,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion seis - Solo el comentario negativo a soporte
             if (empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radb1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta1' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario3' =>  $req_com_c,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion siete - Solo el comentario negativo a proyectos e instalaciones y soporte
             if (empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radb3 . "|" . $req_radb1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta1' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario2' =>  $req_com_b,
                   'Comentario3' =>  $req_com_c,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
           }
           if($req_radio === 'ninguna'){
             #Comercial       #Proyectos e Instalaciones     #Soporte tecnico
             #Condicion uno - Todos los comentarios
             if (!empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radc2 . "|" . $req_radc3 . "|" . $req_radc1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                    'Mes' => $mes,
                    'Year1' => $year,
                    'Pregunta2' => $valores,
                    'Probabilidad' =>  $var_nps,
                    'Comentario1' =>  $req_com_a,
                    'Comentario2' =>  $req_com_b,
                    'Comentario3' =>  $req_com_c,
                    'Cadena' => $correo,
                    'Fecha' =>  $fechain,
                    'hotels_id' =>  $id_hotel_calificando,
                    'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion dos - Solo el comentario negativo comercial
             if (!empty($req_com_a) && empty($req_com_b) && empty($req_com_c)) {
                 $valores = $req_radc2;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta2' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario1' =>  $req_com_a,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion tres - Solo el comentario negativo a comercial y proyectos e instalaciones
             if (!empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
                 $valores = $req_radc2 . "|" . $req_radc3;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                     'Mes' => $mes,
                     'Year1' => $year,
                     'Pregunta2' => $valores,
                     'Probabilidad' =>  $var_nps,
                     'Comentario1' =>  $req_com_a,
                     'Comentario2' =>  $req_com_b,
                     'Cadena' => $correo,
                     'Fecha' =>  $fechain,
                     'hotels_id' =>  $id_hotel_calificando,
                     'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion cuatro - Solo el comentario negativo a comercial y soporte
             if (!empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radc2 . "|" . $req_radc1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta2' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario1' =>  $req_com_a,
                   'Comentario3' =>  $req_com_c,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion cinco - Solo el comentario negativo a proyectos e instalaciones
             if (empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
                 $valores = $req_radc3;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta2' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario2' =>  $req_com_b,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion seis - Solo el comentario negativo a soporte
             if (empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radc1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta2' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario3' =>  $req_com_c,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
             #Condicion siete - Solo el comentario negativo a proyectos e instalaciones y soporte
             if (empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
                 $valores = $req_radc3 . "|" . $req_radc1;
                 $sql= DB::table('calificaciones')->insert([
                   ['Calificacion' => $req_rating,
                   'Mes' => $mes,
                   'Year1' => $year,
                   'Pregunta2' => $valores,
                   'Probabilidad' =>  $var_nps,
                   'Comentario2' =>  $req_com_b,
                   'Comentario3' =>  $req_com_c,
                   'Cadena' => $correo,
                   'Fecha' =>  $fechain,
                   'hotels_id' =>  $id_hotel_calificando,
                   'Aux' => $auxiliar_calif]
                 ]);
             }
           }
        }
      notificationMsg('success', 'Se guardó correctamente la calificación.. !!');
      return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

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

      $mes = date('F', strtotime('-1 month')) ;
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
    public function createdata(Request $request)
    {
           $correo = Auth::user()->email;//BIEN
          $var_ids = $request->xqb;
        $var_probd = $request->select_one;//BIEN
       $var_checka = $request->check_a;
       $var_checkb = $request->check_b;
       $var_checkc = $request->check_c;
      $valor_com_a = $request->comment_a;//BIEN
      $valor_com_b = $request->comment_b;//BIEN
      $valor_com_c = $request->comment_c;//BIEN
        $var_calif = $request->select_evaluation;

          $var_nps = "";//BIEN
    if ($var_calif >= 9) { $var_nps = "PR"; }//BIEN
    if ($var_calif >= 7) { $var_nps = "PS"; }//BIEN
    if ($var_calif <= 6) { $var_nps = "D"; }//BIEN

      $array_calif = explode(",", $var_ids);
 $size_array_calif = count($array_calif);

   $monthName = date('F', strtotime('-1 month')) ;
   $monthNumber = date('m', strtotime('-1 month')) ;
   $yearactual = date('Y') ;

    for ($i=0; $i < $size_array_calif; $i++) {
       $id_hotel_calificando = $array_calif[$i];
       $consulta_nomb_hotel= DB::table('HotelUserReport')->select('Nombre_hotel')->where('IDHotels', '=', $id_hotel_calificando)->value('Nombre_hotel');
       $auxiliar_calif = $consulta_nomb_hotel.' 28 '.$monthName.' '.$yearactual;
       $fecha_new_format=  $yearactual.'-'.$monthNumber.'-28';
       //echo  $auxiliar_calif."\n";

       if($var_calif >= 8){
         if ($var_checka == 1 && $var_checkb == 1) {
           $sql= DB::table('calificaciones')->insert([
             ['Calificacion' => $var_calif,
             'Mes' => $monthName,
             'Year1' => $yearactual,
             'Probabilidad' =>  $var_nps,
             'ProbabilidadNumero' =>  $var_probd,
             'Comentario1' =>  $valor_com_a,
             'Comentario2' =>  $valor_com_b,
             'Comentario3' =>  $valor_com_c,
             'Cadena' => $correo,
             'Aux' => $auxiliar_calif,
             'Fecha' =>  $fecha_new_format,
             'hotels_id' =>  $id_hotel_calificando]
           ]);
         }
         if ($var_checka == 1 && $var_checkb == '') {
           $sql= DB::table('calificaciones')->insert([
             ['Calificacion' => $var_calif,
             'Mes' => $monthName,
             'Year1' => $yearactual,
             'Probabilidad' =>  $var_nps,
             'ProbabilidadNumero' =>  $var_probd,
             'Comentario1' =>  $valor_com_a,
             'Comentario3' =>  $valor_com_c,
             'Cadena' => $correo,
             'Aux' => $auxiliar_calif,
             'Fecha' =>  $fecha_new_format,
             'hotels_id' =>  $id_hotel_calificando]
           ]);
         }
         if ($var_checka == '' && $var_checkb == 1) {
           $sql= DB::table('calificaciones')->insert([
             ['Calificacion' => $var_calif,
             'Mes' => $monthName,
             'Year1' => $yearactual,
             'Probabilidad' =>  $var_nps,
             'ProbabilidadNumero' =>  $var_probd,
             'Comentario2' =>  $valor_com_b,
             'Comentario3' =>  $valor_com_c,
             'Cadena' => $correo,
             'Aux' => $auxiliar_calif,
             'Fecha' =>  $fecha_new_format,
             'hotels_id' =>  $id_hotel_calificando]
           ]);
         }
         if($var_checka == '' && $var_checkb == '') {
           $sql= DB::table('calificaciones')->insert([
             ['Calificacion' => $var_calif,
             'Mes' => $monthName,
             'Year1' => $yearactual,
             'Probabilidad' =>  $var_nps,
             'ProbabilidadNumero' =>  $var_probd,
             'Comentario3' =>  $valor_com_c,
             'Cadena' => $correo,
             'Aux' => $auxiliar_calif,
             'Fecha' =>  $fecha_new_format,
             'hotels_id' =>  $id_hotel_calificando],
           ]);
         }
       }
       else {
          if ($var_checka == 1 && $var_checkb == ''&& $var_checkc == ''){
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario1' =>  $valor_com_a,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
          if ($var_checka == ''&& $var_checkb == 1 && $var_checkc == ''){
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario2' =>  $valor_com_b,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
          if ($var_checka == ''&& $var_checkb == ''&& $var_checkc == 1){
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario3' =>  $valor_com_c,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
          if ($var_checka == 1 && $var_checkb == 1 && $var_checkc == ''){
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario1' =>  $valor_com_a,
              'Comentario2' =>  $valor_com_b,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
          if ($var_checka == 1 && $var_checkb == ''&& $var_checkc == 1) {
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario1' =>  $valor_com_a,
              'Comentario3' =>  $valor_com_c,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
          if ($var_checka == ''&& $var_checkb == 1 && $var_checkc == 1) {
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario2' =>  $valor_com_b,
              'Comentario3' =>  $valor_com_c,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
          if ($var_checka == 1 && $var_checkb == 1 && $var_checkc == 1) {
            $sql= DB::table('calificaciones')->insert([
              ['Calificacion' => $var_calif,
              'Mes' => $monthName,
              'Year1' => $yearactual,
              'Probabilidad' =>  $var_nps,
              'ProbabilidadNumero' =>  $var_probd,
              'Comentario1' =>  $valor_com_a,
              'Comentario2' =>  $valor_com_b,
              'Comentario3' =>  $valor_com_c,
              'Cadena' => $correo,
              'Aux' => $auxiliar_calif,
              'Fecha' =>  $fecha_new_format,
              'hotels_id' =>  $id_hotel_calificando]
            ]);
          }
       }
     }
     notificationMsg('success', 'Registrados con exito. !!');
     return Redirect::back();
    //echo $size_array_calif;
    //echo  $var_checka."<br>".$var_checkb."<br>".$var_checkc. "<br>".$fecha_new_format."<br>".$fecha_new_format;
        // notificationMsg('success', 'Registro completado!!');
        //dd($request);
        // return Redirect::back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

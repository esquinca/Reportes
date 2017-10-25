<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

use DateTime;

class QuizQuestionsAdminController extends Controller
{
    public function index()
    {
      $sql = DB::table('relacionclientes')->select('id_hotels', 'Nombre_hotel')->where('privilegio', '=', 'Encuestado')->get();
    	return view('quiz.quizmanual', compact('sql'));
    }
    public function search(Request $request)
    {
      $id_hotel = $request->xa_iden;
      $sql = DB::table('relacionclientes')
                       ->select('id_clientes', 'email')
                       ->where('privilegio', '=', 'Encuestado')
                       ->where('id_hotels', '=', $id_hotel)
                       ->get();
        return json_encode($sql);
    }
    public function infocalf(Request $request)
    {
        $id_fecha = $request->calendar_fecha;
        $id_hotel = $request->select_one;
        $id_clien = $request->select_two;

        if ( !empty($id_fecha) ) {
          $array = explode("-", $id_fecha);
          $extraer_mes = $array[0];
          $extraer_year = $array[1];

          $dateObj   = DateTime::createFromFormat('!m', $extraer_mes);
          $monthName = $dateObj->format('F');

          $pregunta_califico_este_mes = DB::table('calificaciones')
          ->where('Mes', '=', $monthName)
          ->where('Year1', '=', $extraer_year)
          ->where('hotels_id', '=', $id_hotel)
          ->get();
          $contador =count($pregunta_califico_este_mes);
          if ( $contador != 0) { return '1'; }
          else { return '0'; }
        }
        else { return '0'; }
    }
    public function registrandocalif(Request $request){
              $var_hotel = $request->var_xa;
            $var_cliente = $request->var_xb;
              $var_fecha = $request->var_xc;
       $var_probabilidad = $request->var_xd;
         $var_inconforme = $request->var_xe;
            $var_mejorar = $request->var_xf;
          $var_comercial = $request->var_xg;
          $var_proyectos = $request->var_xh;
            $var_soporte = $request->var_xi;
       $var_calificacion = $request->var_xj;
       $var_nps = "";
       if ($var_calificacion >= 9) { $var_nps = "PR"; }
       if ($var_calificacion >= 7) { $var_nps = "PS"; }
       if ($var_calificacion <= 6) { $var_nps = "D"; }
       $correo = Auth::user()->email;


       $array = explode("-", $var_fecha);
       $extraer_mes = $array[0];
       $extraer_year = $array[1];
       $dateObj   = DateTime::createFromFormat('!m', $extraer_mes);
       $monthName = $dateObj->format('F');
       $fecha_format= '28 '.$monthName.' '.$extraer_year;

       $consulta_nomb_hotel= DB::table('listarhoteles')->select('Nombre_hotel')->where('id', '=', $var_hotel)->value('Nombre_hotel');
       $auxiliar_calif = $consulta_nomb_hotel.' '.$fecha_format;

        $fecha_new_format=$extraer_year.'-'.$extraer_mes.'-28';

        $sql= DB::table('calificaciones')->insert([
          ['Calificacion' => $var_calificacion,
          'Mes' => $monthName,
          'Year1' => $extraer_year,
          'Pregunta1' => 'SoporteTecnico',
          'Probabilidad' =>  $var_nps,
          'Comentario3' =>  $var_soporte,
          'Cadena' => $correo,
          'Fecha' =>  $fecha_new_format,
          'hotels_id' =>  $var_hotel,
          'Aux' => $auxiliar_calif]
        ]);

    }

}

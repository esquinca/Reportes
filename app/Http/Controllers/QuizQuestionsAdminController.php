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
              $correo = Auth::user()->email;
           $var_hotel = $request->var_xa;
         $var_cliente = $request->var_xb;
           $var_fecha = $request->var_xc;
      $var_recomienda = $request->var_xd;
         $var_ninguna = $request->var_xe;
            $var_cero = $request->var_xf;
       $var_adicional = $request->var_xg;
           $var_com_a = $request->var_xh;
           $var_com_b = $request->var_xi;
           $var_com_c = $request->var_xj;
           $var_calif = $request->var_xk;
           $var_nps = "";

           $var_checka = $request->var_xl;
           $var_checkb = $request->var_xm;
           $var_checkc = $request->var_xn;

           if ($var_calif >= 9) { $var_nps = "PR"; }
           if ($var_calif >= 7) { $var_nps = "PS"; }
           if ($var_calif <= 6) { $var_nps = "D";  }

           $array = explode("-", $var_fecha);
           $extraer_mes = $array[0];
           $extraer_year = $array[1];
           $dateObj   = DateTime::createFromFormat('!m', $extraer_mes);
           $monthName = $dateObj->format('F');
           $fecha_format= '28 '.$monthName.' '.$extraer_year;

           $consulta_nomb_hotel= DB::table('HotelUserReport')->select('Nombre_hotel')->where('IDHotels', '=', $var_hotel)->value('Nombre_hotel');
           $consulta_email= DB::table('user_reportes')->select('email')->where('id', '=', $var_cliente)->value('email');
           $auxiliar_calif = $consulta_nomb_hotel.' '.$fecha_format;
           $fecha_new_format=$extraer_year.'-'.$extraer_mes.'-28';

           if($var_recomienda >= 8){
             if ($var_checka == 1 && $var_checkb == 1) {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario1' =>  $var_com_a,
                 'Comentario2' =>  $var_com_b,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == 1 && $var_checkb == '') {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario1' =>  $var_com_a,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == '' && $var_checkb == 1) {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario2' =>  $var_com_b,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == '' && $var_checkb == '') {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
           }
           else {
             if ($var_checka == 1 && $var_checkb == '' && $var_checkc == '') {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario1' =>  $var_com_a,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == '' && $var_checkb == 1 && $var_checkc == '') {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario2' =>  $var_com_b,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == '' && $var_checkb == '' && $var_checkc == 1) {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == 1 && $var_checkb == 1 && $var_checkc == '') {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario1' =>  $var_com_a,
                 'Comentario2' =>  $var_com_b,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == 1 && $var_checkb == '' && $var_checkc == 1) {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario1' =>  $var_com_a,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == '' && $var_checkb == 1 && $var_checkc == 1) {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario2' =>  $var_com_b,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
             if ($var_checka == 1 && $var_checkb == 1 && $var_checkc == 1) {
               $sql= DB::table('calificaciones')->insert([
                 ['Calificacion' => $var_calif,
                 'Mes' => $monthName,
                 'Year1' => $extraer_year,
                 'Probabilidad' =>  $var_nps,
                 'Comentario1' =>  $var_com_a,
                 'Comentario2' =>  $var_com_b,
                 'Comentario3' =>  $var_com_c,
                 'Cadena' => $correo,
                 'Aux' => $auxiliar_calif,
                 'Fecha' =>  $fecha_new_format,
                 'hotels_id' =>  $var_hotel]
               ]);
             }
           }
           if ($sql == true) {
             return 1;
           }
           else {
             return 0;
           }
    }

}

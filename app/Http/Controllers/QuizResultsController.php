<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class QuizResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //SELECT `Year1` FROM `calificaciones` GROUP BY `Year1` ORDER BY `Year1` ASC
      $selectYear = DB::table('calificaciones')->select('Year1')->groupBy('Year1')->orderBy('Year1', 'asc')->get();
      return view('quiz.quizresults', compact('selectYear'));
       //return view('quiz.quizresults');
    }

    public function view(Request $request)
    {
      $year= $request->searchyear;
      $vertical= $request->searchvertical;
      $operation= $request->searchoperation;

      if ($year == '' && $vertical == '' && $operation == '') {
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                    ->select('id')
                    ->pluck('id');


        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] , "hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" =>  $sql_seven[$i] ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {

            for ($z=0; $z <= 11; $z++) {

              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-1
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];

                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }

                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }

              }

              if( $z == 11){
                $data_one = array_collapse($data_one);

                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);

                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

                $data_three = array_collapse($data_three);


                array_push($data_two,$data_one);
                array_push($data_two,$data_three);

                $data_two = array_collapse($data_two);

                array_push($data_four,$data_two);

              }

            }

          }

        }
      }

      if ($year != '' && $vertical != '' && $operation != '') {
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Year1', '=', $year)
                    ->where('Vertical', '=', $vertical)
                    ->where('Operacion', '=', $operation)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->where('Year1', '=', $year)
                   ->where('Vertical', '=', $vertical)
                   ->where('Operacion', '=', $operation)
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->where('Year1', '=', $year)
                   ->where('Vertical', '=', $vertical)
                   ->where('Operacion', '=', $operation)
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] , "hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" => $sql_seven[$i] ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {

            for ($z=0; $z <= 11; $z++) {
              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-9
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];
                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }
                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }
              }
              if( $z == 11){
                $data_one = array_collapse($data_one);
                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);
                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                $data_three = array_collapse($data_three);
                array_push($data_two,$data_one);
                array_push($data_two,$data_three);
                $data_two = array_collapse($data_two);
                array_push($data_four,$data_two);
              }
            }
          }
        }
      }

      if ($year != '' && $vertical == '' && $operation == '') {
        //$v='si hay año pero no vertical' & Ni operacion
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Year1', '=', $year)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Year1', '=', $year)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Year1', '=', $year)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                    ->select('IT')
                    ->where('Year1', '=', $year)
                    ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                    ->select('Promedio')
                    ->where('Year1', '=', $year)
                    ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Year1', '=', $year)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Year1', '=', $year)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Year1', '=', $year)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] ,"hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" => $sql_seven[$i] ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {
            for ($z=0; $z <= 11; $z++) {
              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-9
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];
                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }
                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }
              }
              if( $z == 11){
                $data_one = array_collapse($data_one);
                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);
                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                $data_three = array_collapse($data_three);
                array_push($data_two,$data_one);
                array_push($data_two,$data_three);
                $data_two = array_collapse($data_two);
                array_push($data_four,$data_two);
              }
            }
          }
        }
      }
      if ($year == '' && $vertical != '' && $operation == '') {
        //$v='si hay vertical pero no año ni operacion';
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Vertical', '=', $vertical)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Vertical', '=', $vertical)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Vertical', '=', $vertical)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->where('Vertical', '=', $vertical)
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->where('Vertical', '=', $vertical)
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Vertical', '=', $vertical)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Vertical', '=', $vertical)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Vertical', '=', $vertical)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] ,"hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" => $sql_seven[$i]  ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {
            for ($z=0; $z <= 11; $z++) {
              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-9
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];
                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }
                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }
              }
              if( $z == 11){
                $data_one = array_collapse($data_one);
                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);
                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                $data_three = array_collapse($data_three);
                array_push($data_two,$data_one);
                array_push($data_two,$data_three);
                $data_two = array_collapse($data_two);
                array_push($data_four,$data_two);
              }
            }
          }
        }
      }
      if ($year == '' && $vertical == '' && $operation != '') {
        //$v='si hay operation pero no año ni vertical';
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Operacion', '=', $operation)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Operacion', '=', $operation)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Operacion', '=', $operation)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->where('Operacion', '=', $operation)
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->where('Operacion', '=', $operation)
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Operacion', '=', $operation)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Operacion', '=', $operation)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Operacion', '=', $operation)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] , "hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" => $sql_seven[$i]) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {
            for ($z=0; $z <= 11; $z++) {
              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-9
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];
                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }
                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }
              }
              if( $z == 11){
                $data_one = array_collapse($data_one);
                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);
                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                $data_three = array_collapse($data_three);
                array_push($data_two,$data_one);
                array_push($data_two,$data_three);
                $data_two = array_collapse($data_two);
                array_push($data_four,$data_two);
              }
            }
          }
        }
      }
      //
      if ($year != '' && $vertical != '' && $operation == '') {
        //$v='si hay año & vertical pero no Operacion';
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Year1', '=', $year)
                    ->where('Vertical', '=', $vertical)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->where('Year1', '=', $year)
                   ->where('Vertical', '=', $vertical)
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->where('Year1', '=', $year)
                   ->where('Vertical', '=', $vertical)
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Year1', '=', $year)
                  ->where('Vertical', '=', $vertical)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
           # code................................................................
           array_push($data_one, array("identificador" => $sql_eight[$i] ,"hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" => $sql_seven[$i] ) );
           # code................................................................
           $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
           // $numero  = count($cal_pos);
           $array_caracter = explode("&|", $cal_pos); // ------>$array
           $numero = count($array_caracter);
           $numero = count($array_caracter);
           if ($numero <= '1') {
             $valor = $sql_three[$i]; //  August-9
             $arraydos = explode("-", $valor);
             $extraer_mes = $arraydos[0];
             switch ($extraer_mes) {
               case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
               case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
               case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
               case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
               case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
               case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
               case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
               case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
               case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
               case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
               case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
               case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
             }
              $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

              $data_one = array_collapse($data_one);

              $mes_n0=array_key_exists('January', $data_one);
              $mes_n1=array_key_exists('February', $data_one);
              $mes_n2=array_key_exists('March', $data_one);
              $mes_n3=array_key_exists('April', $data_one);
              $mes_n4=array_key_exists('May', $data_one);
              $mes_n5=array_key_exists('June', $data_one);
              $mes_n6=array_key_exists('July', $data_one);
              $mes_n7=array_key_exists('August', $data_one);
              $mes_n8=array_key_exists('September', $data_one);
              $mes_n9=array_key_exists('October', $data_one);
              $mes_n10=array_key_exists('November', $data_one);
              $mes_n11=array_key_exists('December', $data_one);

              if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
              if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
              if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
              if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
              if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
              if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
              if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
              if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
              if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
              if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
              if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
              if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

              $data_three = array_collapse($data_three);


              array_push($data_two,$data_one);
              array_push($data_two,$data_three);

              $data_two = array_collapse($data_two);

              array_push($data_four,$data_two);
           }
           else {
             for ($z=0; $z <= 11; $z++) {
               if ($z <= ($numero-1) ) {
                 $valor = $array_caracter[$z]; //  January-9
                 $arraydos = explode("-", $valor);
                 $extraer_mes = $arraydos[0];
                 switch ($extraer_mes) {
                   case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                   case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                   case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                   case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                   case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                   case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                   case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                   case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                   case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                   case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                   case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                   case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                 }
                 if($z == ($numero-2)){
                   $mes_ant=$arraydos[1];
                 }
                 if($z == ($numero-1)){
                   $mes_ultiomo=$arraydos[1];
                   // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                   // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                   // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                   if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                   if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                   if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                 }
               }
               if( $z == 11){
                 $data_one = array_collapse($data_one);
                 $mes_n0=array_key_exists('January', $data_one);
                 $mes_n1=array_key_exists('February', $data_one);
                 $mes_n2=array_key_exists('March', $data_one);
                 $mes_n3=array_key_exists('April', $data_one);
                 $mes_n4=array_key_exists('May', $data_one);
                 $mes_n5=array_key_exists('June', $data_one);
                 $mes_n6=array_key_exists('July', $data_one);
                 $mes_n7=array_key_exists('August', $data_one);
                 $mes_n8=array_key_exists('September', $data_one);
                 $mes_n9=array_key_exists('October', $data_one);
                 $mes_n10=array_key_exists('November', $data_one);
                 $mes_n11=array_key_exists('December', $data_one);
                 if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                 if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                 if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                 if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                 if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                 if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                 if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                 if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                 if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                 if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                 if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                 if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                 $data_three = array_collapse($data_three);
                 array_push($data_two,$data_one);
                 array_push($data_two,$data_three);
                 $data_two = array_collapse($data_two);
                 array_push($data_four,$data_two);
               }
             }
           }
         }
      }
      if ($year != '' && $vertical == '' && $operation != '') {
        //$v='si hay año & Operacion pero no vertical';
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Year1', '=', $year)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Year1', '=', $year)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Year1', '=', $year)
                    ->where('Operacion', '=', $operation)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->where('Year1', '=', $year)
                   ->where('Operacion', '=', $operation)
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->where('Year1', '=', $year)
                   ->where('Operacion', '=', $operation)
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Year1', '=', $year)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Year1', '=', $year)
                  ->where('Operacion', '=', $operation)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Year1', '=', $year)
                  ->where('Operacion', '=', $operation)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] ,"hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i], "UltimoComentario" => $sql_seven[$i] ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {
            for ($z=0; $z <= 11; $z++) {
              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-9
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];
                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }
                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }
              }
              if( $z == 11){
                $data_one = array_collapse($data_one);
                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);
                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                $data_three = array_collapse($data_three);
                array_push($data_two,$data_one);
                array_push($data_two,$data_three);
                $data_two = array_collapse($data_two);
                array_push($data_four,$data_two);
              }
            }
          }
        }
      }
      if ($year == '' && $vertical != '' && $operation != '') {
        //$v='si hay vertical & operacion pero no año';
        $sql_one= DB::table('DashboardCalificacion')
                  ->select('Nombre_hotel')
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Nombre_hotel');

        $sql_two= DB::table('DashboardCalificacion')
                  ->select('Vertical')
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Vertical');

        $sql_three= DB::table('DashboardCalificacion')
                    ->select('CALIFICACION')
                    ->where('Vertical', '=', $vertical)
                    ->where('Operacion', '=', $operation)
                    ->pluck('CALIFICACION');

        $sql_four= DB::table('DashboardCalificacion')
                   ->select('IT')
                   ->where('Vertical', '=', $vertical)
                   ->where('Operacion', '=', $operation)
                   ->pluck('IT');

        $sql_five= DB::table('DashboardCalificacion')
                   ->select('Promedio')
                   ->where('Vertical', '=', $vertical)
                   ->where('Operacion', '=', $operation)
                   ->pluck('Promedio');

        $sql_six= DB::table('DashboardCalificacion')
                  ->select('Year1')
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('Year1');

        $sql_seven= DB::table('DashboardCalificacion')
                  ->select('UltimoComentario')
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('UltimoComentario');

        $sql_eight= DB::table('DashboardCalificacion')
                  ->select('id')
                  ->where('Vertical', '=', $vertical)
                  ->where('Operacion', '=', $operation)
                  ->pluck('id');

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        $data_three = array();
        $data_four = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("identificador" => $sql_eight[$i] ,"hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" => $sql_seven[$i] ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);
          $numero = count($array_caracter);
          if ($numero <= '1') {
            $valor = $sql_three[$i]; //  August-9
            $arraydos = explode("-", $valor);
            $extraer_mes = $arraydos[0];
            switch ($extraer_mes) {
              case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
            }
             $indica = '🖒'; array_push($data_one, array( "indicador" => $indica ));

             $data_one = array_collapse($data_one);

             $mes_n0=array_key_exists('January', $data_one);
             $mes_n1=array_key_exists('February', $data_one);
             $mes_n2=array_key_exists('March', $data_one);
             $mes_n3=array_key_exists('April', $data_one);
             $mes_n4=array_key_exists('May', $data_one);
             $mes_n5=array_key_exists('June', $data_one);
             $mes_n6=array_key_exists('July', $data_one);
             $mes_n7=array_key_exists('August', $data_one);
             $mes_n8=array_key_exists('September', $data_one);
             $mes_n9=array_key_exists('October', $data_one);
             $mes_n10=array_key_exists('November', $data_one);
             $mes_n11=array_key_exists('December', $data_one);

             if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
             if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
             if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
             if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
             if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
             if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
             if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
             if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
             if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
             if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
             if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
             if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }

             $data_three = array_collapse($data_three);


             array_push($data_two,$data_one);
             array_push($data_two,$data_three);

             $data_two = array_collapse($data_two);

             array_push($data_four,$data_two);
          }
          else {
            for ($z=0; $z <= 11; $z++) {
              if ($z <= ($numero-1) ) {
                $valor = $array_caracter[$z]; //  January-9
                $arraydos = explode("-", $valor);
                $extraer_mes = $arraydos[0];
                switch ($extraer_mes) {
                  case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
                  case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
                  case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
                  case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
                  case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
                  case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
                  case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
                  case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
                  case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
                  case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
                  case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
                  case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
                }
                if($z == ($numero-2)){
                  $mes_ant=$arraydos[1];
                }
                if($z == ($numero-1)){
                  $mes_ultiomo=$arraydos[1];
                  // if($mes_ant < $mes_ultiomo) { $indica = 'fa-thumbs-up'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant == $mes_ultiomo){ $indica = 'fa-hand-o-right'; array_push($data_one, array( "indicador" => $indica )); }
                  // if($mes_ant > $mes_ultiomo) { $indica = 'fa-thumbs-down'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant < $mes_ultiomo) { $indica = '🖒'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant == $mes_ultiomo){ $indica = '☞'; array_push($data_one, array( "indicador" => $indica )); }
                  if($mes_ant > $mes_ultiomo) { $indica = '👎'; array_push($data_one, array( "indicador" => $indica )); }
                }
              }
              if( $z == 11){
                $data_one = array_collapse($data_one);
                $mes_n0=array_key_exists('January', $data_one);
                $mes_n1=array_key_exists('February', $data_one);
                $mes_n2=array_key_exists('March', $data_one);
                $mes_n3=array_key_exists('April', $data_one);
                $mes_n4=array_key_exists('May', $data_one);
                $mes_n5=array_key_exists('June', $data_one);
                $mes_n6=array_key_exists('July', $data_one);
                $mes_n7=array_key_exists('August', $data_one);
                $mes_n8=array_key_exists('September', $data_one);
                $mes_n9=array_key_exists('October', $data_one);
                $mes_n10=array_key_exists('November', $data_one);
                $mes_n11=array_key_exists('December', $data_one);
                if ($mes_n0 == false ) { array_push( $data_three, array( "January" => ' ' )); }
                if ($mes_n1 == false ) { array_push( $data_three, array( "February" => ' ' )); }
                if ($mes_n2 == false ) { array_push( $data_three, array( "March" => ' ' )); }
                if ($mes_n3 == false ) { array_push( $data_three, array( "April" => ' ' )); }
                if ($mes_n4 == false ) { array_push( $data_three, array( "May" => ' ' )); }
                if ($mes_n5 == false ) { array_push( $data_three, array( "June" => ' ' )); }
                if ($mes_n6 == false ) { array_push( $data_three, array( "July" => ' ' )); }
                if ($mes_n7 == false ) { array_push( $data_three, array( "August" => ' ' )); }
                if ($mes_n8 == false ) { array_push( $data_three, array( "September" => ' ' )); }
                if ($mes_n9 == false ) { array_push( $data_three, array( "October" => ' ' )); }
                if ($mes_n10 == false ) { array_push( $data_three, array( "November" => ' ' )); }
                if ($mes_n11 == false ) { array_push( $data_three, array( "December" => ' ' )); }
                $data_three = array_collapse($data_three);
                array_push($data_two,$data_one);
                array_push($data_two,$data_three);
                $data_two = array_collapse($data_two);
                array_push($data_four,$data_two);
              }
            }
          }
        }
      }

      return json_encode($data_four);
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
        $id= $request->sector;
        $data = DB::table('calificaciones')->where('hotels_id', '=', $id)->max('Fecha');
        $sql= DB::table('calificaciones')->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha')
              ->where('Fecha', '=', $data)
              ->where('hotels_id', '=', $id)
              ->get();
        return json_encode($sql);
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

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
       return view('quiz.quizresults');
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

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        for ($i=0; $i <= ($longitud-1); $i++) {

          # code................................................................
          array_push($data_one, array("hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "Promedio" => $sql_five[$i] ) );
          # code................................................................
          $cal_pos = $sql_three[$i];// January-9&|February-9&|March-9&|April-9&|May-9&|June-10&|July-10
          // $numero  = count($cal_pos);
          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);

          $month_0= false;  $month_1= false;  $month_2= false;  $month_3= false;
          $month_4= false;  $month_5= false;  $month_6= false;  $month_7= false;
          $month_8= false;  $month_9= false;  $month_10= false; $month_11= false;


          for ($z=0; $z <= 11; $z++) {

            if ($z <= ($numero-1) ) {
              $valor = $array_caracter[$z]; //  January-9
              $arraydos = explode("-", $valor);
              $extraer_mes = $arraydos[0];

              if ($extraer_mes == 'January') { array_push($data_one, array( "January" => $arraydos[1] )); }
              else { array_push($data_one, array( "January" => ' ' )); }

              if ($extraer_mes == 'February') { array_push($data_one, array( "February" => $arraydos[1] )); }
              else { array_push($data_one, array( "February" => ' ' )); }

              if ($extraer_mes == 'March') { array_push($data_one, array( "March" => $arraydos[1] )); }
              else { array_push($data_one, array( "March" => ' ' )); }

              if ($extraer_mes == 'April') { array_push($data_one, array( "April" => $arraydos[1] )); }
              else { array_push($data_one, array( "April" => ' ' )); }

              if ($extraer_mes == 'May') { array_push($data_one, array( "May" => $arraydos[1] )); }
              else { array_push($data_one, array( "May" => ' ' )); }

              if ($extraer_mes == 'June') { array_push($data_one, array( "June" => $arraydos[1] )); }
              else { array_push($data_one, array( "June" => ' ' )); }

              if ($extraer_mes == 'July') { array_push($data_one, array( "July" => $arraydos[1] )); }
              else { array_push($data_one, array( "July" => ' ' )); }

              if ($extraer_mes == 'August') { array_push($data_one, array( "August" => $arraydos[1] )); }
              else { array_push($data_one, array( "August" => ' ' )); }

              if ($extraer_mes == 'September') { array_push($data_one, array( "September" => $arraydos[1] )); }
              else { array_push($data_one, array( "September" => ' ' )); }

              if ($extraer_mes == 'October') { array_push($data_one, array( "October" => $arraydos[1] )); }
              else { array_push($data_one, array( "October" => ' ' )); }

              if ($extraer_mes == 'November') { array_push($data_one, array( "November" => $arraydos[1] )); }
              else { array_push($data_one, array( "November" => ' ' )); }

              if ($extraer_mes == 'December') { array_push($data_one, array( "December" => $arraydos[1] )); }
              else { array_push($data_one, array( "December" => ' ' )); }
              // switch ($extraer_mes) {
              //   case 'January':  $month_0= true;  array_push($data_one, array( "January" => $arraydos[1] )); break;
              //   case 'February': $month_1= true;  array_push($data_one, array( "February" => $arraydos[1] )); break;
              //   case 'March':    $month_2= true;  array_push($data_one, array( "March" => $arraydos[1] )); break;
              //   case 'April':    $month_3= true;  array_push($data_one, array( "April" => $arraydos[1] )); break;
              //   case 'May':      $month_4= true;  array_push($data_one, array( "May" => $arraydos[1] )); break;
              //   case 'June':     $month_5= true;  array_push($data_one, array( "June" => $arraydos[1] )); break;
              //   case 'July':     $month_6= true;  array_push($data_one, array( "July" => $arraydos[1] )); break;
              //   case 'August':   $month_7= true;  array_push($data_one, array( "August" => $arraydos[1] )); break;
              //   case 'September':$month_8= true;  array_push($data_one, array( "September" => $arraydos[1] )); break;
              //   case 'October':  $month_9= true;  array_push($data_one, array( "October" => $arraydos[1] )); break;
              //   case 'November': $month_10= true; array_push($data_one, array( "November" => $arraydos[1] )); break;
              //   case 'December': $month_11= true; array_push($data_one, array( "December" => $arraydos[1] )); break;
              // }

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
            // else{
            //   for ($a=0; $a>($numero-1) ; $a++) {
            //     # code...
            //   }
            //
            // }

            if( $z == 11){
              $data_one = array_collapse($data_one);
              array_push($data_two,$data_one);
            }

          }

        }
      }
      /*
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

        $longitud = count($sql_one);
        $data = array();
        $data_one = array();
        $data_two = array();
        for ($i=0; $i <= ($longitud-1); $i++) {
          # code................................................................
          array_push($data_one, array("hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] , "Promedio" => $sql_five[$i]  ) );
          # code................................................................

          $cal_pos = $sql_three[$i];// January 2017-9&|February 2017-9&|March 2017-9&|April 2017-9&|May 2017-9&|June 2017-10&|July 2017-10
          // $numero  = count($cal_pos);

          $array_caracter = explode("&|", $cal_pos); // ------>$array
          $numero = count($array_caracter);

          for ($z=0; $z <= 11; $z++) {
            if ($z <= ($numero-1) ) {
              $valor = $array_caracter[$z]; //  January 2017-9
              $arraydos = explode("-", $valor);
              array_push($data_one, array( "mes".$z => $arraydos[1] ));

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
            else {
              array_push($data_one, array( "mes".$z => ' ' ));
            }
            if( $z == 11){
              $data_one = array_collapse($data_one);
              array_push($data_two,$data_one);
            }
          }
        }
      }

      if ($year != '' && $vertical == '' && $operation == '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('DashboardCalificacion')
              ->where('Year1', '=', $year)
              ->get();
      }
      if ($year == '' && $vertical != '' && $operation == '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('DashboardCalificacion')
              ->where('Vertical', '=', $vertical)
              ->get();
      }
      if ($year == '' && $vertical == '' && $operation != '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('DashboardCalificacion')
              ->where('Operacion', '=', $operation)
              ->get();
      }


      if ($year != '' && $vertical != '' && $operation == '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('DashboardCalificacion')
              ->where('Year1', '=', $year)
              ->where('Vertical', '=', $vertical)
              ->get();
      }
      if ($year != '' && $vertical == '' && $operation != '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('DashboardCalificacion')
              ->where('Year1', '=', $year)
              ->where('Operacion', '=', $operation)
              ->get();
      }
      if ($year == '' && $vertical != '' && $operation != '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('DashboardCalificacion')
              ->where('Vertical', '=', $vertical)
              ->where('Operacion', '=', $operation)
              ->get();
      }
      */
      return json_encode($data_two);
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
        //
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

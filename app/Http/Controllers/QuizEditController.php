<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

use DateTime;

class QuizEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $sql = DB::table('DashboardCalificacion')->select('id', 'Nombre_hotel')->groupBy('id')->orderBy('Nombre_hotel', 'asc')->get();
      return view('quiz.quizedit', compact('sql'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Request $request)
    {
      $xa = $request->select_one;
      $xb = $request->calendar_fecha;
      //01-2017;

      $array = explode("-", $xb);
      $extraer_mes = $array[0];
      $extraer_year = $array[1];

      $dateObj   = DateTime::createFromFormat('!m', $extraer_mes);
      $monthName = $dateObj->format('F');

      $sql = DB::table('calificaciones')
                       ->select('Mes')
                       ->where('hotels_id', '=', $xa)
                       ->where('Mes', '=', $monthName)
                       ->where('Year1', '=', $extraer_year)
                       ->get();

      $contador =count($sql);
      if ( $contador != 0) { return '1'; }
      else { return '0'; }
    }
    public function editar(Request $request)
    {
      $xa = $request->var_xa;
      $xb = $request->var_xb;

      $array = explode("-", $xb);
      $extraer_mes = $array[0];
      $extraer_year = $array[1];

      $dateObj   = DateTime::createFromFormat('!m', $extraer_mes);
      $monthName = $dateObj->format('F');

      $sql = DB::table('calificaciones')
                       ->where('hotels_id', '=', $xa)
                       ->where('Mes', '=', $monthName)
                       ->where('Year1', '=', $extraer_year)
                       ->get();
      return json_encode($sql);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $var_hotel_t1 = $request->var_xa;
          $var_date_t1 = $request->var_xb;
        $var_select_1 = $request->var_xc;
        $var_select_2 = $request->var_xd;
        $var_coment_a = $request->var_xe;
        $var_coment_b = $request->var_xf;
        $var_coment_c = $request->var_xg;
        $var_nps='';
        $array = explode("-", $var_date_t1);
        $extraer_mes = $array[0];
        $extraer_year = $array[1];
        $dateObj   = DateTime::createFromFormat('!m', $extraer_mes);
        $monthName = $dateObj->format('F');
        if ($var_select_2 >= 9) { $var_nps = "PR"; }
        if ($var_select_2 >= 7) { $var_nps = "PS"; }
        if ($var_select_2 <= 6) { $var_nps = "D";  }
        $sql = DB::table('calificaciones')
          ->where('hotels_id', $var_hotel_t1)
          ->where('Mes', $monthName)
          ->where('Year1', $extraer_year)
          ->update([
            'Calificacion' => $var_select_2,
            'Probabilidad' => $var_nps,
            'ProbabilidadNumero' => $var_select_1,
            'Comentario1' => $var_coment_a,
            'Comentario2' => $var_coment_b,
            'Comentario3' => $var_coment_c]);
          if ($sql == true) { return 1;  }
          else { return 0; }
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

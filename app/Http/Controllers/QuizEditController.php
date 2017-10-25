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
      $sql = DB::table('DashboardCalificacion')->select('id', 'Nombre_hotel')->groupBy('id')->get();
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
      $xa = $request->select_one;
      $xb = $request->calendar_fecha;

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

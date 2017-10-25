<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class QuizCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $selectYear  = DB::table('DashboardComentarios')->select('Year1')->groupBy('Year1')->orderBy('Year1', 'asc')->get();
      $selectHotel = DB::table('DashboardComentarios')->select('hotels_id', 'Nombre_hotel')->groupBy('hotels_id')->orderBy('hotels_id', 'asc')->get();
      $selectUser  = DB::table('DashboardComentarios')->select('user_reportes_id','nombrecomp')->groupBy('user_reportes_id')->orderBy('user_reportes_id', 'asc')->get();

      return view('quiz.quizcomments', compact('selectYear', 'selectHotel','selectUser') );
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
      $year= $request->searchyear;
      $hotel= $request->searchhotel;
      $user= $request->searchuser;
      if ($year == '' && $hotel == '' && $user == '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->get();
      }
      if ($year != '' && $hotel != '' && $user != '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('Year1', '=', $year)
              ->where('hotels_id', '=', $hotel)
              ->where('user_reportes_id', '=', $user)
              ->get();
      }

      if ($year != '' && $hotel == '' && $user == '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('Year1', '=', $year)
              ->get();
      }
      if ($year == '' && $hotel != '' && $user == '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('hotels_id', '=', $hotel)
              ->get();
      }
      if ($year == '' && $hotel == '' && $user != '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('user_reportes_id', '=', $user)
              ->get();
      }

      if ($year != '' && $hotel != '' && $user == '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('Year1', '=', $year)
              ->where('hotels_id', '=', $hotel)
              ->get();
      }
      if ($year != '' && $hotel == '' && $user != '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('Year1', '=', $year)
              ->where('user_reportes_id', '=', $user)
              ->get();
      }
      if ($year == '' && $hotel != '' && $user != '') {
        $sql= DB::table('DashboardComentarios')
              ->select('Mes','Year1', 'Comentario1', 'Comentario2', 'Comentario3','Aux','Fecha','Nombre_hotel','nombrecomp')
              ->where('hotels_id', '=', $hotel)
              ->where('user_reportes_id', '=', $user)
              ->get();
      }

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

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
      $mes = '12';
      $now= date("Y");

      //TODOS no vacio
      if(!empty($year) && !empty($hotel) && !empty($user)) { $sql = DB::select('CALL GetComentarioAnioVenueIT(?,?,?)', array($year,$hotel,$user));}//sio
      //no hay filtro del año actual
      if(empty($year) && empty($hotel) && empty($user)) { $sql = DB::select('CALL GetComentarioAnio(?)', array($now)); }//sio
      //año, hotel, user vacio
      if(!empty($year) && empty($hotel) && empty($user)) { $sql = DB::select('CALL GetComentarioAnio(?)', array($year)); }//sio
      if(empty($year) && !empty($hotel) && empty($user)) { $sql = DB::select('CALL GetComentarioVenue(?)', array($hotel)); }//sio
      if(empty($year) && empty($hotel) && !empty($user)) { $sql = DB::select('CALL GetComentarioIT(?)', array($user)); }//sio---------------------

      if(!empty($year) && !empty($hotel) && empty($user)) { $sql = DB::select('CALL GetComentarioAnioHotel(?,?)', array($year,$hotel)); }//sio
      if(!empty($year) && empty($hotel) && !empty($user)) { $sql = DB::select('CALL GetComentarioAnioIT(?,?)', array($year,$user)); }//sio

      if(empty($year) && !empty($hotel) && !empty($user)) { $sql = DB::select('CALL GetComentarioVenueIT(?,?)', array($hotel,$user)); }//sio

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

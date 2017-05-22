<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

class AssignConciergeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $selectDataUser = DB::table('ListarUserReportes')->orderBy('id', 'asc')->get();
      return view('assign.assign', compact('selectDataUser'));
      //return view('assign.assign');
    }
    public function recargar(Request $request){
      $id= $request->sector;
      $sql= DB::table('HotelUserReport')->where('IDHotels', '=', $id)->get();
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
     public function show (Request $request)
     {
         $resultado= DB::table('HotelUserReport')->select(
           'Nombre_hotel',
           'IDHotels',
           'IDUsuario',
           'Encargado'
          )->orderBy('IDHotels', 'asc')->get();
         return json_encode($resultado);
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
    public function update(Request $request)
    {
      $value='1';
      $edita_idhotel= $request->hotel;
      $edita_idconci= $request->concierge;

      $sql = DB::table('hotels')->where('id', '=', $edita_idhotel)
      ->update(['user_reportes_id' => $edita_idconci]);

      return $value;
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

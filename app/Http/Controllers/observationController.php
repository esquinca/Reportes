<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class observationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ID = Auth::user()->id;
      $correo = Auth::user()->email;
      $priv = Auth::user()->Privilegio;

      if($priv == 'Cliente'){
          $exitecliente= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
          if ($exitecliente != 0) {
              /*SI existe*/
              $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
              return view('observation.observation', compact('selectDatahotel'));
          }
      }
      if($priv == 'IT'){
          $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
          if ($exiteClienteVer != 0) {
              /*SI existe este en la lista de clientes*/
              $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
              return view('observation.observation', compact('selectDatahotel'));
          }
          else {
              /*SI existe no existe en la lista de clientes*/
              $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
              return view('observation.observation', compact('selectDatahotel'));
          }
      }
      if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
          $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
          return view('observation.observation', compact('selectDatahotel'));
      }
    }
    public function verfObMes(Request $request)
    {
      $id_hotel = $request->ident;
      $fechar = $request->fechae;

      $sql = DB::table('observacionesv')->where('Mes', '=', $fechar)->where('hotels_id', '=', $id_hotel)->count();
      $capt_r_sql = 0;
      //$capt_r_sql= DB::table('HotelesRegistradosZD')->where('Fecha', '=', '$fechar')->where('hotels_id', '=', '$id_hot')->get(); //Retorna un array stdClass Object
      //$count_reg= count($capt_r_sql); //Cuento el tamaño del array anterior
      if($sql == 0){
        $capt_r_sql = 0;
      }
      if($sql != 0){
        $capt_r_sql = 1;
      }
      return $capt_r_sql;

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

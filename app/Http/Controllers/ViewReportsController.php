<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class ViewReportsController extends Controller
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
              return view('viewreport.viewreports', compact('selectDatahotel'));
          }
      }
      if($priv == 'IT'){
          $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
          if ($exiteClienteVer != 0) {
              /*SI existe este en la lista de clientes*/
              $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
              return view('viewreport.viewreports', compact('selectDatahotel'));
          }
          else {
              /*SI existe no existe en la lista de clientes*/
              $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
              return view('viewreport.viewreports', compact('selectDatahotel'));
          }
      }
      if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
          $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
          return view('viewreport.viewreports', compact('selectDatahotel'));
      }
    }

    public function typerep(Request $request)
    {
      $value= $request->numero;
      $selectnivel= DB::table('NivelReporte')->select('id','Nivel')->where('hotels_id', '=', $value)->get();
      return json_encode($selectnivel);

    }
    public function tableShowComp (Request $request)
    {
        $value= $request->numero;
        $resultado= DB::table('vComparativo')->orderBy('Mes', 'desc')->where('hotels_id', '=', $value)->get();
        return json_encode($resultado);
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
      $numero_hotel= $request->nhotel;
      $type= $request->tipo;
      $resultado= DB::table('Fechaprimeracapturareporte')->select('PRIMER_MES')->where('id', '=', $numero_hotel)->where('IDNIVEL', '=', $type)->get();
      return json_encode($resultado);
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

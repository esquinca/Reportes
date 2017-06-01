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
      $resultado= DB::table('NivelesReportePrueba')->select('MIN')->where('IDHOTEL', '=', $numero_hotel)->where('IDREPORTE', '=', $type)->value('MIN');

      //$resultado = json_encode($resultado);

      return $resultado;
    }
    public function contenido(Request $request)
    {
      $numero_hotel= $request->number;
      $type= $request->type;
      $date= $request->mes;
      $resultados = DB::table('UsuariosGBMaxMin')->select('AP','MaxGBv','MinGBv','TOTALUSER','MaxClientes','RogueDevice')
                                ->where('ID', '=' , $numero_hotel)
                                ->where('MesGB', '=' , $date)
                                ->get();
      return json_encode($resultados);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_graf_one(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados = DB::table('cant_client_usuario')->select('NumClientes','Dia','Fecha')
                    ->where('id', '=' , $numero_hotel)
                    ->where('Fecha', '=' , $date)
                    ->get();
      return json_encode($resultados);
    }
    public function show_graf_two(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados = DB::table('SSIDCliente')->select('id', 'NombreWLAN',  DB::raw('SUM(ClientesWLAN) as ClientesWLAN'), 'Fecha' )
      ->where('Fecha', '=', $date)
      ->where('id', '=', $numero_hotel)
      ->groupBy('NombreWLAN')
      ->get();
      return json_encode($resultados);
    }
    public function show_graf_three (Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados = DB::table('TopSSIDWLAN')->select('NombreWLAN',DB::raw('SUM(ClientesWLAN) as ClientesWLAN') )
                    ->where('id', '=' , $numero_hotel)
                    ->where('Fecha', '=' , $date)
                    ->groupBy('NombreWLAN')
                    ->orderBy('ClientesWLAN', 'desc')
                    ->limit(5)
                    ->get();
      return json_encode($resultados);
    }
    public function show_graf_four(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados = DB::table('ConsultaMostAP')->select('id', 'Descripcion', 'MAC',  DB::raw('SUM(NumClientes) as NumClientes'), 'nfecha' )
                    ->where('nfecha', '=', $date)
                    ->where('id', '=', $numero_hotel)
                    ->groupBy('MAC')
                    ->orderBy('NumClientes', 'desc')
                    ->limit(5)
                    ->get();
      return json_encode($resultados);
    }

    public function show_ap_det(Request $request){
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados = DB::table('ConsultaMostAP')->select('id', 'Descripcion', 'MAC',  DB::raw('SUM(NumClientes) as NumClientes'), 'nfecha' )
                    ->where('nfecha', '=', $date)
                    ->where('id', '=', $numero_hotel)
                    ->groupBy('MAC')
                    ->orderBy('NumClientes', 'desc')
                    ->limit(5)
                    ->get();
      return json_encode($resultados);
    }

    public function info_cuad(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados= DB::table('UsuariosGBMaxMin')->select('AP','MaxGBv','MinGBv','MaxClientes','AVGUSER', 'RogueDevice')
                  ->where('ID', '=' , $numero_hotel)
                  ->where('MesUsuario', '=' , 'Mayo 2017')
                  ->get();
     return json_encode($resultados);
    }

    public function info_hotel(Request $request)
    {
      $numero_hotel= $request->number;
      $resultados= DB::table('hotels')->select('Nombre_hotel', 'dirlogo1')
                  ->where('id', '=' , $numero_hotel)
                  ->get();
      return json_encode($resultados);
    }
    public function info_observation(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $resultados= DB::table('Observaciones')->select('Descripcion')
                  ->where('hotels_id', '=' , $numero_hotel)
                  ->where('Mes', '=', $date)
                  ->value('Descripcion');

      return $resultados;
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

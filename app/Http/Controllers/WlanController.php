<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class WlanController extends Controller
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
                return view('wlan.wlan', compact('selectDatahotel'));
            }
        }
        if($priv == 'IT'){
            $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            if ($exiteClienteVer != 0) {
                /*SI existe este en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
                return view('wlan.wlan', compact('selectDatahotel'));
            }
            else {
                /*SI existe no existe en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
                return view('wlan.wlan', compact('selectDatahotel'));
            }
        }
        if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
            $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
            return view('wlan.wlan', compact('selectDatahotel'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function exitent(Request $request)
     {
         $id_hotel= $request->hotel;
         $nam_wlan= $request->wlan;
         $value = 0;
         $exite = DB::table('WLAN')
                ->where('NombreWLAN', '=', $nam_wlan)
                ->where('hotels_id', '=', $id_hotel)
                ->count();
         if ($exite == 0) {
           $value = 0;
           return $value;
         }
         else {
           $value = 1;
           return $value;
         }
     }
     public function create(Request $request)
     {
        $id_hotel= $request->hotel;
        $nam_wlan= $request->wlan;

        $id = DB::table('WLAN')->insertGetId(
          ['NombreWLAN' => $nam_wlan, 'Estado' => '1', 'hotels_id' => $id_hotel]
        );

        $value='1';
        return $value;

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
    public function show(Request $request)
    {
      $id_hotel= $request->hotel;
      $resultado= DB::table('WLAN')->where('hotels_id', '=', $id_hotel)->orderBy('id', 'asc')->get();
      return json_encode($resultado);
    }
    public function showtwo(Request $request)
    {
      $id_hotel= $request->stat;
      $resultado= DB::table('WLAN')->select('id','Estado')->where('id', '=', $id_hotel)->orderBy('id', 'asc')->get();
      return json_encode($resultado);
    }
    public function showthree(Request $request)
    {
      $id_act= $request->hotel;
      $resultado= DB::table('WLAN')->where('id', '=', $id_act)->orderBy('id', 'asc')->get();
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
    public function updatestatus(Request $request)
    {
      $value='1';
      $edita_id= $request->hotel;
      $editar_st=$request->estadoup;
      $sql = DB::table('WLAN')->where('id', '=', $edita_id)
      ->update(['Estado' => $editar_st]);
      return $value;
    }
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

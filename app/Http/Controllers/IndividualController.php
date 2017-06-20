<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;

class IndividualController extends Controller
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
                return view('captureind.individual', compact('selectDatahotel'));
            }
        }
        if($priv == 'IT'){
            $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            if ($exiteClienteVer != 0) {
                /*SI existe este en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
                return view('captureind.individual', compact('selectDatahotel'));
            }
            else {
                /*SI existe no existe en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
                return view('captureind.individual', compact('selectDatahotel'));
            }
        }
        if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
            $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
            return view('captureind.individual', compact('selectDatahotel'));
        }
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
    public function storegb(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');
        $giga = $request->input('vgb');

        return $giga;
    }

    public function storeuser(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');
        $users = $request->input('vur');

        return $giga;
    }
    
    public function storeaps(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');

        $mac1 = $request->input('af1_1');
        $modelo1 = $request->input('af1_2');
        $cliente1 = $request->input('af1_3');
        $mac2 = $request->input('af2_1');
        $modelo2 = $request->input('af2_2');
        $cliente2 = $request->input('af2_3');
        $mac3 = $request->input('af3_1');
        $modelo3 = $request->input('af3_2');
        $cliente3 = $request->input('af3_3');
        $mac4 = $request->input('af4_1');
        $modelo4 = $request->input('af4_2');
        $cliente4 = $request->input('af4_3');
        $mac5 = $request->input('af5_1');
        $modelo5 = $request->input('af5_2');
        $cliente5 = $request->input('af5_3');


        return $mac1;
    }

    public function storewlan(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');

        $nombre1 = $request->input('bf1_1');
        $clientew1 = $request->input('bf1_2');

        $nombre2 = $request->input('bf2_1');
        $clientew2 = $request->input('bf2_2');

        $nombre3 = $request->input('bf3_1');
        $clientew3 = $request->input('bf3_2');

        $nombre4 = $request->input('bf4_1');
        $clientew4 = $request->input('bf4_2');

        $nombre5 = $request->input('bf5_1');
        $clientew5 = $request->input('bf5_2');

        return $nombre1;
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

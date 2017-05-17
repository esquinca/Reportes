<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class GenerateController extends Controller
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
                return view('generate.generate', compact('selectDatahotel'));
            }
        }
        if($priv == 'IT'){
            $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            if ($exiteClienteVer != 0) {
                /*SI existe este en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
                return view('generate.generate', compact('selectDatahotel'));
            }
            else {
                /*SI existe no existe en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
                return view('generate.generate', compact('selectDatahotel'));
            }
        }
        if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
            $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
            return view('generate.generate', compact('selectDatahotel'));
        }
    }

    public function rdata(Request $request)
    {
        $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $id_hotel = $request->get('idhotel');
        $fechaInput = $request->input('fecha_nueva');

        $numMes = date ("m", strtotime($fechaInput));

        $year = date ("Y", strtotime($fechaInput));

        $mesyear = $meses[$numMes-1].' '. $year;
        



        // $user = $request->input('userxday');
        // $giga = $request->input('gigxday');


        // $mac1 = $request->input('mac1');
        // $modelo1 = $request->input('modelo1');
        // $cliente1 = $request->input('cliente1');
        // $mac2 = $request->input('mac2');
        // $modelo2 = $request->input('modelo2');
        // $cliente2 = $request->input('cliente2');
        // $mac3 = $request->input('mac3');
        // $modelo3 = $request->input('modelo3');
        // $cliente3 = $request->input('cliente3');
        // $mac4 = $request->input('mac4');
        // $modelo4 = $request->input('modelo4');
        // $cliente4 = $request->input('cliente4');
        // $mac5 = $request->input('mac5');
        // $modelo5 = $request->input('modelo5');
        // $cliente5 = $request->input('cliente5');

        // $nombre1 = $request->input('nombre1');
        // $clientew1 = $request->input('clientew1');
        // $nombre2 = $request->input('nombre2');
        // $clientew2 = $request->input('clientew2');
        // $nombre3 = $request->input('nombre3');
        // $clientew3 = $request->input('clientew3');
        // $nombre4 = $request->input('nombre4');
        // $clientew4 = $request->input('clientew4');
        // $nombre5 = $request->input('nombre5');
        // $clientew5 = $request->input('clientew5');

        // DB::beginTransaction();
        //     DB::table('UsuariosXDia')->insert([
        //         ['NumClientes', 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => ]
        //     ]);
        // DB::commit();

        return $fechaInput;
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

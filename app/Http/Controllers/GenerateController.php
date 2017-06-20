<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;

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
        $userxdia = $request->input('userxday');
        $giga = $request->input('gigxday');

        $fechaInput = $request->input('fecha_nueva');
        $numMes = date ("m", strtotime($fechaInput));
        $year = date ("Y", strtotime($fechaInput));

        $mesyear = $meses[$numMes-1].' '. $year;
        $giga = ((($giga * 1024) * 1024) * 1024);

        DB::beginTransaction();

        DB::table('UsuariosXDia')->insert([
            ['NumClientes' => $userxdia, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
        ]);

        DB::table('GBXDia')->insert([
            ['CantidadBytes' => $giga, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
        ]);

        $mac1 = $request->input('mac1');
        $modelo1 = $request->input('modelo1');
        $cliente1 = $request->input('cliente1');
        $mac2 = $request->input('mac2');
        $modelo2 = $request->input('modelo2');
        $cliente2 = $request->input('cliente2');
        $mac3 = $request->input('mac3');
        $modelo3 = $request->input('modelo3');
        $cliente3 = $request->input('cliente3');
        $mac4 = $request->input('mac4');
        $modelo4 = $request->input('modelo4');
        $cliente4 = $request->input('cliente4');
        $mac5 = $request->input('mac5');
        $modelo5 = $request->input('modelo5');
        $cliente5 = $request->input('cliente5');

        DB::table('MostAP')->insert([
            ['Fecha' => $fechaInput, 'MAC' => $mac1, 'NumClientes' => $cliente1, 'Modelo' => $modelo1, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fechaInput, 'MAC' => $mac2, 'NumClientes' => $cliente2, 'Modelo' => $modelo2, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fechaInput, 'MAC' => $mac3, 'NumClientes' => $cliente3, 'Modelo' => $modelo3, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fechaInput, 'MAC' => $mac4, 'NumClientes' => $cliente4, 'Modelo' => $modelo4, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fechaInput, 'MAC' => $mac5, 'NumClientes' => $cliente5, 'Modelo' => $modelo5, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
        ]);

        $nombre1 = $request->input('nombrew1');
        $clientew1 = $request->input('clientew1');

        $nombre2 = $request->input('nombrew2');
        $clientew2 = $request->input('clientew2');

        $nombre3 = $request->input('nombrew3');
        $clientew3 = $request->input('clientew3');

        $nombre4 = $request->input('nombrew4');
        $clientew4 = $request->input('clientew4');

        $nombre5 = $request->input('nombrew5');
        $clientew5 = $request->input('clientew5');

        if ($request->input('nombrew2') == '' && $request->input('clientew2') == '') {
            DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);
        }elseif ($request->input('nombrew3') == '' && $request->input('clientew3') == '') {
            DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);            
        }elseif ($request->input('nombrew4') == '' && $request->input('clientew4') == '') {
            DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);           
        }elseif ($request->input('nombrew5') == '' && $request->input('clientew5') == '') {
            DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre4, 'ClientesWLAN' => $clientew4, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);            
        }else{
            DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre4, 'ClientesWLAN' => $clientew4, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre5, 'ClientesWLAN' => $clientew5, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);      
        }

        DB::commit();

        return back();
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
    public function vdata(Request $request)
    {
      $id_hotel = $request->ident;
      $fechar = $request->fechae;

      $sql = DB::table('HotelesRegistradosZD')->where('Fecha', '=', $fechar)->where('hotels_id', '=', $id_hotel)->count();
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
}

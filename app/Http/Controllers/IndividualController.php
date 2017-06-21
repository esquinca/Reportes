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
     public function vdata($id, $date, $tabla )
     {
       $sql = DB::table($tabla)->where('Fecha', '=', $date)->where('hotels_id', '=', $id)->count();
       $capt_r_sql = 0;

       if($sql == 0){
         //no hay registros
         $capt_r_sql = 0;
       }
       if($sql != 0){
         //si hay
         $capt_r_sql = 1;
       }
       return $capt_r_sql;
     }
      public function storegb(Request $request)
      {
        $id_hotel = $request->get('ident');
        $fechaInput = $request->input('date');

        $validacionRegistro= $this -> vdata($id_hotel, $fechaInput, 'GBXDia');

        if($validacionRegistro == 1){
          return $validacionRegistro;//si hay registro mando 1 error esta registrado ese dia
        }
        if($validacionRegistro == 0){

          $giga = $request->input('vgb');

          $bytes = ((($giga * 1024) * 1024) * 1024);

          $mesyear = $this->returnDate($fechaInput);

          $result = DB::table('GBXDia')->insert([
            ['CantidadBytes' => $bytes, 'Fecha' => $fechaInput, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
          ]);

          return $validacionRegistro;//no hay registro mando 0
        }
        /* $resultS = (string)$result; return $resultS; */
      }

    public function storeuser(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');

        $validacionRegistro= $this -> vdata($id_hotel, $fecha, 'UsuariosXDia');

        if($validacionRegistro == 1){
          return $validacionRegistro;//si hay registro mando 1 error esta registrado ese dia
        }
        if($validacionRegistro == 0){

          $userxdia = $request->input('vur');

          $mesyear = $this->returnDate($fecha);

          $result = DB::table('UsuariosXDia')->insert([
            ['NumClientes' => $userxdia, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
          ]);
          return $validacionRegistro;//no hay registro mando 0
        }

        /* $resultS = (string)$result; return $resultS; */
    }

    public function storeaps(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');

        $validacionRegistro= $this -> vdata($id_hotel, $fecha, 'MostAP');

        if($validacionRegistro == 1){
          return $validacionRegistro;//si hay registro mando 1 error esta registrado ese dia
        }
        if($validacionRegistro == 0){
          $mesyear = $this->returnDate($fecha);

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

          $result = DB::table('MostAP')->insert([
            ['Fecha' => $fecha, 'MAC' => $mac1, 'NumClientes' => $cliente1, 'Modelo' => $modelo1, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fecha, 'MAC' => $mac2, 'NumClientes' => $cliente2, 'Modelo' => $modelo2, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fecha, 'MAC' => $mac3, 'NumClientes' => $cliente3, 'Modelo' => $modelo3, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fecha, 'MAC' => $mac4, 'NumClientes' => $cliente4, 'Modelo' => $modelo4, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
            ['Fecha' => $fecha, 'MAC' => $mac5, 'NumClientes' => $cliente5, 'Modelo' => $modelo5, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
          ]);

          return $validacionRegistro;//no hay registro mando 0
        }
        /*  $resultS = (string)$result;  return $resultS;  */
    }

    public function storewlan(Request $request)
    {
        $id_hotel = $request->get('ident');
        $fecha = $request->input('date');
        $validacionRegistro= $this -> vdata($id_hotel, $fecha, 'WLAN');

        if($validacionRegistro == 1){
          return $validacionRegistro;//si hay registro mando 1 error esta registrado ese dia
        }
        if($validacionRegistro == 0){
          return $validacionRegistro;//no hay registro mando 0
        }
        /*
        $mesyear = $this->returnDate($fecha);

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

        if ($request->input('nombrew2') == '' && $request->input('clientew2') == '') {
            $result = DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);
            $resultS = (string)$result;
            return $resultS;
        }elseif ($request->input('nombrew3') == '' && $request->input('clientew3') == '') {
            $result = DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);
            $resultS = (string)$result;
            return $resultS;
        }elseif ($request->input('nombrew4') == '' && $request->input('clientew4') == '') {
            $result = DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);
            $resultS = (string)$result;
            return $resultS;
        }elseif ($request->input('nombrew5') == '' && $request->input('clientew5') == '') {
            $result = DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre4, 'ClientesWLAN' => $clientew4, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);
            $resultS = (string)$result;
            return $resultS;
        }else{
            $result = DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre4, 'ClientesWLAN' => $clientew4, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel],
                ['NombreWLAN' => $nombre5, 'ClientesWLAN' => $clientew5, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);
            $resultS = (string)$result;
            return $resultS;
        }
        return $result = 0;
        */

    }

    public function returnDate($date)
    {
        $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $numMes = date ("m", strtotime($date));
        $year = date ("Y", strtotime($date));

        $mesyear = $meses[$numMes-1].' '. $year;

        return $mesyear;
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use App\Http\Requests;

use DB;

use Auth;

use Excel;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('importardoc.import');
    }

    public function subir(Request $request)
    {
      $archivo = $request->file('documento');
      Excel::selectSheetsByIndex(0)->load($archivo, function($hoja){
        $hoja->each(function($fila){
          $hotel= $fila->nombre;
          $selectid= DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');
          echo $selectid;
        });
      });
    }
    public function returnDate($date)
    {
        $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $numMes = date ("m", strtotime($date));
        $year = date ("Y", strtotime($date));

        $mesyear = $meses[$numMes-1].' '. $year;

        return $mesyear;
    }
    public function returnDateTwo($date)
    {
        $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $numMes = date ("F", strtotime($date));
        $year = date ("Y", strtotime($date));

        $mesyear = $numMes.' '. $year;

        return $mesyear;
    }
    public function subir2(Request $request)
    {
      $archivo = $request->file('documento');
      DB::beginTransaction();
      Excel::selectSheetsByIndex(0)->load($archivo, function($hoja){
        $hoja->each(function($fila){
          $hotel= $fila->nombre_hotel;

          $fechaSin= $fila->fecha;
          $fechaC =  explode(' ', $fechaSin);
          $fechaSalida= $fechaC[0];

          $nclient= $fila->no_usuario;

          $gb= $fila->cantidad_gb_24hrs;
          $bytes = ((($gb * 1024) * 1024) * 1024);

          $mesyear = $this->returnDate($fechaSalida);
          $auxone = $this->returnDateTwo($fechaSalida);
          $auxiliar = $hotel.' '.$auxone;

          $selectid= DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');

          // echo $bytes;
          // echo "<br>";
          // echo $fechaSalida;
          // echo "<br>";
          // echo $mesyear = $this->returnDate($fechaSalida);
          // echo "<br>";
          // echo $selectid;
          // echo "<br>";

          $resultGB = DB::table('GBXDia')->insert([
            ['CantidadBytes' => $bytes, 'Fecha' => $fechaSalida, 'Mes' => $mesyear, 'hotels_id' => $selectid, 'Aux'=> $auxiliar]
          ]);

          $resultUS = DB::table('UsuariosXDia')->insert([
            ['NumClientes' => $nclient, 'Fecha' => $fechaSalida, 'Mes' => $mesyear, 'hotels_id' => $selectid, 'Aux'=> $auxiliar]
          ]);

        });

      });

      Excel::selectSheetsByIndex(1)->load($archivo, function($hoja){
        $hoja->each(function($fila){
          $hotel= $fila->nombre_hotel;
          $aps_mac= $fila->ap_mac;
          $aps_nclient= $fila->ap_noclientes;
          $aps_model= $fila->ap_modelo;

          $aps_fecha= $fila->ap_fecha;
          $fecha_apc =  explode(' ', $aps_fecha);
          $fechaSalidaAP= $fecha_apc[0];

          $mesyear = $this->returnDate($fechaSalidaAP);

          $selectid= DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');

          $result_ap = DB::table('MostAP')->insert([
            ['Fecha' => $fechaSalidaAP, 'MAC' => $aps_mac, 'NumClientes' => $aps_nclient, 'Modelo' => $aps_model, 'Mes' => $mesyear, 'hotels_id' => $selectid]
          ]);

          // echo "Informacion de AP<br>";
          // $selectid= DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');
          // echo $selectid;
          // echo "<br>";
          // echo $fechaSalidaAP;
          // echo "<br>";
          // echo $aps_mac;
          // echo "<br>";
          // echo $aps_nclient;
          // echo "<br>";
          // echo $aps_model;
          // echo "<br>";
          // echo $mesyear;
        });
      });

      Excel::selectSheetsByIndex(2)->load($archivo, function($hoja){
        $hoja->each(function($fila){
          $hotel= $fila->nombre_hotel;
          $mac= $fila->rogue_mac;
          $canal= $fila->rogue_canal;
          $ssid= $fila->rogue_ssid;
          $fecha= $fila->rogue_mes;

          // $result_rg = DB::table('RogueDevices')->insertGetId([
          //   'MACRogue' => $mac,
          //   'ChannelRogue' => $canal,
          //   'TypeRogue' => "1",
          //   'SSIDRogue' => $ssid,
          //   'Mes' => $fecha,
          //   'hotels_id' => $hotel]);

          // echo "Informacion de rogue<br>";
          // $selectid= DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');
          // echo $selectid;
          // echo "<br>";
          // echo $mac;
          // echo "<br>";
          // echo $canal;
          // echo "<br>";
          // echo $ssid;
          // echo "<br>";
          // echo $fecha;
          // echo "<br>";
        });
      });

      Excel::selectSheetsByIndex(3)->load($archivo, function($hoja){
        $hoja->each(function($fila){
          $hotel= $fila->nombre_hotel;
          $nombre= $fila->wlan_nombre;
          $nclient= $fila->wlan_noclientes;

          $fecha= $fila->wlan_fecha;
          $fecha_wlan =  explode(' ', $fecha);
          $fechaSalidawl= $fecha_wlan[0];

          $mesyear = $this->returnDate($fechaSalidawl);

          $selectid= DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');

          $sql = DB::table('WLAN')->insertGetId([
            'NombreWLAN' => $nombre,
            'ClientesWLAN' => $nclient,
            'Fecha' => $fechaSalidawl,
            'Mes' => $mesyear,
            'hotels_id' => $selectid]);

          // echo "Informacion de wlan<br>";
          // echo $nombre;
          // echo "<br>";
          // echo $nclient;
          // echo "<br>";
          // echo $fechaSalidawl;
          // echo "<br>";
          // echo $mesyear;
          // echo "<br>";
          // echo $selectid;
          // echo "<br>";
        });
      });
      DB::commit();
      notificationMsg('success', 'Registrados con exito. !!');
      return Redirect::back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      Excel::create( 'File Name', function($excel) {

      $excel->sheet('Sheet Name', function($sheet) {

			$head = array(
				'Title 1',
				'Title 2',
				'Title 3',
				'Title 4'
			);

			$data = array($head);
			$sheet->fromArray($data, null, 'A1', false, false);
    });


      })->export('xlsx');
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

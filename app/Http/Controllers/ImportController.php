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
          // if (empty($response->tickets[$i]->via->channel)) {
          //     $channel = "";
          // }else{
          //     $channel = $response->tickets[$i]->via->channel;
          // }

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

          // if (empty($selectid)) {
          //   $resultGB = DB::table('GBXDia')->insert([
          //     ['CantidadBytes' => $bytes, 'Fecha' => $fechaSalida, 'Mes' => $mesyear, 'hotels_id' => $selectid, 'Aux'=> $auxiliar]
          //   ]);

          //   $resultUS = DB::table('UsuariosXDia')->insert([
          //     ['NumClientes' => $nclient, 'Fecha' => $fechaSalida, 'Mes' => $mesyear, 'hotels_id' => $selectid, 'Aux'=> $auxiliar]
          //   ]);
          // }else{
          //   return "0";
          // }


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
      //notificationMsg('success', 'Registrados con exito. !!');

      return Redirect::back();
    }

    public function insertExcel(Request $request)
    {
      $archivo = $request->file('documento');
      $gigaValues = [];
      $nclientValues = [];
      $MostAPValues = [];
      $RogueValues = [];
      $WLANValues = [];
      // Probablemente agregar esta bandera cada vez que se hace un registro y agregar transaction para...
      // poder hacer rollback a las inserciones por si falla alguna.
      $flag = FALSE;
      $flagRogue = FALSE;
      //
      Excel::load($archivo, function($hoja){
        $results = $hoja->get();

        $hoja1 = $results[0]->all();
        $hoja2 = $results[1]->all();
        $hoja3 = $results[2]->all();
        $hoja4 = $results[3]->all();


        if (empty($hoja1[0]->nombre_hotel)) {
            notificationMsg('error','Esta mal el nombre del hotel, favor de revisar');
            return Redirect::back();
        }else{
            $hotel = trim($hoja1[0]->nombre_hotel);
            $mesrogue = trim($hoja1[0]->fecha);
            try {
              $selectid = DB::table('listarhoteles')->select('id')->where('Nombre_hotel', '=', $hotel)->value('id');
              $selectHotel = DB::table('hotels')->select('Nombre_hotel')->where('id', '=', $selectid)->value('Nombre_hotel');
            } catch (\Exception $e) {
              notificationMsg('error','No se encontro el nombre del hotel en la base, favor de revisar');
              return Redirect::back();
            }
        }
        $rowNum1 = $this->countArray($hoja1);

        //---Obtencion de datos HOJA Usuarios y Gigas.
        for ($i=0; $i < $rowNum1; $i++) {
          $fechaSin= trim($hoja1[$i]->fecha);
          $fechaSalida = date('Y-m-d', strtotime($fechaSin));

          $nclient= trim($hoja1[$i]->no_usuario);

          $gb= $hoja1[$i]->cantidad_gb_24hrs;
          $bytes = ((($gb * 1024) * 1024) * 1024);
          $bytes = trim($bytes);

          $mesyear = $this->returnDate($fechaSalida);
          $auxone = $this->returnDateTwo($fechaSalida);
          $auxiliar = $selectHotel.' '.$auxone;

          if (empty($nclientV) && empty($gb) && empty($fechaSin)) {
            continue;
          }else{
            $valuesG = [
              'CantidadBytes' => $bytes,
              'Fecha' => $fechaSalida,
              'Mes' => $mesyear,
              'hotels_id' => $selectid,
              'Aux' => $auxiliar,
            ];
            $valuesnC = [
              'NumClientes' => $nclient,
              'Fecha' => $fechaSalida,
              'Mes' => $mesyear,
              'hotels_id' => $selectid,
              'Aux' => $auxiliar,
            ];
            $gigaValues[] = $valuesG;
            $nclientValues[] = $valuesnC;
          }
        }
        $resultGB = DB::table('GBXDia')->insert($gigaValues);
        $resultNC = DB::table('UsuariosXDia')->insert($nclientValues);

        $rowNum2 = $this->countArray($hoja2);

        //---Obtencion de datos HOJA MostAP.
        for ($j=0; $j < $rowNum2; $j++) {
          $aps_mac= trim($hoja2[$j]->ap_mac);
          $aps_nclient= trim($hoja2[$j]->ap_noclientes);
          $aps_model= trim($hoja2[$j]->ap_modelo);

          $aps_fecha= trim($hoja2[$j]->ap_fecha);
          $fechaSalidaAP = date('Y-m-d', strtotime($aps_fecha));

          $mesyearAP = $this->returnDate($fechaSalidaAP);

          if (empty($aps_mac) && empty($aps_model) && empty($nclientValues) && empty($aps_fecha)) {
            continue;
          }else{
            $valuesMost = [
              'Fecha' => $fechaSalidaAP,
              'MAC' => $aps_mac,
              'NumClientes' => $aps_nclient,
              'Modelo' => $aps_model,
              'Mes' => $mesyearAP,
              'hotels_id' => $selectid
            ];
            $MostAPValues[] = $valuesMost;
          }
        }
        $result_ap = DB::table('MostAP')->insert($MostAPValues);

        $rowNum3 = $this->countArray($hoja3);

        //---Obtencion de datos HOJA Rogue Devices.
        for ($k=0; $k < $rowNum3; $k++) {
          $rgmac= trim($hoja3[$k]->rogue_mac);
          $rgcanal= trim($hoja3[$k]->rogue_canal);
          $rgssid= trim($hoja3[$k]->rogue_ssid);
          $fechaRog= trim($hoja3[$k]->rogue_mes);

          $fechaRogMod = date('Y-m', strtotime($fechaRog));
          $mesyearRG = $this->returnDate($fechaRogMod);

          $auxonerg = $this->returnDateTwo($fechaRogMod);
          $auxiliarrg = $selectHotel.' '.$auxonerg;

          if ($k === 0 && empty($rgmac)) {
            $mesrogue2 = date('Y-m', strtotime($mesrogue));
            $mesyearRG2 = $this->returnDate($mesrogue2);
            $result_rg = DB::table('RogueDevices')->insert([
              'Mes' => $mesyearRG2,
              'hotels_id' => $selectid,
              'valor' => 0
            ]);
            echo $result_rg;
            $flagRogue = true;
            break;
          }

          if (empty($rgmac) && empty($rgssid) && empty($fechaRog)) {
            continue;
          }else{
            $valuesRogue = [
              'MACRogue' => $rgmac,
              'ChannelRogue' => $rgcanal,
              'SSIDRogue' => $rgssid,
              'Mes' => $mesyearRG,
              'hotels_id' => $selectid,
              'Aux' => $auxiliarrg,
              'valor' => 1
            ];
            $RogueValues[] = $valuesRogue;
          }
        }

        //if con bandera para los rogue devices.
        // $resultRogue = DB::table('RogueDevices')->insert($RogueValues);

        $rowNum4 = $this->countArray($hoja4);

        //---Obtencion de datos HOJA WLAN.
        for ($l=0; $l < $rowNum4; $l++) {
          $nombrewlan = trim($hoja4[$l]->wlan_nombre);
          $nclientwlan = trim($hoja4[$l]->wlan_noclientes);
          $fechawl = trim($hoja4[$l]->wlan_fecha);

          $fechaWlan = date('Y-m-d', strtotime($fechawl));
          $mesyearwlan = $this->returnDate($fechaWlan);
          if (empty($nombrewlan) && empty($nclientwlan) && empty($fechawl)) {
            continue;
          }else{
            $valuesWLAN = [
              'NombreWLAN' => $nombrewlan,
              'ClientesWLAN' => $nclientwlan,
              'Fecha' => $fechaWlan,
              'Mes' => $mesyearwlan,
              'hotels_id' => $selectid
            ];
            $WLANValues[] = $valuesWLAN;
          }

        }
        $resultWlan = DB::table('WLAN')->insert($WLANValues);
      });

      notificationMsg('success', 'Registrados con exito. !!');
      return Redirect::back();

    }

    public function countArray($var)
    {
        $count = count($var);

        return $count;
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

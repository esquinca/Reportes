<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use Auth;

use DB;

use Image;

use File;

use Location;

use Carbon;

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
            // $exitecliente= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            // if ($exitecliente != 0) {
            //     /*SI existe*/
            //     $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
            // }
            return view('captureind.individual');
        }
        if($priv == 'IT'){
            // $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            // if ($exiteClienteVer != 0) {
            //     /*SI existe este en la lista de clientes*/
            //     $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
            //     return view('captureind.individual', compact('selectDatahotel'));
            // }
            // else {
            //     /*SI existe no existe en la lista de clientes*/
            //     $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
            //     return view('captureind.individual', compact('selectDatahotel'));
            // }
            $selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('IDUsuario', '=', $ID)->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
            // $selectDatahotel = DB::table('hoteles_registrados_reportes')->select('id','Nombre_hotel')->where('iduserreport', '=', $ID)->orderBy('id', 'asc')->get();
            return view('captureind.individual', compact('selectDatahotel'));
        }
        if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
            //$selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
            $selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('IDUsuario', '!=', '38')->where('IDUsuario', '!=', '1')->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
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

    public function update_avatar(Request $request){


       if($request->hasFile('upload_img')){
         $hotel= $request->select_one;
         $date= $request->month_upload;
         $dateNew=$date.'-01';

          $exist = DB::table('report_hotel_banda')->select('img')
          ->where('id_hotel', '=', $hotel)
          ->where('fecha', '=', $dateNew)
          ->count();

          $val_exist = DB::table('report_hotel_banda')->select('img')
          ->where('id_hotel', '=', $hotel)
          ->where('fecha', '=', $dateNew)
          ->value('img');

          if( $exist != 0){
            $file = public_path('img/anchobanda/' . $val_exist);
            if (File::exists($file)) {  unlink($file);  }
            notificationMsg('danger', 'Existe registro.!!');
          }
          else {
            $avatar = $request->file('upload_img');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(600,200)->save( public_path('/img/anchobanda/' . $filename ) );

            $updates = DB::table('report_hotel_banda')->insert([
              ['id_hotel' => $hotel,
              'fecha' => $dateNew,
              'img' => $filename]
            ]);
            notificationMsg('success', 'Imagen registrada.!!');
          }
       }
       //notificationMsg('imagenperf', 'Imagen actualizada.!!');
       return redirect('/individual');
   }

   public function update_type_avatar(Request $request)
   {
     if($request->hasFile('upload_img_type')){
       $hotel= $request->select_one_type;
       $date= $request->month_upload_type;
       $dateNew=$date.'-01';

        $exist = DB::table('report_hotel_tipo')->select('img')
        ->where('id_hotel', '=', $hotel)
        ->where('fecha', '=', $dateNew)
        ->count();

        $val_exist = DB::table('report_hotel_tipo')->select('img')
        ->where('id_hotel', '=', $hotel)
        ->where('fecha', '=', $dateNew)
        ->value('img');

        if( $exist != 0){
          $file = public_path('img/devicetype/' . $val_exist);
          if (File::exists($file)) {  unlink($file);  }
          notificationMsg('danger', 'Existe registro.!!');
        }
        else {
          $avatar = $request->file('upload_img_type');
          $filename = time() . '.' . $avatar->getClientOriginalExtension();
          Image::make($avatar)->resize(380,220)->save( public_path('/img/devicetype/' . $filename ) );

          $updates = DB::table('report_hotel_tipo')->insert([
            ['id_hotel' => $hotel,
            'fecha' => $dateNew,
            'img' => $filename]
          ]);
          notificationMsg('success', 'Imagen registrada.!!');
        }
     }
     return redirect('/individual');
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
     public function vdatagb($id, $date, $nzd, $tabla)
     {
       $sql = DB::table($tabla)->where('Fecha', '=', $date)->where('hotels_id', '=', $id)->where('ZD', '=', $nzd)->count();
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
     public function namehotel($id, $tabla)
     {
       $sql = DB::table($tabla)->where('id', '=', $id)->value('Nombre_hotel');
       return $sql;
     }
     public function FormatAuxName1($id_hotel, $date)
     {
       $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $numMes = date ("m", strtotime($date));
       $year = date ("Y", strtotime($date));

       $hotel_name= $this -> namehotel($id_hotel, 'hotels');

       $aux1 = $hotel_name.' '.$meses[$numMes-1].' '. $year;
       return $aux1;
     }
     public function FormatAuxName2($id_hotel, $date)
     {
       $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $numdia = date ("d", strtotime($date));
       $numMes = date ("m", strtotime($date));
       $year = date ("Y", strtotime($date));

       $hotel_name= $this -> namehotel($id_hotel, 'hotels');

       $aux2 = $hotel_name.' '.$meses[$numMes-1].' '.$numdia.' '. $year;
       return $aux2;
     }
      public function storegb(Request $request)//pendiente
      {
        $id_hotel = $request->get('ident');
        $fechaInput = $request->input('date');

        if ($request->zd == 'manual') { $id_zd = NULL; }
        else { $id_zd = $request->zd; }

        $validacionRegistro= $this -> vdatagb($id_hotel, $fechaInput, $id_zd, 'GBXDia');

        if($validacionRegistro == 1){
          return $validacionRegistro;//si hay registro mando 1 error esta registrado ese dia
        }
        if($validacionRegistro == 0){

          $giga = $request->input('vgb');

          $bytes = ((($giga * 1024) * 1024) * 1024);

          $mesyear = $this->returnDate($fechaInput);
          $auxiliarn1 = $this->FormatAuxName1($id_hotel, $fechaInput);
          $auxiliarn2 = $this->FormatAuxName2($id_hotel, $fechaInput);

          $result = DB::table('GBXDia')->insert([
            ['CantidadBytes' => $bytes,
             'ConsumoReal'=> $bytes,
             'Fecha' => $fechaInput,
             'Mes' => $mesyear,
             'hotels_id' => $id_hotel,
             'Aux' => $auxiliarn1,
             'Aux2' => $auxiliarn2,
             'Captura' => '0',
             'ZD' => $id_zd]
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

            DB::table('WLAN')->insert([
                ['NombreWLAN' => $nombre1, 'ClientesWLAN' => $clientew1, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
            ]);

            if (!empty($nombre2)  && !empty($clientew2) ) {
                $result = DB::table('WLAN')->insert([
                    ['NombreWLAN' => $nombre2, 'ClientesWLAN' => $clientew2, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
                ]);
            }
            if (!empty($nombre3) && !empty($clientew3) ) {
                $result = DB::table('WLAN')->insert([
                    ['NombreWLAN' => $nombre3, 'ClientesWLAN' => $clientew3, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
                ]);
            }
            if (!empty($nombre4) && !empty($clientew4) ) {
                $result = DB::table('WLAN')->insert([
                    ['NombreWLAN' => $nombre4, 'ClientesWLAN' => $clientew4, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
                ]);
            }
            if (!empty($nombre5) && !empty($clientew5) ) {
                $result = DB::table('WLAN')->insert([
                    ['NombreWLAN' => $nombre5, 'ClientesWLAN' => $clientew5, 'Fecha' => $fecha, 'Mes' => $mesyear, 'hotels_id' => $id_hotel]
                ]);
            }
            return $validacionRegistro;//no hay registro mando 0
        }
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

    public function searchzd(Request $request)
    {
      $id_hotel = $request->val;
      $resultado= DB::table('zonedirect_ip')->select('id_zone', 'ip')->where('id_hotel', '=', $id_hotel)->get();
      return json_encode($resultado);
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

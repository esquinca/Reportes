<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;

class ApprovalController extends Controller
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
        return view('approval.concierge');
      }

      if($priv == 'IT'){
        $selectDatahotel = DB::table('HotelUserReport')
          ->select('IDHotels','Nombre_hotel')
          ->where('IDUsuario', '=', $ID)
          ->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')
          ->orderBy('IDHotels', 'asc')
          ->get();

        return view('approval.concierge', compact('selectDatahotel'));
      }

      if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
        $selectDatahotel = DB::table('HotelUserReport')
          ->select('IDHotels','Nombre_hotel')
          ->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')
          ->orderBy('IDHotels', 'asc')
          ->get();
        return view('approval.concierge', compact('selectDatahotel'));
      }

    }
    public function index2()
    {
      $selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')
      ->where('IDUsuario', '!=', '38')->where('IDUsuario', '!=', '1')->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
      $selectDatayear = DB::table('ReportesAutorizadosNEW')->select('Year1')->orderBy('Year1', 'asc')->groupBy('Year1')->get();

      return view('approval.encuestador', compact('selectDatahotel','selectDatayear'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function typerep(Request $request)
     {
       $value= $request->numero;
       $selectnivel= DB::table('tipos_reporte_new')->select('fk_tiporeportenew','Nombre')->where('fk_hotel', '=', $value)->get();
       return json_encode($selectnivel);
     }
    public function createone(Request $request)
    {
      $correo = Auth::user()->email;
      $id_hotel = $request->select_one;
      $id_report = $request->select_two;
      $fecha = $request->calendar_fecha;

      $array = explode("-", $fecha);
      $extraer_mes = $array[0];
      $extraer_year = $array[1];

      $fechanueva= $extraer_year.'-'.$extraer_mes.'-01';

      $sql = DB::table('ReportesAutorizadosNEW')
            ->where('FechaAutorizacion', '=', $fechanueva)
            ->where('TipoReporte', '=', $id_report)
            ->where('id_hotel_fk', '=', $id_hotel)
            ->count();

      if ($sql == 0) {
        $sql= DB::table('ReportesAutorizados')->insert([
          ['FechaAutorizacion' => $fechanueva,
           'email' => $correo,
           'status1' => '1',
           'status2' => '0',
           'TipoReporte' => $id_report,
           'Year1' => $extraer_year,
           'id_hotel_fk' => $id_hotel]
        ]);
        return '1';
      }
      else {
        return '0';
      }

    }

    /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
    */
    public function show(Request $request)
    {
      $ID = Auth::user()->id;
      $correo = Auth::user()->email;
      $priv = Auth::user()->Privilegio;

      if($priv == 'IT'){
        $showreports= DB::table('ReportesAutorizadosNEW')->where('emailit', '=', $correo)->get();
        return json_encode($showreports);
      }
      if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
        $showreports= DB::table('ReportesAutorizadosNEW')->get();
        return json_encode($showreports);
      }

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
      $id_report = $request->status;
      $sql = DB::table('ReportesAutorizados')->where('id', $id_report)->delete();
      return $sql;
    }

    public function showpendientes(Request $request)
    {
      $sql = DB::table('ReportesAutorizadosNEW')->where('status2', '=', '0')->count();
      return $sql;
    }

    public function pendientesapproval (Request $request)
    {
      $id_type_report = $request->val;
      $sql = DB::table('ReportesAutorizados')->where('id', $id_type_report)->update(['status2' => '1']);
    }

    public function pendientesdesapproval (Request $request)
    {
      $id_type_report = $request->val;
      $sql = DB::table('ReportesAutorizados')->where('id', $id_type_report)->update(['status2' => '0']);
    }
    public function pendientesallapproval (Request $request)
    {
      $id_type_report = $request->val;
      $sql = DB::table('ReportesAutorizados')->where('status2', '=',  '0')->update(['status2' => '1']);
    }
    public function filterapproval(Request $request)
    {
      $year = $request->searchyear;
      $hotel = $request->searchhotel;
      $estatus = $request->searchestatus;

      if ($year == '' && $hotel == '' && $estatus == '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->get();
      }
      if ($year != '' && $hotel != '' && $estatus != '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('Year1', '=', $year)
              ->where('id_hotel_fk', '=', $hotel)
              ->where('status2', '=', $estatus)
              ->get();
      }

      if ($year != '' && $hotel == '' && $estatus == '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('Year1', '=', $year)
              ->get();
      }
      if ($year == '' && $hotel != '' && $estatus == '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('id_hotel_fk', '=', $hotel)
              ->get();
      }
      if ($year == '' && $hotel == '' && $estatus != '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('status2', '=', $estatus)
              ->get();
      }

      if ($year != '' && $hotel != '' && $estatus == '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('Year1', '=', $year)
              ->where('id_hotel_fk', '=', $hotel)
              ->get();
      }
      if ($year != '' && $hotel == '' && $estatus != '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('Year1', '=', $year)
              ->where('status2', '=', $estatus)
              ->get();
      }
      if ($year == '' && $hotel != '' && $estatus != '') {
        $sql= DB::table('ReportesAutorizadosNEW')
              ->select('Nombre_hotel','Nombre_Reporte','FechaAutorizacion','status2','id')
              ->where('id_hotel_fk', '=', $hotel)
              ->where('status2', '=', $estatus)
              ->get();
      }

      return json_encode($sql);
    }


    public function createtwo(Request $request)
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
}

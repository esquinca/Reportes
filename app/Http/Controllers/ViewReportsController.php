<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use DateTime;

use DateInterval;

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
          $exitecliente= DB::table('relacionclientes')->where('email', $correo)->count();
          if ($exitecliente != 0) {
              /*SI existe*/
              $selectDatahotel = DB::table('relacionclientes')->select('id_hotels','Nombre_hotel')->where('email', '=', $correo)->orderBy('id', 'asc')->get();

              return view('viewreport.viewreports2', compact('selectDatahotel'));
          }
      }
      if($priv == 'IT'){
          //$selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('IDUsuario', '=', $ID)->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
          $selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('IDUsuario', '=', $ID)->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
          return view('viewreport.viewreports2', compact('selectDatahotel'));
      }
      if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
          //$selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
          $selectDatahotel = DB::table('Autorizado')->select('IDHotels','Nombre_hotel')->orderBy('IDHotels', 'asc')->get();
          return view('viewreport.viewreports2', compact('selectDatahotel'));
      }
      if ($priv == 'Encuestador') {
          //$selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
          $selectDatahotel = DB::table('Autorizado')->select('IDHotels','Nombre_hotel')->orderBy('IDHotels', 'asc')->get();
          return view('viewreport.viewreports2', compact('selectDatahotel'));
      }
    }

    public function typerep(Request $request)
    {
      $value= $request->numero;
      //$selectnivel= DB::table('NivelesReportes')->select('ReporteID','Nivel')->where('HotelID', '=', $value)->get();
      $selectnivel= DB::table('tipos_reporte_new')->select('fk_tiporeportenew','Nombre')->where('fk_hotel', '=', $value)->get();
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
      $correo = Auth::user()->email;
      $priv = Auth::user()->Privilegio;

      $numero_hotel= $request->nhotel;
      $type= $request->tipo;

      if ($priv == 'Cliente') {
        # code...
        $verificarExite= $resultadoOne= DB::table('ReportesAutorizadosNEW')
        ->select(DB::raw('min(FechaAutorizacion) as daynew'))
        ->where('id_hotel_fk', '=', $numero_hotel)
        ->where('status1', '=', '1')
        ->where('status2', '=', '1')
        ->count();

        if ($verificarExite == 0) {
          return '0';
        }else{
          $resultadoOne= DB::table('ReportesAutorizadosNEW')
          ->select(DB::raw('min(FechaAutorizacion) as daynew'))
          ->where('id_hotel_fk', '=', $numero_hotel)
          ->where('status1', '=', '1')
          ->where('status2', '=', '1')
          ->value('daynew');

          $fechaC =  explode('-', $resultadoOne);
          $fechaYear= $fechaC[0];
          $fechaMonth= $fechaC[1];
          $fechaDay= $fechaC[2];
          $contenar = $fechaMonth.'-'.$fechaYear;
            return $contenar;
        }
      }
      else {
        return '01-2016';
      }

    }

    public function nvreport(Request $request)
    {
      $hotel= $request->aa1;
      $type= $request->aa2;
      $date= $request->aa3;

      //01-2016

      $datemonthyear =  explode('-', $date);
      $datemonth= $datemonthyear[0];
      $dateyear= $datemonthyear[1];

      $datefull = $dateyear.'-'.$datemonth.'-01';

      $resultado= DB::table('ReportesAutorizadosNEW')
      ->select('id')
      ->where('id_hotel_fk', '=', $hotel)
      ->where('Nombre_Reporte', '=', $type)
      ->where('FechaAutorizacion', '=', $datefull)
      ->where('status2', '=', '1')
      ->count();

      if ($resultado == 0) {
          return '0';
      }else{
          return '1';
      }
    }

    public function nvreportadmin(Request $request)
    {
      $hotel= $request->aa1;
      $type= $request->aa2;
      $date= $request->aa3;

      $resultadoOne= DB::table('TipoReporteNEW')
      ->select('id')
      ->where('Nombre', '=', $type)
      ->where('Estado', '=', '1')
      ->value('id');

      $resultado= DB::table('hotel_tipo_reporte')
      ->select('id')
      ->where('fk_hotel', '=', $hotel)
      ->where('fk_tiporeportenew', '=', $resultadoOne)
      ->count();

      if ($resultado == 0) {
          return '0';
      }else{
          return '1';
      }
    }

    public function contenido(Request $request)
    {
      $numero_hotel= $request->number;
      $type= $request->type;
      $date= $request->mes;
      $resultados = DB::table('UsuariosGBMaxMin')->select('AP','MaxGBv','MinGBv','TOTALUSER','MaxClientes','RogueDevice')
                                ->where('ID', '=' , $numero_hotel)
                                ->where('Mes', '=' , $date)
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
      $fechaC =  explode('-', $date);
      $fechaMes= $fechaC[0];
      $fechayear= $fechaC[1];
      $resultados = DB::select('CALL User(?,?,?)', array($fechayear, $fechaMes, $numero_hotel));
      return json_encode($resultados);
    }
    public function show_graf_gb(Request $request)
    {
      $numero_hotel= $request->number;

      $date= $request->mes;
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fechaC =  explode('-', $date);
      $fechaMes= $fechaC[0];
      $fechayear= $fechaC[1];
      $mesyear = $meses[$fechaMes-1].' '. $fechayear;

      $resultados = DB::select('CALL GB(?,?,?)', array($fechayear, $fechaMes, $numero_hotel));
      return json_encode($resultados);
    }
    public function show_graf_two(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $fechaC =  explode('-', $date);
      $fechaMes= $fechaC[0];
      $fechayear= $fechaC[1];
      $resultados = DB::select('CALL WLAN(?,?,?)', array($fechayear, $fechaMes, $numero_hotel));
      return json_encode($resultados);
    }
    public function show_graf_three (Request $request){
      $numero_hotel= $request->number;
      $date= $request->mes;
      $fechaC =  explode('-', $date);
      $fechaMes= $fechaC[0];
      $fechayear= $fechaC[1];
      $resultados = DB::select('CALL WLAN(?,?,?)', array($fechayear, $fechaMes, $numero_hotel));
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

    public function GetMostAp(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $splitdate = explode("-", $date);

      $mes = $splitdate[0];
      $year = $splitdate[1];

      $resultados = DB::select('CALL GetMostAp(?, ?, ?)', array($numero_hotel, $year, $mes));

      return json_encode($resultados);
    }

    public function returnDate($date)
    {
        $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $fechaC =  explode('-', $date);
        $fechaMes= $fechaC[0];
        $fechayear= $fechaC[1];
        $mesyear = $meses[$fechaMes-1].' '. $fechayear;
        return $mesyear;
    }
    public function info_cuad(Request $request)
    {
      $numero_hotel= $request->number;
      $type= $request->type;
      $datenum= $request->mes;
      $fechaC =  explode('-', $datenum);
      $fechaMes= $fechaC[0];
      $fechayear= $fechaC[1];

      $date = $this->returnDate($datenum);

      $resultadosOnea = DB::select('CALL Cuadros(?,?,?)', array($numero_hotel, $fechaMes, $fechayear));
      return json_encode($resultadosOnea);

    }
    public function consultypeimg (Request $request)
    {
      $number_hotel= $request->aa1;
      $type= $request->aa2;
      $date_without_format= $request->aa3;

      $dateNumber =  explode('-', $date_without_format);
      $dateMonth= $dateNumber[0];
      $dateYear= $dateNumber[1];
      $datewithformat=$dateYear.'-'.$dateMonth.'-01';

      $result = DB::table('report_hotel_tipo')
                ->where('id_hotel', '=' , $number_hotel)
                ->where('fecha', '=' , $datewithformat)
                ->count();

      if ($result == 0) {
          return '0';
      } else {
          return '1';
      }
    }
    public function consultrouteimgtype(Request $request)
    {
      $number_hotel= $request->aa1;
      $type= $request->aa2;
      $date_without_format= $request->aa3;

      $dateNumber =  explode('-', $date_without_format);
      $dateMonth= $dateNumber[0];
      $dateYear= $dateNumber[1];
      $datewithformat=$dateYear.'-'.$dateMonth.'-01';

      $result = DB::table('report_hotel_tipo')
                ->select('img')
                ->where('id_hotel', '=' , $number_hotel)
                ->where('fecha', '=' , $datewithformat)
                ->value('img');

      return $result;
    }

    public function table_month_vs_month_previous(Request $request){
      $number_hotel= $request->aa1;
      $type= $request->aa2;
      $date_without_format= $request->aa3;

      $date_with_format_current = $this->returnDate($date_without_format);
      $date_with_format_previous= $this->returnDatePrevious($date_without_format);
      // <td>USUARIOS MÁXIMOS POR HORA</td>
      // <td>USUARIOS PROMEDIO POR HORA</td>
      // <td>GIGABYTES POR DÍA</td>
      // <td>ANCHO DE BANDA PROMEDIO</td>
      // <td>DISPOSITIVOS POR MES</td>

      $resultado_MaxClientes_act= DB::table('NewClientesDashboard')
                  ->join('NewGbDashboard', 'NewClientesDashboard.ID', '=', 'NewGbDashboard.hotels_id')
                  ->join('NewRogueAPDashboard', 'NewClientesDashboard.ID', '=', 'NewRogueAPDashboard.IDHOTEL')
                  ->select('NewClientesDashboard.MaxClientes')
                  ->where('NewGbDashboard.hotels_id', '=' , $number_hotel)
                  ->where('NewGbDashboard.Mes', '=' , $date_with_format_current)
                  ->where('NewClientesDashboard.ID', '=' , $number_hotel)
                  ->where('NewClientesDashboard.Mes', '=' , $date_with_format_current)
                  ->where('NewRogueAPDashboard.IDHOTEL', '=' , $number_hotel)
                  ->where('NewRogueAPDashboard.Mes', '=' , $date_with_format_current)
                  ->value('MaxClientes');

      $resultado_AVGClientes_act= DB::table('NewClientesDashboard')
                  ->join('NewGbDashboard', 'NewClientesDashboard.ID', '=', 'NewGbDashboard.hotels_id')
                  ->join('NewRogueAPDashboard', 'NewClientesDashboard.ID', '=', 'NewRogueAPDashboard.IDHOTEL')
                  ->select('NewClientesDashboard.AVGClientes')
                  ->where('NewGbDashboard.hotels_id', '=' , $number_hotel)
                  ->where('NewGbDashboard.Mes', '=' , $date_with_format_current)
                  ->where('NewClientesDashboard.ID', '=' , $number_hotel)
                  ->where('NewClientesDashboard.Mes', '=' , $date_with_format_current)
                  ->where('NewRogueAPDashboard.IDHOTEL', '=' , $number_hotel)
                  ->where('NewRogueAPDashboard.Mes', '=' , $date_with_format_current)
                  ->value('AVGClientes');

      // $resultadoA= DB::table('NewClientesDashboard')
      //             ->join('NewGbDashboard', 'NewClientesDashboard.ID', '=', 'NewGbDashboard.hotels_id')
      //             ->join('NewRogueAPDashboard', 'NewClientesDashboard.ID', '=', 'NewRogueAPDashboard.IDHOTEL')
      //             ->select('NewClientesDashboard.MaxClientes','NewClientesDashboard.MinClientes',
      //               'NewGbDashboard.MAXGB','NewGbDashboard.MINGB',
      //               'NewGbDashboard.AVGGB','NewGbDashboard.Total',
      //               'NewClientesDashboard.TotalClientes','NewClientesDashboard.AVGClientes',
      //               'NewRogueAPDashboard.CantidadRogue','NewRogueAPDashboard.AP')
      //             ->where('NewGbDashboard.hotels_id', '=' , $number_hotel)
      //             ->where('NewGbDashboard.Mes', '=' , $date_with_format_previous)
      //             ->where('NewClientesDashboard.ID', '=' , $number_hotel)
      //             ->where('NewClientesDashboard.Mes', '=' , $date_with_format_previous)
      //             ->where('NewRogueAPDashboard.IDHOTEL', '=' , $number_hotel)
      //             ->where('NewRogueAPDashboard.Mes', '=' , $date_with_format_previous)
      //             ->get();

      // $data_array1 = array();
      // $data_array2 = array();
      //
      // array_push($data_array1, array("identificador" => $sql_eight[$i] ,
      //  "hotel" => $sql_one[$i] , "vertical" => $sql_two[$i], "IT" => $sql_four[$i] ,
      //   "years" => $sql_six[$i] , "Promedio" => $sql_five[$i] , "UltimoComentario" =>  $sql_seven[$i] ) );
      return $resultado_MaxClientes_act;

    }
    public function returnDatePrevious($date)
    {
        $dateMonthAndYearPrevious = 0;
        $dateNumber =  explode('-', $date);
        $dateMonth= $dateNumber[0];
        $dateYear= $dateNumber[1];
        $monthInSpanish= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        if ($dateMonth <= '01') {
          $dateMonthPrevious = '12';
          $dateYearPrevious = $dateYear-1;
          $dateMonthAndYearPrevious = $monthInSpanish[$dateMonthPrevious-1].' '. $dateYearPrevious;
        }
        else {
          $dateMonthAndYearPrevious = $monthInSpanish[$dateMonth-2].' '. $dateYear;
        }
        return $dateMonthAndYearPrevious;
    }

    public function consultexitimg (Request $request)
    {
      $number_hotel= $request->aa1;
      $type= $request->aa2;
      $date_without_format= $request->aa3;

      $dateNumber =  explode('-', $date_without_format);
      $dateMonth= $dateNumber[0];
      $dateYear= $dateNumber[1];
      $datewithformat=$dateYear.'-'.$dateMonth.'-01';

      $result = DB::table('report_hotel_banda')
                ->where('id_hotel', '=' , $number_hotel)
                ->where('fecha', '=' , $datewithformat)
                ->count();

      if ($result == 0) {
          return '0';
      } else {
          return '1';
      }
    }
    public function consultrouteimg(Request $request)
    {
      $number_hotel= $request->aa1;
      $type= $request->aa2;
      $date_without_format= $request->aa3;

      $dateNumber =  explode('-', $date_without_format);
      $dateMonth= $dateNumber[0];
      $dateYear= $dateNumber[1];
      $datewithformat=$dateYear.'-'.$dateMonth.'-01';

      $result = DB::table('report_hotel_banda')
                ->select('img')
                ->where('id_hotel', '=' , $number_hotel)
                ->where('fecha', '=' , $datewithformat)
                ->value('img');

      return $result;
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

    public function CompareTable(Request $request)
    {
      $numero_hotel= $request->number;
      $date= $request->mes;
      $hotel_name = trim($request->nameh);
      $datenow = $request->mesnow;
      $datelast = $request->meslast;

      //$dateaux = date('F', strtotime($date));

      $dateObj = DateTime::createFromFormat('m-Y', $date);
      $monthyear = $dateObj->format('F Y');
      $monthyearminus = $dateObj->sub(new DateInterval('P1M'))->format('F Y');

      $auxnow = $hotel_name . " " . $monthyear;
      $auxminus = $hotel_name . " " . $monthyearminus;
      $auxnow2 = $hotel_name . " " . $datenow;
      $auxminus2 = $hotel_name . " " . $datelast;

      $result = DB::select('CALL Comparativo(?, ?)', array($auxminus2, $auxnow2));

      return json_encode($result);
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

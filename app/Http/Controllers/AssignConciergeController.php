<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

use SNMP;

class AssignConciergeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$selectDataUser = DB::table('ListarUserReportes')->orderBy('id', 'asc')->get();
      $selectDataUser= DB::table('listarusuariosreportes')->select('IDUsuario','Encargado')->orderBy('IDUsuario', 'asc')->get();
      return view('assign.assign', compact('selectDataUser'));
      //return view('assign.assign');
    }
    public function recargar(Request $request){
      $id= $request->sector;
      $sql= DB::table('alonso')->select('hotelID','Nombre_hotel', 'userreporteID', 'itconciergeID')->where('hotelID', '=', $id)->get();
      return json_encode($sql);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show (Request $request)
     {
       /*
          $resultado = DB::table('HotelUserReport')->select('CorreosZD')
          */
         $resultado= DB::table('alonso')->select(
           'Nombre_hotel',
           'hotelID',
           'userreporteID',
           'Encargado'
          )->orderBy('hotelID', 'asc')->get();
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
    public function update(Request $request)
    {
      $value='1';
      $edita_idhotel= $request->hotel;
      $edita_iduserconci= $request->concierge;

      $emailuser = $this->getCorreo($edita_iduserconci);
      $edita_idconcierge = $this->getIdCon($emailuser);

      $sql = DB::table('hotels')->where('id', '=', $edita_idhotel)
      ->update(['user_reportes_id' => $edita_iduserconci, 'itconcierges_id' => $edita_idconcierge]);

      return $value;
    }

    public function getCorreo($value)
    {
      $resultado= DB::table('listarusuariosreportes')->select('email')->where('IDUsuario', '=', $value)->value('IDUsuario');

      return $resultado;
    }

    public function getIdCon($value)
    {
      $resultado= DB::table('itconcierges')->select('id')->where('email', '=', $value)->value('id');

      return $resultado;
    }

    public function rutaestadoserver()
    {
      $boolean = 0;
      //187.157.151.52
      //201.161.132.22
      //187.252.50.79
      $session = new SNMP(SNMP::VERSION_2C, '187.157.151.52', "public");
      try {
        $res = $session->walk("1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2");
      } catch (\Exception $e) {
        $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
        var_dump($boolean);
      }
      echo $boolean;

      $session->close();
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

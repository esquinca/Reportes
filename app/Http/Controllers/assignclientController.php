<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class assignclientController extends Controller
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

        //$selectDatahotel = DB::table('listarhoteles')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
        $selectDatahotel = DB::table('hoteles_registrados_reportes')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
        $selectDataCliente = DB::table('listarclientesreportes')->select('idc', 'cliente')->orderBy('idc', 'asc')->get();

        return view('assignclient.assignclient', compact('selectDatahotel', 'selectDataCliente'));
        //return view('assignclient.assignclient');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $id_hotel = $request->idh;
        $id_cliente = $request->idc;

        if ($this->checkReg($id_hotel, $id_cliente)) {
            $sql = DB::table('rel_clientes_hotel_rep')->insert(
                ['id_hotels' => $id_hotel, 'id_clientes' => $id_cliente]
            );
            return "1";
        }else{
            return "0";
        }
        return "0";
    }

    public function checkReg($value, $value2)
    {
        $sql = DB::table('rel_clientes_hotel_rep')->select('id_hotels', 'id_clientes')->where([['id_hotels', '=', $value],['id_clientes', '=', $value2]])->count();

        if ($sql == 0) {
            return TRUE;
        }else{
            return FALSE;
        }
        return FALSE;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $id= $request->scv;
      $sql= DB::table('relacionclientes')->select('id_hotels', 'id_clientes', 'Nombre_hotel')->where('id', '=', $id)->get();
      return json_encode($sql);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $resultado= DB::table('relacionclientes')->orderBy('id', 'asc')->get();
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
        $id_registro = $request->idreg;
        $id_cliente = $request->idcl;

        $sql = DB::table('rel_clientes_hotel_rep')->where('id', $id_registro)->update(['id_clientes' => $id_cliente]);

        return $sql;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->idreg;

        $sql = DB::table('rel_clientes_hotel_rep')->where('id', $id)->delete();

        return $sql;
    }
}

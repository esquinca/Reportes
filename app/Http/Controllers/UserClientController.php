<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class UserClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectonedata = DB::table('hoteles_registrados_reportes')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
        $selecttwodata = DB::table('user_reportes')->select('id', 'email')->where('Privilegio', '=', 'Cliente')->orderBy('id', 'asc')->get();

        return view('user.add_user_client', compact('selectonedata', 'selecttwodata'));
    }

    public function showclient(Request $request)
    {
      $selecttwodata = DB::table('user_reportes')->select('id', 'email')->where('Privilegio', '=', 'Cliente')->orderBy('id', 'asc')->get();
      return json_encode($selecttwodata);
    }

    public function showTable()
    {
        $resultado= DB::table('relacionclientes')->where('Privilegio', '=', 'Cliente')->orderBy('id', 'asc')->get();

        return json_encode($resultado);
    }

    public function edithotelclien(Request $request)
    {
        $id= $request->xa;
        $sql= DB::table('relacionclientes')->select('id_hotels', 'id_clientes', 'Nombre_hotel')->where('id', '=', $id)->get();
        return json_encode($sql);
    }

    public function checkReg($value, $value2)
    {
        $sql = DB::table('relacionclientes')->where([['id_hotels', '=', $value],['id_clientes', '=', $value2]])->count();

        if ($sql == 0) {
            return TRUE;
        }else{
            return FALSE;
        }
        return FALSE;
    }

    public function changehotelclien(Request $request)
    {
        # code...
        $id = $request->xa;
        $enc= $request->xb;

        $resultado_hotels= DB::table('relacionclientes')->select('id_hotels')->where('id', '=', $id)->value('id_hotels');
        $resultado_encuest= DB::table('relacionclientes')->select('id_clientes')->where('id', '=', $id)->value('id_clientes');

        $valido = $this->checkReg($resultado_hotels, $enc);

        //return $valido;

        if ( $valido == TRUE){
        # code...
        # NO ENCONTRO
        $sql = DB::table('rel_clientes_hotel_rep')->where('id', '=', $id)
        ->update([
          'id_clientes' => $enc
         ]);

        return "OK";
        }
        if ( $valido == FALSE){
         # code...
         # SI ENCONTRO
         return "NA";
        }
    }

    public function delete(Request $request)
    {
        $id = $request->xa;
        $sql = DB::table('rel_clientes_hotel_rep')->where('id', $id)->where('Privilegio', '=', 'Cliente')->delete();
        return $sql;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $hotel_res = $request->xa;
       $encue_res = $request->xb;

       $preg_exite = DB::table('rel_clientes_hotel_rep')
                     ->where('id_hotels', '=', $hotel_res)
                     ->where('id_clientes', '=', $encue_res)
                     ->where('privilegio', '=', 'Cliente')
                     ->get();

       $resp_size= count($preg_exite);

       if ( $resp_size == 0 ) {
         # code...
         # Se inserta.
         $sql_insert = DB::table('rel_clientes_hotel_rep')->insertGetId([
           'id_hotels' => $hotel_res,
           'id_clientes' => $encue_res,
           'privilegio' => 'Cliente'
         ]);
         return "OK";
       }

       if ( $resp_size != 0 ) {
         # code...
         return "NA";
       }
    }

    public function validatePriv(Request $request)
    {
        $pass = '$2y$10$yaY/sm862nuq51sUCpS/he2CRP3Tp1mGkYg.LbZbavz1nWk0jEpOy';
        $mail = $request->inputEmail;
        $nick = $request->inputNick;
        $nombre = $request->inputName;
        $priv = $request->selectpriv;

        $res = DB::table('user_reportes')->select('Privilegio')->where('email', '=', $mail)->get();

        $size = count($res);
        //$varnew = $res[0]->Privilegio;
        //print_r($size);
        //var_dump($varnew);

        if ($size === 0) {
            DB::table('user_reportes')->insert([
                ['name' => $nick, 'nombrecomp' => $nombre, 'email' => $mail, 'Privilegio' => 'Cliente' , 'password' => $pass]
            ]);
            return 'OK';
        }
        if ($size === 1) {
            $varnew = $res[0]->Privilegio;
            if ($varnew === "Encuestado") {
                # inserto
                DB::table('user_reportes')->insert([
                    ['name' => $nick, 'nombrecomp' => $nombre, 'email' => $mail, 'Privilegio' => 'Cliente' , 'password' => $pass]
                ]);
                return 'OK';
            }else{
                return 'NA';
            }
        }
        if ($size > 1) {
            # No se inserta nada
            return 'NA';
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id= $request->sector;
        $result = DB::table('user_reportes')->select(
        'id',
        'name',
        'nombrecomp',
        'email'
        )->where('id', '=', $id)->get();
        return json_encode($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editdata(Request $request)
    {
        # code...
        $nick_res = $request->xa;
        $name_res = $request->xb;
        $ident_res = $request->xc;

        $ident = 0;

        $resultado_nick= DB::table('user_reportes')->select('name')->where('id', '=', $ident_res)->value('name');
        $resultado_name= DB::table('user_reportes')->select('nombrecomp')->where('id', '=', $ident_res)->value('nombrecomp');

        if($resultado_nick == $nick_res && $resultado_name == $name_res){
         return $ident;
        }
        else {
         $sql = DB::table('user_reportes')->where('id', '=', $ident_res)
         ->update([
           'name' => $nick_res ,
           'nombrecomp' => $name_res
          ]);

          if ($sql == 1) {
            return 1;
          }
          else {
            return 2;
          }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $resultado= DB::table('user_reportes')->select(
          'id',
          'name',
          'email',
          'Privilegio'
         )
         ->where('Privilegio', '=', 'Cliente')
         ->orderBy('id', 'asc')->get();
        return json_encode($resultado);
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

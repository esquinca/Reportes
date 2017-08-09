<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

use \Crypt;

use Mail;

class UserQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $selectonedata = DB::table('hoteles_registrados_reportes')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
      $selecttwodata = DB::table('user_reportes')->select('id', 'email')->where('Privilegio', '=', 'Encuestado')->orderBy('id', 'asc')->get();
      return view('user.add_user_enc', compact('selectonedata', 'selecttwodata'));
      //return view('user.add_user_enc');
    }
    public function showclient(Request $request)
    {
      $selecttwodata = DB::table('user_reportes')->select('id', 'email')->where('Privilegio', '=', 'Encuestado')->orderBy('id', 'asc')->get();
      return json_encode($selecttwodata);
    }

    public function edithotelenc(Request $request)
    {
      # code...
      $id= $request->xa;
      $sql= DB::table('relacionclientes')->select('id_hotels', 'id_clientes', 'Nombre_hotel')->where('id', '=', $id)->get();
      return json_encode($sql);
    }
    public function changehotelenc(Request $request)
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

    /**
     * Relación de encuestado con hotel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * Relación de encuestado con hotel.
     */
     public function create(Request $request)
     {
       $hotel_res = $request -> xa;
       $encue_res = $request -> xb;

       $preg_exite = DB::table('rel_clientes_hotel_rep')
                     ->where('id_hotels', '=', $hotel_res)
                     ->where('id_clientes', '=', $encue_res)
                     ->where('privilegio', '=', 'Encuestado')
                     ->get();

       $resp_size= count($preg_exite);

       if ( $resp_size == 0 ) {
         # code...
         # Se inserta.
         $sql_insert = DB::table('rel_clientes_hotel_rep')->insertGetId([
           'id_hotels' => $hotel_res,
           'id_clientes' => $encue_res,
           'privilegio' => 'Encuestado'
         ]);
         return "OK";
       }

       if ( $resp_size != 0 ) {
         # code...
         return "NA";
       }

     }

     public function store(Request $request)
     {
       $resultado= DB::table('relacionclientes')->where('Privilegio', '=', 'Encuestado')->orderBy('id', 'asc')->get();
       //$resultado= DB::table('rel_clientes_hotel_rep')->where('Privilegio', '=', 'Encuestado')->orderBy('id', 'asc')->get();
       return json_encode($resultado);
     }

     public function delete(Request $request)
     {
       $id = $request->xa;
       $sql = DB::table('rel_clientes_hotel_rep')->where('id', $id)->where('Privilegio', '=', 'Encuestado')->delete();
       return $sql;
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show(Request $request)
     {
       $resultado= DB::table('user_reportes')->select(
          'id',
          'name',
          'email',
          'Privilegio'
         )
         ->where('Privilegio', '=', 'Encuestado')
         ->orderBy('id', 'asc')->get();
        return json_encode($resultado);
    }
    public function editar(Request $request)
    {
      $id= $request->sector;
      $result = DB::table('user_reportes')->select(
      'id',
      'name',
      'nombrecomp',
      'email',
      'temp_pass',
      'shell'
      )->where('id', '=', $id)->get();
      return json_encode($result);
    }

    /**
     *
     */
     public function nrand(Request $request)
     {
       # code...
       $random = $request -> xa;
       $id_enc = $request -> xb;

       $encrypt_id= Crypt::encrypt($id_enc);
       $encrypt_pass= bcrypt($random);


       $sql = DB::table('user_reportes')->where('id', '=', $id_enc)
       ->update([
         'password' => $encrypt_pass ,
         'temp_pass' => $random ,
         'shell' => $encrypt_id
        ]);
        return $sql;
     }

     public function editdata(Request $request)
     {
       # code...
       $nick_res = $request -> xa;
       $name_res = $request -> xb;
       $ident_res = $request -> xc;

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

     public function copiamail(Request $request)
     {
       # code...
       $ident_res = $request -> xa;
       $correo_res = $request -> xb;
       $host_res = $request -> xc;

       $resultado_name= DB::table('user_reportes')->select('nombrecomp')->where('id', '=', $ident_res)->value('nombrecomp');
       $resultado_email= DB::table('user_reportes')->select('email')->where('id', '=', $ident_res)->value('email');
       $resultado_pass=DB::table('user_reportes')->select('temp_pass')->where('id', '=', $ident_res)->value('temp_pass');
       $resultado_url=  DB::table('user_reportes')->select('shell')->where('id', '=', $ident_res)->value('shell');

       $dir= $host_res.'/survey_questions'.'/'.$resultado_url;

       $data = [
         'nombre' => $resultado_name,
         'correo' => $resultado_email,
         'password' => $resultado_pass,
         'url' => $dir,
         'mensaje' => 'Su tiempo estimado de responder la encuesta correspondiente al mes actual es de 10 dias'
       ];

       $this->enviarC($resultado_email, $correo_res, $data);

       return 'OK';
     }

     public function enviarC($correo, $copia, $datos)
     {
       Mail::send('emailMensajeEncuesta', $datos, function ($message) use ($correo, $copia) {
           //$message->from('contactoweb@sitwifi.com', 'ContactoSitwifiWeb');
           $message->to($correo)->subject('Encuesta Mensual');
           $message->cc($copia);
       });
     }

    public function emailverf(Request $request)
    {
      # code...
      $nick_res= $request -> inputNick;
      $name_res = $request -> inputName;
      $email_res = $request -> inputEmail;
      $respuesta_clave = false;

      $sql_conf = DB::table('user_reportes')->select('Privilegio')->where('email', '=', $email_res)->get();
      $sql_size= count($sql_conf);

      $six_random_number = mt_rand(100000, 999999);
      $encrypt_pass= bcrypt($six_random_number);

      if ( $sql_size == 0 ) {
          # code...
          # Se inserta.
          $sql_insert = DB::table('user_reportes')->insertGetId([
                    'name' => $nick_res,
              'nombrecomp' => $name_res,
                   'email' => $email_res,
                  'avatar' => 'default.jpg',
              'Privilegio' => 'Encuestado',
                'password' => $encrypt_pass,
              'temp_pass'  => $six_random_number,
              'created_at' => date('Y-m-d H:i:s')
            ]);
          $encrypt_id= Crypt::encrypt($sql_insert);
          $sql_upd_ins = DB::table('user_reportes')->where('id', '=', $sql_insert)->update(['shell' => $encrypt_id]);
          return 'OK';
      }

      if ( $sql_size == 1 ) {
        # code...
        $preg_priv=  $sql_conf[0]->Privilegio;
        if ( $preg_priv == 'Cliente') {
          # code...
          # Inserto encuestado
          $sql_insert = DB::table('user_reportes')->insertGetId([
                    'name' => $nick_res,
              'nombrecomp' => $name_res,
                   'email' => $email_res,
                  'avatar' => 'default.jpg',
              'Privilegio' => 'Encuestado',
                'password' => $encrypt_pass,
              'temp_pass'  => $six_random_number,
              'created_at' => date('Y-m-d H:i:s')
            ]);
          $encrypt_id= Crypt::encrypt($sql_insert);
          $sql_upd_ins = DB::table('user_reportes')->where('id', '=', $sql_insert)->update(['shell' => $encrypt_id]);
          return 'OK';
        }
        else {
            # code...
            # No Inserto nada
            return 'NA';
        }

      }
      if ( $sql_size > 1 ) {
        # code...
        return 'NA';
      }

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

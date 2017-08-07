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
      return view('user.add_user_enc');
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

       return 1;
     }

     public function enviarC($correo, $copia, $datos)
     {
       Mail::send('emailMensajeEncuesta', $datos, function ($message) use ($correo, $copia) {
           //$message->from('contactoweb@sitwifi.com', 'ContactoSitwifiWeb');
           $message->to($correo)->subject('Encuesta Mensual');
           $message->cc($copia);
       });
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

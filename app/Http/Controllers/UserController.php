<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('user.add_user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $nick= $request->inputNick;
      $name= $request->inputName;
      $mail= $request->inputEmail;
      $privilegio= $request->selectpriv;
      $password = bcrypt('123456');
      $imagen = 'default.jpg';
      $now = date("Y-m-d H:i:s");

      $sql = DB::table('user_reportes')->where('email', '=', $mail)->count();
      if ($sql == 0) {
        notificationMsg('success', 'Registrando.!!');
        $registro = DB::table('user_reportes')->insertGetId(
            ['name' => $nick,
             'email' => $mail,
             'nombrecomp' => $name,
             'Privilegio' => $privilegio,
             'password' => $password,
             'avatar' => $imagen,
             'created_at' => $now,
             'updated_at' => $now]
        );
        return Redirect::back();
      }
      else {
        notificationMsg('danger', 'Este Correo electronico ya se encuentra Registro.!!');
        return Redirect::back();
      }

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
        )->orderBy('id', 'asc')->get();
       return json_encode($resultado);

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar(Request $request)
    {
      $id= $request->sector;
      $result = DB::table('user_reportes')->select(
      'id',
      'name',
      'nombrecomp',
      'email',
      'Privilegio'
      )->where('id', '=', $id)->get();
      return json_encode($result);
    }
    public function edit(Request $request)
    {
      $mail= $request->correo;
      $sql = DB::table('user_reportes')->where('email', '=', $mail)->count();
      return $sql;
    }
    public function editDos(Request $request)
    {
      $id= $request->sector;
      $mail= $request->correo;
      $sql = DB::table('user_reportes')->where('id', '=', $id)->where('email', '=', $mail)->count();
      return $sql;
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
       $edita_id= $request->id_recibido;
       $edita_ni= $request->inpuEditnick;
       $edita_na= $request->inputEditName;
       $edita_em= $request->inputEditEmail;
       $edita_ep= $request->selectEditPriv;

       $sql = DB::table('user_reportes')->where('id', '=', $edita_id)
       ->update(
           ['name' => $edita_ni,
           'nombrecomp' => $edita_na,
             'email'=> $edita_em,
             'Privilegio' => $edita_ep]
       );

       notificationMsg('success', 'Registro Actualizado!!');
       return Redirect::back();
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

<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use DB;

use Auth;

use Image;

use File;

use Location;

use Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function profile(){
      $position = Location::get();
      $cityIP = $position-> cityName;
      $regioIP= $position-> regionName;
      $abrecode= $position-> countryCode;
      $paiscode= $position-> countryName;
      $concatenarIPdatos= $cityIP.', '.$regioIP.', '.$abrecode;
      return view('profile.profile', array('user' => Auth::user(), 'LocationIP'=>$concatenarIPdatos) );
    }
    public function data_user(Request $request)
   {
       $correo = Auth::user()->email;
       $resultClient = DB::table('user_reportes')->select('dia',
       'mes')->where('email', '=', $correo)->get();
       return json_encode($resultClient);
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
     public function update_avatar(Request $request){
        $correo = Auth::user()->email;
        if($request->hasFile('avatar')){
            $user = Auth::user();
            if ($user->avatar !== 'default.jpg') {
                $file = public_path('img/avatars/' . $user->avatar);
                if (File::exists($file)) {  unlink($file);  }
            }
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save( public_path('/img/avatars/' . $filename ) );
            $updates = DB::table('user_reportes')->where('email', '=', $correo)
            ->update(['avatar' => $filename]);
        }
        //notificationMsg('imagenperf', 'Imagen actualizada.!!');
        return redirect('/profile');
    }

    public function update(Request $request)
    {
        $nombre = $request->inputNamefull;
        $apodo = $request->inputNamefull;
        $correo = $request->inputEmail;
        $datenaci = $request->inputdatenac;
        $separard2 = explode ( '-', $datenaci);
        $diaNa=$separard2[2];
        $mesNa=$separard2[1];
        $anoNa=$separard2[0];

        $sql = DB::table('user_reportes')->where('email', '=', $correo)
        ->update(
            [ 'name' => $apodo,
              'nombrecomp' => $nombre,
              'dia' => $diaNa,
              'mes' => $mesNa,
              'yearing' => $anoNa]
        );

        notificationMsg('success', 'Información actualizada.!!');
        return Redirect::back();
    }

    public function updatetwo(Request $request){
      $contrasenaNew = $request->inputnpass;
      $correo = $request->inputEmailcorreo;

      $passwordcifrar = bcrypt($contrasenaNew);


      $sql = DB::table('user_reportes')->where('email', '=', $correo)
      ->update(
          [ 'password' => $passwordcifrar ]
      );

      auth()->logout();
      return redirect('logout');
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

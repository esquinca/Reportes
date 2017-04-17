<?php

namespace App\Http\Controllers\Auth;

use App\SocialProvider;
use DB;
use Auth;
use Socialite;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user_reportes',
            'password' => 'required|confirmed|min:6',
            'terms' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar'=> 'default.jpg',
            'Privilegio'=> 'Admin', 
            'nombrecomp'=> '',
            'password' => bcrypt($data['password']),
        ]);
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
    * Obtain the user information from GitHub.
    *
    * @return Response
    */
    public function handleProviderCallback($provider)
    {
            try
            {
                //El controlador que obtiene la informacion de google
                $socialUser = Socialite::driver($provider)->user();
                /*var_dump($socialUser); //Imprimimos para saber que devuelve el array de google*/
            }
            catch(\Exception $e)
            {
                return redirect('/');
            }

            //Verificamos si el id del provedor existe en la tabla de modelo socialprovider
            $socialProvider = SocialProvider::where('provider_id', $socialUser->id)->first();
            /*var_dump($socialProvider); //Este es para saber que devuelve nuestro array*/

            if (!$socialProvider) { //Si no existe en la tabla social_providers realizara lo siguiente.

                //echo 'no existen datos en la tabla de social_providers_three <bR>';
                //echo $socialUser->email;

                //Realizamos consulta con eloquent para saber si existe el correo en la tabla user_reportes de nuestra bd
                $authUser = User::where('email', $socialUser->email)->first();
                /*var_dump($authUser); //Imprimo que nos devuelve*/

                if (!$authUser) { //Si me devuelve null mando el siguiente mensaje
                  //return redirect('/home');
                  //return Redirect::back()->notificationMsg('success', 'Operación completada. Nota: Se cambio al ultimo Tipo de cambio capturado. !!');
                  notificationMsg('danger', 'La cuenta de Gmail asociada, no está registrada en el sistema. Nota: Comunicarse con el administrador para obtener permisos necesarios..!!');
                  return redirect('/');

                /*
                echo "Lo lamentamos no estas permitido loguearte en este sistema";
                  create a new user and provider
                  $user = User::firstOrCreate(
                      ['name' => $socialUser->name,
                       'email'    => $socialUser->email,
                       'Privilegio' => 'visor']
                  );

                  $user->socialProviders()->create(
                      ['provider_id' => $socialUser->id,
                       'provider' => $provider,
                       'avatarurl' => $socialUser->avatar]
                  );
                  */
                }
                else { //Si algo distinto a null le mando el siguiente mensaje

                  //echo "si existe info en tabla user_contratos<br>";

                  //Creo el metodo para guardarlo en la tabla social_providers_three
                  $user2=SocialProvider::create(
                      ['user_id' => $authUser->id,
                       'provider_id' => $socialUser->id,
                       'provider' => $provider,
                       'avatarurl' => $socialUser->avatar]
                  );
                  //Creo una consulta para saber si existe en la tabla user_reportes
                  $socialProvider2 = SocialProvider::where('provider_id', $socialUser->id)->first();

                  $user3 = $socialProvider2->user;
                  auth()->login($user3);
                  //notificationMsg('bienvenido', 'Gracias por Iniciar sesión.!!');
                  return redirect('/home');
                }

            }
            else {
              //echo 'Si ya esta registrado en la tabla de social_providers lo dejo pasar <bR>';
              $user = $socialProvider->user;
              auth()->login($user);
              //notificationMsg('bienvenido', 'Gracias por Iniciar sesión.!!');
              return redirect('/home');

            }
    }
}

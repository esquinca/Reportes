<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Mail;

use SNMP;

class mostapxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ap:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para capturar la mac, modelo de aps, ademas del numero de usuarios autentificados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    //  public function trySNMP($ip)
    //  {
    //     $boolean = 0;
    //     $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
    //     try {
    //       $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4'); //Model name
    //     } catch (\Exception $e) {
    //       $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
    //       return $boolean;
    //     }
    //     $session->close();
    //     return $boolean;
    //  }
      public function trySNMP($ip)
      {
        $boolean = 0;
        $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
        try {
          $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4'); //Model name
        } catch (\Exception $e) {
          if ( $session->getErrno() == SNMP::ERRNO_TIMEOUT ) {
            $boolean = 1;
          }
          return $boolean;
        }
        $session->close();
        return $boolean;
      }
     public function enviarC($correo, $nombre, $datos)
     {
       Mail::send('emailMensajes', $datos, function ($message) use ($correo, $nombre) {
           $message->to($correo, $nombre)->subject('Reportes Diarios - Problema Detectado');
       });
     }
    public function handle()
    {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');

      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->where('status' , '=', 1)->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior
      $this->info('Cantidad de registros= '.($contar_ip));

      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < ($contar_ip-1) ; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $boolean = $this->trySNMP($host);
        $this->info('Boolean = '.$boolean);

        if ($boolean === 0){
          $this->info('Ping successful!');
          $this->info('Hotel='.$zoneDirect_sql[$i]->id_hotel);

          $sessionA = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_aps_a".$i}= $sessionA->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4'); //Model name

          $sessionB = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_aps_b".$i}= $sessionB->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.15');//Total number of authenticated terminal which is using currently on this AP

          $sessionC = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_aps_c".$i}= $sessionC->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.1'); //MAC address

          $contar_aps_act= count(${"snmp_aps_a".$i}); //Cuento el tamaño del array anterior
          $this->info('CONTAR 1='.$contar_aps_act);

          DB::beginTransaction();
          for ($j=0; $j <= ($contar_aps_act-1); $j++) {
            $this->info('Entro al for!');

            $contar_param_1= count(${"snmp_aps_a".$i});
            $contar_param_2= count(${"snmp_aps_b".$i});
            $contar_param_3= count(${"snmp_aps_c".$i});
            if ( empty($contar_param_1) || empty($contar_param_2) || empty($contar_param_3)) {
              $this->info('No captura devuelven vacio!');
            }
            else
            {
              $this->info('Entro al else!');
              //Para el modelo de aps
              ${"snmp_aps_aa".$i}= explode(': ', ${"snmp_aps_a".$i} [key(${"snmp_aps_a".$i})]) ;
              next(${"snmp_aps_a".$i}); //Este es para que avance la key en el array

              // Total number of authenticated terminal which is using currently on this AP
              ${"snmp_aps_ab".$i}= explode(': ', ${"snmp_aps_b".$i} [key(${"snmp_aps_b".$i})]) ;
              next(${"snmp_aps_b".$i}); //Este es para que avance la key en el array

              //Para la mac de apache_get_modules
              ${"snmp_aps_ac".$i}= explode(': ', ${"snmp_aps_c".$i} [key(${"snmp_aps_c".$i})]) ;
              next(${"snmp_aps_c".$i}); //Este es para que avance la key en el array

              $modelo_actualizado= '';
              if ( empty(${"snmp_aps_aa".$i}[1])) {
                // $this->info('MODELO= Vacio');
                $modelo_actualizado= '';
              }
              else {
                // $this->info('MODELO='.${"snmp_aps_aa".$i}[1]);
                $modelo_actualizado= ${"snmp_aps_aa".$i}[1];
              }

              // $this->info('MAC='.${"snmp_aps_ac".$i}[1]);
              // $this->info('NumClientes='.${"snmp_aps_ab".$i}[1]);
              // $this->info('HOTEL='.$zoneDirect_sql[$i]->id_hotel);

              $sql = DB::table('MostAP')->insertGetId([
                'Fecha' => date('Y-m-d'),
                'MAC' => ${"snmp_aps_ac".$i}[1],
                'Modelo' => $modelo_actualizado,
                'NumClientes' => ${"snmp_aps_ab".$i}[1],
                'Mes' => $fmeses,
                'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
            }
          }
          DB::commit();
          $sessionA->close();
          $sessionB->close();
          $sessionC->close();
          //echo '///////////';
        }
        else {
          //Datos para el correo
          $hostcorreo = DB::table('CorreosZD')->select('Nombre_hotel', 'Correo', 'nombre_itc')->where('ip' , '=', $host)->get();
          $nombrehotel = $hostcorreo[0]->Nombre_hotel;
          $nombreit = $hostcorreo[0]->nombre_itc;
          $correoit = $hostcorreo[0]->Correo;
          $data = [
            'ip' => $host,
            'hotel' => $nombrehotel,
            'nombre' => $nombreit,
            'mensaje' => 'Favor de capturar el top 5 de ap&#8216;s de manera manual en el sistema de reportes. Los datos a capturar son pertenecientes al '
          ];
          $this->enviarC($correoit, $nombreit, $data);
          //echo $host;
        }
      }
        $this->info('Successfull registered aps!');
    }
}

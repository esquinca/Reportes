<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Mail;

use SNMP;

class roguedevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rougue:mes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar la informacion de devices rogue';

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
    public function trySNMP($ip)
    {
       $boolean = 0;
       $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
       try {
         $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1'); //Rogue device's MAC Address.
       } catch (\Exception $e) {
         $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
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
      $sumasreg=1;
      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $boolean = $this->trySNMP($host);
        if ($boolean === 0){
          //echo "successful!";

          //Peticiones snmp
          $sessionA = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_a".$i}= $sessionA->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1'); //Rogue device's MAC Address.

          $contar_reg= count(${"snmp_a".$i}); //Cuento el tamaño del array anterior

          $sessionB = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_b".$i}= $sessionB->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.4'); //Radio channel.

          $sessionC = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_c".$i}= $sessionC->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.3'); //Radio type.

          $sessionD = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_d".$i}= $sessionD->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2'); //SSID.

          DB::beginTransaction();

          for ($a=0; $a < $contar_reg; $a++) {
            //Para obtener la mac
            ${"snmp_aa".$i}= explode(': ', ${"snmp_a".$i}[key(${"snmp_a".$i})]);
            //Para obtener el radio channel
            ${"snmp_ab".$i}= explode(': ', ${"snmp_b".$i}[key(${"snmp_b".$i})]);
            //Para obtener el radio type
            ${"snmp_ac".$i}= explode(': ', ${"snmp_c".$i}[key(${"snmp_c".$i})]);

            $sql = DB::table('RogueDevices')->insertGetId([
              'MACRogue' => ${"snmp_aa".$i}[1],
              'ChannelRogue' => ${"snmp_ab".$i}[1],
              'TypeRogue' => ${"snmp_ac".$i}[1],
              'SSIDRogue' => ${"snmp_d".$i}[key(${"snmp_d".$i})],
              'Mes' => $fmeses,
              'hotels_id' => $zoneDirect_sql[$i]->id_hotel,
              'valor'=> $sumasreg
            ]);


              next(${"snmp_a".$i}); //Este es para que avance la key en el array
              next(${"snmp_b".$i}); //Este es para que avance la key en el array
              next(${"snmp_c".$i}); //Este es para que avance la key en el array
              next(${"snmp_d".$i}); //Este es para que avance la key en el array
          }
          $sessionA->close();
          $sessionB->close();
          $sessionC->close();
          $sessionD->close();

          DB::commit();
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
            'mensaje' => 'Favor de capturar los rogue devices de manera manual en el sistema de reportes. En caso que no tenga rogue devices, omita este mensaje. Los datos a capturar son pertenecientes al mes de '
          ];
          $this->enviarC($correoit, $nombreit, $data);
        //  echo $host;
        }
      }
        $this->info('Successfull registered rogue devices!');
    }
}

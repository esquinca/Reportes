<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Mail;

use SNMP;

class estadoserver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estado:server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para verificar el estado de las ip publicas';

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
    public function handle()
    {
      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior
      $boolean = 0;
      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $hostcorreo = DB::table('CorreosZD')->select('Nombre_hotel', 'Correo', 'nombre_itc')->where('ip' , '=', $host)->get();
        $nombrehotel = $hostcorreo[0]->Nombre_hotel;
        $nombreit = $hostcorreo[0]->nombre_itc;
        $correoit = $hostcorreo[0]->Correo;

        $data = [
          'ip' => $host,
          'hotel' => $nombrehotel,
          'nombre' => $nombreit
        ];
        //exec("ping -c 1 " . $host, $output, $result);
        $boolean = $this->trySNMP($host);

        if ($boolean === 0){
          //echo "Ping successful!";
          $sql_a= DB::table('zonedirect_ip')
            ->where('ip', '=', $host)
            ->update(['status' => 1]);
        }
        else {
          //echo "Ping unsuccessful!";
          $sql_b= DB::table('zonedirect_ip')
            ->where('ip', '=', $host)
            ->update(['status' => 0]);

          $this->enviarC($correoit, $nombreit, $data);
        }
      }
      $this->info('Updated ip address states successfully!');
    }

    public function trySNMP($ip)
    {
      $boolean = 0;
      $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
      try {
        //$res = $session->walk("1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2");
        $res = $session->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.1.1.4'); //Model name
      } catch (\Exception $e) {
        $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
        return $boolean;
      }
      $session->close();
      return $boolean;
    }

    public function enviarC($correo, $nombre, $datos)
    {
      Mail::send('email', $datos, function ($message) use ($correo, $nombre) {
          //$message->from('contactoweb@sitwifi.com', 'ContactoSitwifiWeb');
          $message->to($correo, $nombre)->subject('Reportes Diarios - Acceso denegado');
      });
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Mail;

use SNMP;

class usuarioxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuario:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar los usuarios por dia';

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
          $res = $session->walk("1.3.6.1.4.1.25053.1.2.1.1.1.15.2");//Number of authorized client devices.
        } catch (\Exception $e) {
          $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
          return $boolean;
        }
        $session->close();
        return $boolean;
     }
     public function enviarC($correo, $nombre, $datos)
     {
       Mail::send('emailMensajesdia', $datos, function ($message) use ($correo, $nombre) {
           $message->to($correo, $nombre)->subject('Reportes Diarios - Problema Detectado');
       });
     }
    public function handle()
    {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');
      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->where('status' , '=', 1)->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior
      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $boolean = $this->trySNMP($host);

        if ($boolean === 0){
          //echo "successful!";
          //echo $zoneDirect_sql[$i]->ip; //Ejemplo para ir obteniendo las posiciones una por una.

          //Datos para llenar la tabla UsuariosXDia
          //${"snmp_a".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumSta');// Number of authorized client devices
          //${"snmp_a".$i}= array_shift(${"snmp_a".$i});
          //${"snmp_a".$i}= explode(': ', ${"snmp_a".$i});
          //echo ${"snmp_a".$i}[1];// Number of authorized client devices sin tanto caracter

          $session = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          //${"snmp_a".$i}= $session->walk("RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumSta");
          ${"snmp_a".$i}= $session->walk("1.3.6.1.4.1.25053.1.2.1.1.1.15.2");
          ${"snmp_a".$i}= array_shift(${"snmp_a".$i});
          ${"snmp_a".$i}= explode(': ', ${"snmp_a".$i});
          //echo ${"snmp_a".$i}[1];// Number of authorized client devices sin tanto caracter
          //print_r($sysdescr);
          $session->close();

          //SQL USUARIOS POR DIA
          $sql = DB::table('UsuariosXDia')->insertGetId(['NumClientes' => ${"snmp_a".$i}[1], 'Fecha' => date('Y-m-d'), 'Mes' => $fmeses, 'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
        }
        else {
          //echo "unsuccessful!";
          //Datos para el correo
          $hostcorreo = DB::table('CorreosZD')->select('Nombre_hotel', 'Correo', 'nombre_itc')->where('ip' , '=', $host)->get();
          $nombrehotel = $hostcorreo[0]->Nombre_hotel;
          $nombreit = $hostcorreo[0]->nombre_itc;
          $correoit = $hostcorreo[0]->Correo;
          $data = [
            'ip' => $host,
            'hotel' => $nombrehotel,
            'nombre' => $nombreit,
            'mensaje' => 'Favor de capturar el número de dispositivos cliente autorizados de manera manual en el sistema de reportes. Los datos a capturar son pertenecientes al '
          ];
          $this->enviarC($correoit, $nombreit, $data);
        }
      }

      $this->info('Successfull registered users!');
    }
}

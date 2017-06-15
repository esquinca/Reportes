<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use SNMP;

class bytesxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bytes:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar los bytes transmitidos';

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
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');

      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->where('status', '=', 1)->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior

      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {

        $sessionA = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
        ${"snmp_bytes_trans_a".$i}= $sessionA->walk('1.3.6.1.4.1.25053.1.2.2.1.1.2.2.1.14'); //Transmitted Bytes

        //${"snmp_bytes_trans_a".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.2.2.1.14'); //Transmitted Bytes
        $contar_aps_act= count(${"snmp_bytes_trans_a".$i}); //Cuento el tamaño del array anterior

        for ($j=1; $j <= $contar_aps_act; $j++) {
        //echo key(${"snmp_aps_a".$i});

        //Para el Transmitted Bytes
        ${"snmp_bytes_transm_a".$i}= explode(': ', ${"snmp_bytes_trans_a".$i} [key(${"snmp_bytes_trans_a".$i})]) ;
        //echo ${"snmp_bytes_transm_a".$i}[1];
        next(${"snmp_bytes_trans_a".$i}); //Este es para que avance la key en el array
        //echo '-';

        $sql = DB::table('GBXDia')->insertGetId([
          'CantidadBytes' => ${"snmp_bytes_transm_a".$i}[1],
          'Fecha' => date('Y-m-d'),
          'Mes' => $fmeses,
          'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
        }
        $sessionA->close();
        //echo '///////////';
      }
      //return $contar_ip;
      $this->info('Successfull registered bytes!');
    }
}

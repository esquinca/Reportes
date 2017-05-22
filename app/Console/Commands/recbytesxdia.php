<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class recbytesxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rebytes:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar los bytes recibidos por ap';

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
          ${"snmp_bytes_trans_a".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.2.2.1.11'); //Received bytes ruckusZDWLANAPRadioStatsRxBytes
          $contar_aps_act= count(${"snmp_bytes_trans_a".$i}); //Cuento el tamaño del array anterior

          for ($j=1; $j <= $contar_aps_act; $j++) {
          //echo key(${"snmp_aps_a".$i});

          //Para el Received Bytes
          ${"snmp_bytes_transm_a".$i}= explode(': ', ${"snmp_bytes_trans_a".$i} [key(${"snmp_bytes_trans_a".$i})]) ;
          //echo ${"snmp_bytes_transm_a".$i}[1];
          next(${"snmp_bytes_trans_a".$i}); //Este es para que avance la key en el array
          //echo '-';

          $sql = DB::table('RByXDia')->insertGetId([
            'CantidadBytes' => ${"snmp_bytes_transm_a".$i}[1],
            'Fecha' => date('Y-m-d'),
            'Mes' => $fmeses,
            'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
          }
        }
        $this->info('Successfull registered bytes!');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

class wlanxdia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wlan:dia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para registrar las wlan con el numero de clientes';

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
        ${"snmp_wlan_a".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.1.1.1.1'); //Name of WLANS
        ${"snmp_wlan_b".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.1.1.1.12'); //Number of client devices

        $contar_wlan_act= count(${"snmp_wlan_a".$i}); //Cuento el tamaño del array anterior

        for ($j=1; $j <= $contar_wlan_act; $j++) {

            ${"snmp_wlan_aa".$i}= explode(': ', ${"snmp_wlan_a".$i}[key(${"snmp_wlan_a".$i})]);
            next(${"snmp_wlan_a".$i}); //Este es para que avance la key en el array

            ${"snmp_wlan_ab".$i}= explode(': ', ${"snmp_wlan_b".$i}[key(${"snmp_wlan_b".$i})]);
            next(${"snmp_wlan_b".$i}); //Este es para que avance la key en el array

          $sql = DB::table('WLAN')->insertGetId(['NombreWLAN' => ${"snmp_wlan_aa".$i}[1], 'ClientesWLAN' => ${"snmp_wlan_ab".$i}[1], 'Fecha' => date('Y-m-d'), 'Mes' => $fmeses, 'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
        }

      }
      $this->info('Successfull registered wlan!');
    }
}

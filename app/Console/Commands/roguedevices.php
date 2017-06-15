<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

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
    public function handle()
    {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');
      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->where('status' , '=', 1)->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior

      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {
        //${"snmp_a".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1'); //Rogue device's MAC Address.

        $sessionA = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
        ${"snmp_a".$i}= $sessionA->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1'); //Rogue device's MAC Address.

        $contar_reg= count(${"snmp_a".$i}); //Cuento el tamaño del array anterior

        //$cadena_a='iso.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.1.';//OID Mac Address
        //$cadena_b='iso.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.4.';//OID Radio Channel
        //$cadena_c='iso.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.3.';//OID Radio Type
        //$cadena_d='iso.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2.';//OID SSID

        $sessionB = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
        ${"snmp_b".$i}= $sessionB->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.4'); //Radio channel.

        $sessionC = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
        ${"snmp_c".$i}= $sessionC->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.3'); //Radio type.

        $sessionD = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
        ${"snmp_d".$i}= $sessionD->walk('1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2'); //SSID.

        //${"snmp_b".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.4'); //Radio channel.
        //${"snmp_c".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.3'); //Radio type.
        //${"snmp_d".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', '1.3.6.1.4.1.25053.1.2.2.1.1.4.1.1.2'); //SSID.

        DB::beginTransaction();

        for ($a=0; $a < $contar_reg; $a++) {

        /*
          Esto es igual a las keys
          $ex = $cadena_a . $a;//Concatenamos el oid de Mac Address
          $eya =$cadena_b . $a;//Concatenamos el oid de Radio Channel
          $eyb =$cadena_c . $a;//Concatenamos el oid de Radio Type
          $eyc =$cadena_d . $a;//Concatenamos el oid de SSID

          Osea esto xD
          [key(${"snmp_a".$i})]
          [key(${"snmp_b".$i})]
          [key(${"snmp_c".$i})]
          [key(${"snmp_d".$i})]

        */

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
            'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);

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
        $this->info('Successfull registered rogue devices!');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

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
    public function handle()
    {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');
      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->where('status' , '=', 1)->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior
      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {
        //echo $zoneDirect_sql[$i]->ip; //Ejemplo para ir obteniendo las posiciones una por una.

        //Datos para llenar la tabla UsuariosXDia
        ${"snmp_a".$i}= snmp2_real_walk($zoneDirect_sql[$i]->ip, 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumSta');// Number of authorized client devices
        ${"snmp_a".$i}= array_shift(${"snmp_a".$i});
        ${"snmp_a".$i}= explode(': ', ${"snmp_a".$i});
        //echo ${"snmp_a".$i}[1];// Number of authorized client devices sin tanto caracter

        //SQL USUARIOS POR DIA
        $sql = DB::table('UsuariosXDia')->insertGetId(['NumClientes' => ${"snmp_a".$i}[1], 'Fecha' => date('Y-m-d'), 'Mes' => $fmeses, 'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
      }
      $this->info('Successfull registered users!');
    }
}

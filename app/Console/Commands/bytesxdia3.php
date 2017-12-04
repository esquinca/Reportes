<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Mail;

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
     public function trySNMP($ip)
     {
        $boolean = 0;
        $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
        try {
          $res = $session->walk('1.3.6.1.4.1.25053.1.2.1.1.1.15.9'); //Transmitted Bytes
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
     public function trySNMPuptime($ip, $oid)
     {
        $boolean = 0;
        $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
        try {
          $cons_oid= DB::table('OID')->select('oid')->where('id', '=', $oid)->value('oid');
          $res = $session->walk($cons_oid); //Consultamos uptime
          $res_val= explode(': ', $res [key($res)]) ;
          return $res_val[1];
        }
         catch (\Exception $e) {
          $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
          return $boolean;
        }
        $session->close();
        return $boolean;
     }
     public function handle()
     {
       $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $fmeses= $meses[date('n')-1].' '.date('Y');

       $zoneDirect_sql= DB::table('zonedirect_ip')->select('id_zone','id_hotel','ip','Uptime')->where('status', '=', 1)->get(); //Retorna un array stdClass Object
       $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior

       //Creo un ciclo for para recorrer las posiciones del array
       for ($i=0; $i < $contar_ip ; $i++) {
         $host=$zoneDirect_sql[$i]->ip;
         $oid=$zoneDirect_sql[$i]->Uptime;
         $hotel=$zoneDirect_sql[$i]->id_hotel;
         $nzd=$zoneDirect_sql[$i]->id_zone;
         $boolean = $this->trySNMP($host);
         if ($boolean === 0){

           $verf_uptime = $this->trySNMPuptime($host, $oid);
           if($verf_uptime === false){
             echo 'No respondio mandamos correo';
           }
           else {
             //echo ($verf_uptime);
             $pos = strpos($verf_uptime, 'days');
             if ($pos === false) { //No se encontro la palabra days. Ejemplo de respuesta: (126791) 0:21:07.91
               $separarsindia= explode(" ", $verf_uptime);
               $separarhrs_segund_array = explode(":", $separarsindia[1]);
               $horas_transc = $separarhrs_segund_array[0];
               if ($horas_transc < 10) {
                 echo 'menor de 10 hrs mandamos correo';
               }
               else {
                 echo 'consumo aprobado**';
                 $this->registrarconsumos($host, $hotel, $nzd, 0);
                 //dd($verf_uptime);
               }
             }
             else { //Si se encontro la palabra days.Ejemplo de respuesta: (109425636) 12 days, 15:57:36.36
               $separarcantdia= explode(" ", $verf_uptime);
               $no_dias_array = $separarcantdia[1]; //Obtenemos la cantidad de dias.
               $this->registrarconsumos($host, $hotel, $nzd, $no_dias_array);
             }
           }
         }
         else {
           echo 'cuando no responde';
         }
       }
       $this->info('Successfull registered bytes!');
     }
     public function registrarconsumos($ip, $hotel, $nzd, $ndias)
     {
       $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
       $fmeses= $meses[date('n')-1].' '.date('Y');

       $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
       try {
         $consultar = $session->walk('1.3.6.1.4.1.25053.1.2.1.1.1.15.9'); //Transmitted Bytes
         $contar_aps_act= count($consultar);//Cuento el tamaño del array anterior
         DB::beginTransaction();
           for ($j=1; $j <= $contar_aps_act; $j++) {
             $separar_array= explode(': ', $consultar [key($consultar)]);

             $consulta_dia_actual= DB::table('GBXDia')->select('ConsumoReal')
             ->where('hotels_id', '=',$hotel)
             ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', DB::raw('MONTH(curdate())') )
             ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
             ->where( 'Captura' , '=', '1')
             ->where('ZD', '=', $nzd)
             ->orderBy('id', 'desc')
             ->take(1)
             ->value('ConsumoReal');

             $consulta_dia_anterior= DB::table('GBXDia')->select('ConsumoReal')
             ->where('hotels_id', '=',$hotel)
             ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', '11' )
             ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', '2017' )
             ->where( 'Captura' , '=', '1')
             ->where('ZD', '=', $nzd)
             ->orderBy('id', 'desc')
             ->value('ConsumoReal');

             dd($consulta_dia_anterior);
             //echo $consulta_dia_actual;
             if ($consulta_dia_actual == '') {
               echo '*bien';
             }
             else {
               echo 'No capturar';
             }

              if ($consulta_dia_ant != '') {//Si hay registro
               echo $consulta_dia_ant.'si hay';
              }
              else {//No hay registro del dia anterior
                echo $consulta_dia_ant.'no hay';
                // if ($ndias > 1) {
                //   echo 'Mandamos correo ya que no se registrara hasta reiniciar el zd';
                // }
                // else {
                //   $sql = DB::table('GBXDia')->insertGetId([
                //     'CantidadBytes' => $separar_array[1],
                //     'ConsumoReal' => $separar_array[1],
                //     'Fecha' => date('Y-m-d'),
                //     'Mes' => $fmeses,
                //     'hotels_id' => $hotel,
                //     'Captura' => '1',
                //     'ZD' =>  $nzd]);
                // }
              }
           }
         DB::commit();
       }
      catch (\Exception $e) {
         $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
         return $boolean;
      }
      $session->close();
     }





    public function handleorig()
    {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');

      $zoneDirect_sql= DB::table('zonedirect_ip')->select('ip','id_hotel')->where('status', '=', 1)->get(); //Retorna un array stdClass Object
      $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior

      //Creo un ciclo for para recorrer las posiciones del array
      for ($i=0; $i < $contar_ip ; $i++) {
        $host=$zoneDirect_sql[$i]->ip;
        $boolean = $this->trySNMP($host);
      //  $consulta_dia_ant= DB::table('GBXDia')->select('Nombre_hotel')->where('hotels_id', '=', $host)->value('Nombre_hotel');
       //Select MAX(ConsumoReal) From GBXDia Where hotels_id =
        if ($boolean === 0){

          $sessionA = new SNMP(SNMP::VERSION_2C, $zoneDirect_sql[$i]->ip, "public");
          ${"snmp_bytes_trans_a".$i}= $sessionA->walk('1.3.6.1.4.1.25053.1.2.1.1.1.15.9'); //Transmitted Bytes
          $contar_aps_act= count(${"snmp_bytes_trans_a".$i}); //Cuento el tamaño del array anterior

          DB::beginTransaction();
          for ($j=1; $j <= $contar_aps_act; $j++) {
            ${"snmp_bytes_transm_a".$i}= explode(': ', ${"snmp_bytes_trans_a".$i} [key(${"snmp_bytes_trans_a".$i})]) ;

            // Para el Transmitted Bytes
            $consulta_dia_ant= DB::table('GBXDia')->select('ConsumoReal')
            ->where('hotels_id', '=',$zoneDirect_sql[$i]->id_hotel)
            ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', DB::raw('MONTH(curdate())') )
            ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
            ->where( 'Captura' , '=', '1')
            ->orderBy('id', 'desc')
            ->take(1)
            ->value('ConsumoReal');

          //
          if ($consulta_dia_ant == '') {
            $ultima_fecha= DB::table('GBXDia')->select('Fecha')->where('hotels_id', '=',$zoneDirect_sql[$i]->id_hotel)->where( 'Captura' , '=', '1')->orderBy('id', 'desc')->take(1)->value('Fecha');
            $date_bd_year = date("Y", strtotime($ultima_fecha));
            $date_bd_mes = date("m", strtotime($ultima_fecha));
            $date_year_act=date("Y");
            $date_mes_act=date("M");

            if ($date_year_act > $date_bd_year) {
              if ($date_bd_mes > $date_mes_act) {
                $nueva_consulta_dia_ant= DB::table('GBXDia')->select('ConsumoReal')
                ->where('hotels_id', '=',$zoneDirect_sql[$i]->id_hotel)
                ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', $date_bd_mes )
                ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', $date_bd_year)
                ->where( 'Captura' , '=', '1')
                ->orderBy('id', 'desc')
                ->take(1)
                ->value('ConsumoReal');

                if (${"snmp_bytes_transm_a".$i}[1] > $nueva_consulta_dia_ant  ) {
                  $nuevo= ${"snmp_bytes_transm_a".$i}[1] - $nueva_consulta_dia_ant;
                }
                else {
                  $nuevo= ${"snmp_bytes_transm_a".$i}[1];
                }
              }
            }
            if ($date_year_act == $date_bd_year) {
              if ($date_mes_act > $date_bd_mes) {
                $nueva_consulta_dia_ant= DB::table('GBXDia')->select('ConsumoReal')
                ->where('hotels_id', '=',$zoneDirect_sql[$i]->id_hotel)
                ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', $date_bd_mes )
                ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
                ->where( 'Captura' , '=', '1')
                ->orderBy('id', 'desc')
                ->take(1)
                ->value('ConsumoReal');
                if (${"snmp_bytes_transm_a".$i}[1] > $nueva_consulta_dia_ant  ) {
                  $nuevo= ${"snmp_bytes_transm_a".$i}[1] - $nueva_consulta_dia_ant;
                }
                else {
                  $nuevo= ${"snmp_bytes_transm_a".$i}[1];
                }
              }
            }
          }
          else{
            $nueva_consulta_dia_ant=$consulta_dia_ant;
            if (${"snmp_bytes_transm_a".$i}[1] > $nueva_consulta_dia_ant  ) {
              $nuevo= ${"snmp_bytes_transm_a".$i}[1] - $nueva_consulta_dia_ant;
            }
            else {
              $nuevo= ${"snmp_bytes_transm_a".$i}[1];
            }
          }

          //echo ${"snmp_bytes_transm_a".$i}[1];

          next(${"snmp_bytes_trans_a".$i}); //Este es para que avance la key en el array

          $sql = DB::table('GBXDia')->insertGetId([
            'CantidadBytes' => $nuevo,
            'ConsumoReal' => ${"snmp_bytes_transm_a".$i}[1],
            'Fecha' => date('Y-m-d'),
            'Mes' => $fmeses,
            'Captura' => '1',
            'hotels_id' => $zoneDirect_sql[$i]->id_hotel]);
          }
          DB::commit();
          $sessionA->close();
        }
        else {
          // //Datos para el correo
          // $hostcorreo = DB::table('CorreosZD')->select('Nombre_hotel', 'Correo', 'nombre_itc')->where('ip' , '=', $host)->get();
          // $nombrehotel = $hostcorreo[0]->Nombre_hotel;
          // $nombreit = $hostcorreo[0]->nombre_itc;
          // $correoit = $hostcorreo[0]->Correo;
          // $data = [
          //   'ip' => $host,
          //   'hotel' => $nombrehotel,
          //   'nombre' => $nombreit,
          //   'mensaje' => 'Favor de capturar el número de Gigabytes transmitidos en 24hrs de manera manual en el sistema de reportes. Los datos a capturar son pertenecientes al '
          // ];
          // $this->enviarC($correoit, $nombreit, $data);
        }
      }
      $this->info('Successfull registered bytes!');
    }
}

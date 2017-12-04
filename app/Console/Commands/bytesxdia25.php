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
            //  $pos = strpos($verf_uptime, 'day');
             //dd($verf_uptime);
             $datahora= '(126791) 2 days, 15:57:36.36';
             $pos = strpos($datahora, 'day');
             if ($pos === false) { //No se encontro la palabra days. Ejemplo de respuesta: (126791) 0:21:07.91
               $separarsindia= explode(" ", $verf_uptime);
               $separarhrs_segund_array = explode(":", $separarsindia[1]);
              //  $horas_transc = $separarhrs_segund_array[0];
               $horas_transc = 11;//comentamos
               if ($horas_transc < 10) { //cambiarlo <
                 echo 'menor de 10 hrs mandamos correo';
               }
               else {
                 echo 'Metodo 1- ';
                 $this->registrarconsumos($host, $hotel, $nzd, 0);
                 //dd($verf_uptime);
               }
             }
             else { //Si se encontro la palabra days.Ejemplo de respuesta: (109425636) 12 days, 15:57:36.36
               echo "----";
               echo "encontro day";
               $separarcantdia= explode(" ", $datahora);
               //$separarcantdia= explode(" ", $verf_uptime);
               $no_dias_array = $separarcantdia[1]; //Obtenemos la cantidad de dias.
               $this->registrarconsumos($host, $hotel, $nzd, $no_dias_array);
              //echo 'xsss';
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

             //Verificamos si el dia actual esta registrado
             $consultamos_dia_now= DB::table('GBXDia')->select('Fecha')
               ->where('hotels_id', '=',$hotel)
               ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', DB::raw('MONTH(curdate())') )
               ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
               ->where( DB::raw('DAY(GBXDia.Fecha)') , '=', DB::raw('DAY(curdate())') )
               ->where( 'Captura' , '=', '1')
               ->where('ZD', '=', $nzd)
               ->orderBy('id', 'desc')
               ->take(1)
               ->value('Fecha');
             if ($consultamos_dia_now == '' || $consultamos_dia_now == 'null') {
               //echo "No registrado de forma automatica el dia de hoy";
              //  echo $consultamos_dia_now;
                //Recuperamos el ultimo consumo registrado.
                $consulta_dia_actual= DB::table('GBXDia')->select('Fecha','ConsumoReal')
                   ->where('hotels_id', '=',$hotel)
                   ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', DB::raw('MONTH(curdate())') )
                   ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
                   ->where( 'Captura' , '=', '1')
                   ->where('ZD', '=', $nzd)
                   ->orderBy('id', 'desc')
                   ->take(1)
                   ->get();
                   /*
                   dd($consulta_dia_actual);
                   array:1 [
                      0 => {#703
                        +"Fecha": "2017-12-02"
                        +"ConsumoReal": 1683689475
                      }
                    ]
                   */
                if(empty($consulta_dia_actual)){
                  //echo 'NO ENCUENTRA REGISTRO ANTERIOR DE ESTE MES, Insertamos como dia uno';
                  if ($ndias <= 1) {
                    echo "----------";
                    echo "inserto como dia 1";
                    $sql = DB::table('GBXDia')->insertGetId([
                          'CantidadBytes' => $separar_array[1],
                          'ConsumoReal' => $separar_array[1],
                          'Fecha' => date('Y-m-d'),
                          'Mes' => $fmeses,
                          'hotels_id' => $hotel,
                          'Captura' => '1',
                          'ZD' => $nzd]);
                    //dd($consulta_dia_actual);
                  }
                  else {
                    echo $ndias;
                  }
                }
                else {
                  //Encuentra registro de este mes
                  //Pero el numero del zd es 0 dias
                  if ($ndias == 0) {
                    echo "----------";
                    echo "inserto como dia 1";
                    $sql = DB::table('GBXDia')->insertGetId([
                          'CantidadBytes' => $separar_array[1],
                          'ConsumoReal' => $separar_array[1],
                          'Fecha' => date('Y-m-d'),
                          'Mes' => $fmeses,
                          'hotels_id' => $hotel,
                          'Captura' => '1',
                          'ZD' => $nzd]);
                    //dd($consulta_dia_actual);
                  }
                  //if ($ndias == 1) {
                  else{
                    echo "----------";
                    echo "inserto como dia 2";echo "----------";
                    echo $ultimo_consumo_registrado = $consulta_dia_actual[0]->ConsumoReal;
                    echo "----------";
                    echo $separar_array[1];
                    echo "----------";
                    if ($separar_array[1] > $ultimo_consumo_registrado  ) {
                       echo $nuevo_consumo= $separar_array[1] - $ultimo_consumo_registrado;
                    }
                    else {
                       echo $nuevo_consumo=$separar_array[1];
                    }
                    echo "----------";
                    //dd($consulta_dia_actual);
                  }
                }
             }
             else {
               echo "Dia actual ya registrado de forma automatica";
             }

              //Verificamos si el dia actual esta registrado
            //  $consulta_dia_actual= DB::table('GBXDia')->select('ConsumoReal')
            //    ->where('hotels_id', '=',$hotel)
            //    ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', DB::raw('MONTH(curdate())') )
            //    ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
            //    ->where( 'Captura' , '=', '1')
            //    ->where('ZD', '=', $nzd)
            //    ->orderBy('id', 'desc')
            //    ->take(1)
            //    ->value('ConsumoReal');
            //
            //  if ($consulta_dia_actual == '') { //No hay registro del dia actual
            //    echo '--entroXD';
            //    $fecha_ult_reg =  DB::table('GBXDia')->select('Fecha')
            //      ->where('hotels_id', '=',$hotel)
            //      ->where('Captura' , '=', '1')
            //      ->where('ZD', '=', $nzd)
            //      ->orderBy('id', 'desc')
            //      ->take(1)
            //      ->value('Fecha');
            //     if ($fecha_ult_reg == '') {//NO HAY FECHA O REGISTRO ANTERIOR
            //       if ($ndias > 1) {
            //         echo 'Para poder registrar de manera automatica necesitamos que reinicies el zd';
            //       }
            //       else{
            //         $sql = DB::table('GBXDia')->insertGetId([
            //         'CantidadBytes' => $separar_array[1],
            //         'ConsumoReal' => $separar_array[1],
            //         'Fecha' => date('Y-m-d'),
            //         'Mes' => $fmeses,
            //         'hotels_id' => $hotel,
            //         'Captura' => '1',
            //         'ZD' => $nzd]);
            //       }
            //     }
            //     else {//SI HAY FECHA O REGISTRO ANTERIOR
            //      //Obtenemos el año y mes de la ultima fecha
            //      $years_ult_reg = date("Y", strtotime($fecha_ult_reg));
            //      $month_ult_reg= date("m", strtotime($fecha_ult_reg));
            //      $years_current=date("Y");
            //      $month_current=date("m");
            //
            //      if ($years_current > $years_ult_reg) { //Indica que cambiamos de año
            //        if ($month_ult_reg > $month_current) { //Si el ult. registro es mayor q el actual
            //          //Consultamos el consumo del año y mes anterior
            //          $consumo_ult = DB::table('GBXDia')->select('ConsumoReal')
            //            ->where('hotels_id', '=',$hotel)
            //            ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', $month_ult_reg )
            //            ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', $years_ult_reg)
            //            ->where( 'Captura' , '=', '1')
            //            ->where('ZD', '=', $nzd)
            //            ->orderBy('id', 'desc')
            //            ->take(1)
            //            ->value('ConsumoReal');
            //          if ($separar_array[1] > $consumo_ult  ) {
            //            $nuevo= $separar_array[1] - $consumo_ult;
            //          }
            //          else {
            //            $nuevo=$separar_array[1];
            //          }
            //        }
            //      }
            //      if ($years_current == $years_ult_reg) { //Indicamos que estamos en el mismo año
            //        if ($month_current > $month_ult_reg) { //Si el ult. registro es menor q el mes actual
            //          //Consultamos el ConsumoReal del año actual y mes anterior
            //          $consumo_ult = DB::table('GBXDia')->select('ConsumoReal')
            //            ->where('hotels_id', '=',$hotel)
            //            ->where( DB::raw('MONTH(GBXDia.Fecha)') , '=', $month_ult_reg )
            //            ->where( DB::raw('YEAR(GBXDia.Fecha)') , '=', DB::raw('YEAR(curdate())') )
            //            ->where( 'Captura' , '=', '1')
            //            ->where('ZD', '=', $nzd)
            //            ->orderBy('id', 'desc')
            //            ->take(1)
            //            ->value('ConsumoReal');
            //          if ($separar_array[1] > $consumo_ult) {
            //              $nuevo = $separar_array[1] - $consumo_ult;
            //          }
            //          else {
            //              $nuevo= $separar_array[1];
            //          }
            //          //echo 'cambio de mes';
            //        }
            //      }
            //      next($separar_array); //Este es para que avance la key en el array
            //
            //      $sql = DB::table('GBXDia')->insertGetId([
            //      'CantidadBytes' => $nuevo,
            //      'ConsumoReal' => $separar_array[1],
            //      'Fecha' => date('Y-m-d'),
            //      'Mes' => $fmeses,
            //      'hotels_id' => $hotel,
            //      'Captura' => '1',
            //      'ZD' => $nzd]);
            //     }
            //  }
            //  else {
            //    echo '--Ya capturo hoy, No volver a capturar';
            //  }
           }
         DB::commit();
       }
       catch (\Exception $e) {
         $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
         return $boolean;
       }
       $session->close();
     }


}

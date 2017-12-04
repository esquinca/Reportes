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
     public function enviarMailByte($host, $msj, $subject)
     {
       //Datos para el correo
       $hostcorreo = DB::table('CorreosZD')->select('Nombre_hotel', 'Correo', 'nombre_itc')->where('ip' , '=', $host)->get();
       $nombrehotel = $hostcorreo[0]->Nombre_hotel;
       $nombre = $hostcorreo[0]->nombre_itc;
       $correo = $hostcorreo[0]->Correo;
       $datos = [
         'tema' => $subject,
         'ip' => $host,
         'hotel' => $nombrehotel,
         'nombre' => $nombre,
         'mensaje' => $msj,
       ];
       Mail::send('emailMensajesBytes', $datos, function ($message) use ($correo, $nombre) {
           $copias=['acauich@sitwifi.com','gramirez@sitwifi.com','jesquinca@sitwifi.com'];
           $message->to($correo, $nombre)->bcc($copias,'Auto copia')->subject("Anuncio importante..!!!");
           //$message->to('sonick.stark1@gmail.com', $nombre)->bcc($copias,'Auto copia')->subject("Anuncio importante..!!!");
       });
     }
     public function enviarMailByteAdmin($host, $msj, $subject)
     {
       //Datos para el correo
       $hostcorreo = DB::table('CorreosZD')->select('Nombre_hotel', 'Correo', 'nombre_itc')->where('ip' , '=', $host)->get();
       $nombrehotel = $hostcorreo[0]->Nombre_hotel;
       $nombreit = $hostcorreo[0]->nombre_itc;
       $correo = $hostcorreo[0]->Correo;
       $datos = [
         'ip' => $host,
         'hotel' => $nombrehotel,
         'nombre' => $nombreit,
         'mensaje' => $msj,
       ];
       $copias=['acauich@sitwifi.com','gramirez@sitwifi.com','jesquinca@sitwifi.com'];
       $nombre='Administrador';
       Mail::send('emailMensajesBytesAdmin', $datos, function ($message) use ($copias, $nombre) {
           $copias=['acauich@sitwifi.com','gramirez@sitwifi.com','jesquinca@sitwifi.com'];
           $message->to($copias, $nombre)->subject('Dar prioridad');
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
     public function trySNMPbytes($ip)
     {
       $boolean = 0;
       $session = new SNMP(SNMP::VERSION_2C, $ip, "public");
       try {
         $res = $session->walk('1.3.6.1.4.1.25053.1.2.1.1.1.15.9'); //Transmitted Bytes
         $da= explode(': ', $res [key($res)]);
         return $da[1];
       } catch (\Exception $e) {
         $boolean = $session->getErrno() == SNMP::ERRNO_TIMEOUT;
         return $boolean;
       }
       $session->close();
       return $boolean;
     }
     public function operacionempty($hotel, $nzd, $host, $ndias)
     {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');
      $consultar_ult_reg = DB::table('GBXDia')
                            ->select('Fecha','ConsumoReal','days')
                            ->where( 'Captura' , '=', '1')
                            ->where('hotels_id','=', $hotel)
                            ->where('ZD', '=', $nzd)
                            ->where('days','<>', NULL)
                            ->orderBy('id', 'desc')
                            ->take(1)
                            ->get();
      $fecha_anio_act=date("Y");
      $fecha_mes_act=date("m");
      $consumoreal = $this->trySNMPbytes($host);
      if (empty($consultar_ult_reg)) { // No existe el ultimo registro
        if ($ndias <= 1) { //Aprobado por que cumple mas de 15 hrs
          $sal_reg= DB::table('GBXDia')->insertGetId([
            'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
            'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
          ]);
        }
        else{
          $tema="Advertencia..!!!";
          $msj= "No se ha registrado información de GB, hasta que reinicie el ZD";
          $this->enviarMailByte($host, $msj, $tema);
        }
      }
      else { // Si hay registro del dia anterior
        $cont_ult_reg_fecha= $consultar_ult_reg[0]->Fecha;
        $cont_ult_reg_consumo = $consultar_ult_reg[0]->ConsumoReal;
        $cont_ult_reg_days = $consultar_ult_reg[0]->days;

        $cont_ult_reg_f_year = date("Y", strtotime($cont_ult_reg_fecha));
        $cont_ult_reg_f_month = date("m", strtotime($cont_ult_reg_fecha));

        if ($fecha_anio_act == $cont_ult_reg_f_year) { //Si el ultimo año registrado es igual al año actual
          if ($fecha_mes_act > $cont_ult_reg_f_month) { //Si el mes actual es mayor al ulti. reg de bd. Entonces avanzamos un mes 1 (Pasamos a otro mes)
            if ($ndias <= 1) { //Si ndias es menor o igual a 1 registramos directo
              $sal_reg= DB::table('GBXDia')->insertGetId([
                'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
                'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
              ]);
            }
            else { //Si es mayor a uno
              if($cont_ult_reg_days < $ndias){ //Si el ultimo registro de dias es menor a ndias(No se a reiniciado zd)
                if ($consumoreal < $cont_ult_reg_consumo) {
                  $NcantidadBytes=$consumoreal;
                }
                else{
                  $NcantidadBytes=$consumoreal-$cont_ult_reg_consumo;
                }
                $sal_reg= DB::table('GBXDia')->insertGetId([
                  'CantidadBytes' => $NcantidadBytes,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
                  'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
                ]);
              }
            }
          }
          if ($fecha_mes_act == $cont_ult_reg_f_month){//Si el mes actual es igual al ulti. reg de bd. Entonces estamos en el mismo mes
            if ($ndias <= 1) { //Si ndias es menor o igual a 1 registramos directo
              $sal_reg= DB::table('GBXDia')->insertGetId([
                'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
                'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
              ]);
            }
            else {
              if ($cont_ult_reg_days < $ndias) {
                if ($consumoreal < $cont_ult_reg_consumo) {
                  $NcantidadBytes=$consumoreal;
                }
                else {
                  $NcantidadBytes=$consumoreal-$cont_ult_reg_consumo;
                }
              }
              $sal_reg= DB::table('GBXDia')->insertGetId([
                'CantidadBytes' => $NcantidadBytes,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
                'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
              ]);
            }
          }
        }
        if ($fecha_anio_act > $cont_ult_reg_f_year) { //Si el ultimo año registrado es menor al año actual (Cambiamos de año)
          if ($cont_ult_reg_f_month > $fecha_mes_act) {//Si el mes registrado es mayor al mes actual
            if ($ndias <= 1) {
              $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
              ]);
            }
            else {
              if ($cont_ult_reg_days < $ndias) {
                if ($consumoreal<$cont_ult_reg_consumo) {
                  $NcantidadBytes=$consumoreal;
                }
                else {
                  $NcantidadBytes=$consumoreal-$cont_ult_reg_consumo;
                }
              }
              $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $NcantidadBytes,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
              ]);
            }
          }
        }
      }
     }
     public function operacion($hotel, $nzd, $host, $ndias)
     {
      $meses= array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $fmeses= $meses[date('n')-1].' '.date('Y');
      $consultar_ult_reg = DB::table('GBXDia')
                            ->select('Fecha','ConsumoReal','days')
                            ->where( 'Captura' , '=', '1')
                            ->where('hotels_id','=', $hotel)
                            ->where('ZD', '=', $nzd)
                            ->where('days','<>', NULL)
                            ->orderBy('id', 'desc')
                            ->take(1)
                            ->get();
      $cont_ult_reg_fecha= $consultar_ult_reg[0]->Fecha;
      $cont_ult_reg_consumo = $consultar_ult_reg[0]->ConsumoReal;
      $cont_ult_reg_days = $consultar_ult_reg[0]->days;

      $cont_ult_reg_f_year = date("Y", strtotime($cont_ult_reg_fecha));
      $cont_ult_reg_f_month = date("m", strtotime($cont_ult_reg_fecha));
      $fecha_anio_act=date("Y");
      $fecha_mes_act=date("m");
      $consumoreal = $this->trySNMPbytes($host);

      if ($fecha_anio_act == $cont_ult_reg_f_year) { //Si el ultimo año registrado es igual al año actual
        if ($fecha_mes_act > $cont_ult_reg_f_month) { //Si el mes actual es mayor al ulti. reg de bd. Entonces avanzamos un mes 1 (Pasamos a otro mes)
          if ($ndias <= 1) { //Si ndias es menor o igual a 1 registramos directo
            $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
            ]);
          }
          else { //Si es mayor a uno
            if($cont_ult_reg_days < $ndias){ //Si el ultimo registro de dias es menor a ndias(No se a reiniciado zd)
              if ($consumoreal < $cont_ult_reg_consumo) {
                $NcantidadBytes=$consumoreal;
              }
              else{
                $NcantidadBytes=$consumoreal-$cont_ult_reg_consumo;
              }
              $sal_reg= DB::table('GBXDia')->insertGetId([
                'CantidadBytes' => $NcantidadBytes,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
                'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
              ]);
            }
          }
        }
        if ($fecha_mes_act == $cont_ult_reg_f_month){//Si el mes actual es igual al ulti. reg de bd. Entonces estamos en el mismo mes
          if ($ndias <= 1) { //Si ndias es menor o igual a 1 registramos directo
            $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
            ]);
          }
          else {
            if ($cont_ult_reg_days < $ndias) {
              if ($consumoreal < $cont_ult_reg_consumo) {
                $NcantidadBytes=$consumoreal;
              }
              else {
                $NcantidadBytes=$consumoreal-$cont_ult_reg_consumo;
              }
            }
            $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $NcantidadBytes,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
            ]);
          }
        }
      }
      if ($fecha_anio_act > $cont_ult_reg_f_year) { //Si el ultimo año registrado es menor al año actual (Cambiamos de año)
        if ($cont_ult_reg_f_month > $fecha_mes_act) {//Si el mes registrado es mayor al mes actual
          if ($ndias <= 1) {
            $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $consumoreal,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
            ]);
          }
          else {
            if ($cont_ult_reg_days < $ndias) {
              if ($consumoreal<$cont_ult_reg_consumo) {
                $NcantidadBytes=$consumoreal;
              }
              else {
                $NcantidadBytes=$consumoreal-$cont_ult_reg_consumo;
              }
            }
            $sal_reg= DB::table('GBXDia')->insertGetId([
              'CantidadBytes' => $NcantidadBytes,'ConsumoReal' => $consumoreal,'Fecha' => date('Y-m-d'),'Mes' => $fmeses,
              'hotels_id' => $hotel,'Captura' => '1','ZD' => $nzd,'days' => $ndias
            ]);
          }
        }
      }
     }
     public function handle()
     {
       $zoneDirect_sql= DB::table('zonedirect_ip')->select('id_zone','id_hotel','ip','Uptime')->where('status', '=', 1)->get(); //Retorna un array stdClass Object
       $contar_ip= count($zoneDirect_sql); //Cuento el tamaño del array anterior

       //Creo un ciclo for para recorrer las posiciones del array
       for ($i=0; $i < $contar_ip ; $i++) {
         $host=$zoneDirect_sql[$i]->ip;
         $oid=$zoneDirect_sql[$i]->Uptime;
         $hotel=$zoneDirect_sql[$i]->id_hotel;
         $nzd=$zoneDirect_sql[$i]->id_zone;
         $boolean = $this->trySNMP($host);
         $ndias=0;
         if ($boolean === 0){
           $RespondeUptime = $this->trySNMPuptime($host, $oid);

           if ($RespondeUptime != false && $RespondeUptime != 1 ) {
             //echo $RespondeUptime;
             $buscarday = strpos($RespondeUptime, 'day');
             if ($buscarday === false) {
               echo "La palabra day no fue encontrada";
               $separarbuscarday = explode(" ", $RespondeUptime);
               $separarbuscarhrs = explode(":", $separarbuscarday[1]);
               $hora_extraida = $separarbuscarhrs[0];
               if ($hora_extraida < 10) {
                 $subject="Advertencia..!!!";
                 $msj= "No es posible registrar un consumo de menos de 10 horas";
                 $this->enviarMailByte($host, $msj, $subject);
               }
               else {
                 //echo '2--';
                 $this->operacionempty($hotel, $nzd, $host, $ndias);
               }
            }
            else {
               echo "La palabra day fue encontrada";
               $separarbuscarday = explode(" ", $RespondeUptime);
               $dias_extraida = $separarbuscarday[1];
               $ndias = $dias_extraida;
               $this->operacionempty($hotel, $nzd, $host, $ndias);
              //dd($RespondeUptime);
            }
           }
           else if ($RespondeUptime === false) {
             //echo 'OID & TIPO DE ZD MAL ASIGNADO';
             $subject="Peligro..!!!";
             $msj= "OID -> TIPO DE ZD MAL ASIGNADO";
             $this->enviarMailByteAdmin($host, $msj, $subject);
           }
           else if ($RespondeUptime == 1) {
             $subject="Advertencia..!!!";
             $msj= "No es posible establecer una comunicación con el equipo";
             $this->enviarMailByte($host, $msj, $subject);
             echo 'No responde ZD';
           }
         }
         else {
           $subject="Advertencia..!!!";
           $msj= "No es posible establecer una comunicación con el equipo";
           $this->enviarMailByte($host, $msj, $subject);
           //echo 'No responde ZD';
          $boolean;
         }
       }
       $this->info('Successfull registered bytes!');
     }
}

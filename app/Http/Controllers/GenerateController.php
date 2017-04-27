<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class GenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ID = Auth::user()->id;
        $correo = Auth::user()->email;
        $priv = Auth::user()->Privilegio;

        if($priv == 'Cliente'){
            $exitecliente= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            if ($exitecliente != 0) {
                /*SI existe*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
                return view('generate.generate', compact('selectDatahotel'));
            }
        }
        if($priv == 'IT'){
            $exiteClienteVer= DB::table('hotels')->where('CorreoSistemas', $correo)->count();
            if ($exiteClienteVer != 0) {
                /*SI existe este en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('CorreoSistemas', '=', $correo)->orderBy('id', 'asc')->get();
                return view('generate.generate', compact('selectDatahotel'));
            }
            else {
                /*SI existe no existe en la lista de clientes*/
                $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->where('user_reportes_id', '=', $ID)->orderBy('id', 'asc')->get();
                return view('generate.generate', compact('selectDatahotel'));
            }
        }
        if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
            $selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
            return view('generate.generate', compact('selectDatahotel'));
        }
    }

    public function rdata(Request $request)
    {
      $id = $request->ident;
      $countreg= DB::table('zonedirect_ip')->where('id_hotel', '=', $id)->count();
      $address_ip= DB::table('zonedirect_ip')->where('id_hotel', '=', $id)->pluck('ip');


      for ($i=0; $i < $countreg; $i++) {
        //System Name
         ${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemName');//Nombre del sistema
         ${"snmp_a".$i}= array_shift(${"snmp_a".$i});
         ${"snmp_a".$i}= explode(': ', ${"snmp_a".$i});
         echo ${"snmp_a".$i}[1];// Nombre sin tanto caracter
         echo "/";
         
         ${"snmp_b".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemIPAddr');//IP del sistema
         ${"snmp_b".$i}= array_shift(${"snmp_b".$i});
         ${"snmp_b".$i}= explode(': ', ${"snmp_b".$i});
         echo ${"snmp_b".$i}[1];// IP del sistema sin tanto caracter
         echo "/";
         
         ${"snmp_c".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemMacAddr');// MAC
         ${"snmp_c".$i}= array_shift(${"snmp_c".$i});
         ${"snmp_c".$i}= explode(': ', ${"snmp_c".$i});
         echo ${"snmp_c".$i}[1];// MAC sin tanto caracter
         echo "/";
         
         ${"snmp_d".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemModel');// Model
         ${"snmp_d".$i}= array_shift(${"snmp_d".$i});
         ${"snmp_d".$i}= explode(': ', ${"snmp_d".$i});
         echo ${"snmp_d".$i}[1];// Model sin tanto caracter
         echo "/";
         
         ${"snmp_e".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumAP');// Number of APs
         ${"snmp_e".$i}= array_shift(${"snmp_e".$i});
         ${"snmp_e".$i}= explode(': ', ${"snmp_e".$i});
         echo ${"snmp_e".$i}[1];// Number of APs sin tanto caracter
         echo "/";
         
         ${"snmp_f".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumSta');// Number of authorized client devices
         ${"snmp_f".$i}= array_shift(${"snmp_f".$i});
         ${"snmp_f".$i}= explode(': ', ${"snmp_f".$i});
         echo ${"snmp_f".$i}[1];// Number of authorized client devices sin tanto caracter
         echo "/";
         
         ${"snmp_g".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumRogue');// Number of rogue device
         ${"snmp_g".$i}= array_shift(${"snmp_g".$i});
         ${"snmp_g".$i}= explode(': ', ${"snmp_g".$i});
         echo ${"snmp_g".$i}[1];//Number of rogue device sin tanto caracter
         echo "/";
         
         ${"snmp_h".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsAllNumSta');//NUmber of All client devices
         ${"snmp_h".$i}= array_shift(${"snmp_h".$i});
         ${"snmp_h".$i}= explode(': ', ${"snmp_h".$i});
         echo ${"snmp_h".$i}[1];//NUmber of All client devices sin tanto caracter
         echo "/";
         
/*
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemIPAddr'));//IP del sistema
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemMacAddr'));//MAC
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemUptime'));//uptime
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemModel'));//Model
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemLicensedAPs'));//Licensed APS
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemMaxSta'));//Max Stations

        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemSerialNumber'));//Serial Number

        //Devices Overview
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumAP'));//Number of APs
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumSta'));//Number of authorized client devices
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumRogue'));//Number of rogue device
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsAllNumSta'));//NUmber of All client devices
*/
      }
      /*
      $snm= snmp2_real_walk('172.200.0.2', 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemName');
      print_r($snm);
      */
      return $countreg;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

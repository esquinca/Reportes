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
        print_r(${"snmp_a".$i}= snmp2_real_walk($address_ip[$i], 'public', 'RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemName'));//Nombre del sistema
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

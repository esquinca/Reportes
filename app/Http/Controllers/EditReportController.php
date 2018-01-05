<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\RedirectResponse;

use Auth;

use DB;

use Image;

use File;

use Location;

use Carbon;

class EditReportController extends Controller
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
          return view('editreport.editreport');
      }
      if($priv == 'IT'){
          $selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('IDUsuario', '=', $ID)->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
          return view('editreport.editreport', compact('selectDatahotel'));
      }
      if ($priv == 'Admin' || $priv == 'Helpdesk' || $priv == 'Programador') {
          //$selectDatahotel = DB::table('hotels')->select('id','Nombre_hotel')->orderBy('id', 'asc')->get();
          $selectDatahotel = DB::table('HotelUserReport')->select('IDHotels','Nombre_hotel')->where('IDUsuario', '!=', '38')->where('IDUsuario', '!=', '1')->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')->orderBy('IDHotels', 'asc')->get();
          return view('editreport.editreport', compact('selectDatahotel'));
      }
    }
    public function searchzd(Request $request)
    {
      $id_hotel = $request->val;
      $resultado= DB::table('zonedirect_ip')->select('id_zone', 'ip')->where('id_hotel', '=', $id_hotel)->get();
      return json_encode($resultado);
    }
    public function searchone(Request $request)
    {
      $id_hotel = $request->valht;
      $id_date = $request->d_cur;
      $id_zd=$request->valzd;

      if ($id_zd != 'manual') {
        $resultado= DB::table('GBXDia')->select('CantidadBytes')
        ->where('hotels_id', '=', $id_hotel)
        ->where('Fecha', '=', $id_date)
        ->where('ZD', '=', $id_zd)
        ->value('CantidadBytes');

        if ($resultado == '') { $result=''; }
        else {
          $resultbytes=$resultado;
          $result = round(((($resultbytes / 1024) / 1024) / 1024) , 2);
        }
        return $result;
      }
      else {
        $resultado= DB::table('GBXDia')->select('CantidadBytes')
        ->where('hotels_id', '=', $id_hotel)
        ->where('Fecha', '=', $id_date)
        ->value('CantidadBytes');

        if ($resultado == '') { $result=''; }
        else {
          $resultbytes=$resultado;
          $result = round(((($resultbytes / 1024) / 1024) / 1024) , 2);
        }
        return $result;
      }


    }
    public function searchtwo(Request $request)
    {
      $id_hotel = $request->valora;
      $id_date = $request->d_cur;
      $resultado= DB::table('UsuariosXDia')->select('NumClientes')->where('hotels_id', '=', $id_hotel)->where('Fecha', '=', $id_date)->value('NumClientes');
      if ($resultado == '') {
        $result='';
      }
      else {
        $result=$resultado;
      }
      return $result;
    }

    /**
     * Show the form for creating a new resource.
     * 2701.357806921
     * 2301.556911872
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $hotel = $request->valora;
       $fecha = $request->d_cur;
       $newgb = $request->d_cant;
       $valor = 1073741824;
       $newbytes = $newgb * $valor;
       $newzd = $request->d_zd;

       $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
       $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
       $nuevafecha;

       if ($newzd != 'manual') {
         ////////////////////////////////////////////////////////////////////////////////
         $sql_type_capture= DB::table('GBXDia')->select('Captura')->where('hotels_id', $hotel)->where('Fecha', $fecha)->where('ZD', $newzd)->value('Captura');
         if ($sql_type_capture == '0') {
           $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->where('ZD', $newzd)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $newbytes]);
           return $sql;
         }
         else if ($sql_type_capture == '1') {
           $sql_t_yesterday= DB::table('GBXDia')->select('Captura')->where('hotels_id', $hotel)->where('Fecha', $nuevafecha)->where('ZD', $newzd)->value('Captura');
           if ($sql_t_yesterday == '0' || $sql_t_yesterday == '') {
             $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->where('ZD', $newzd)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $newbytes]);
             return $sql;
           }
           else if ($sql_t_yesterday == '1') {
             $sql_consumo_yesterday= DB::table('GBXDia')->select('ConsumoReal')->where('hotels_id', $hotel)->where('Fecha', $nuevafecha)->where('ZD', $newzd)->value('ConsumoReal');
             if ($sql_consumo_yesterday < $newbytes) {//$newbytes < $sql_consumo_yesterday
               $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->where('ZD', $newzd)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $newbytes]);
               return $sql;
             }
             else  if ($sql_consumo_yesterday > $newbytes) {
               $consumoreal = $sql_consumo_yesterday + $newbytes;
               $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->where('ZD', $newzd)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $consumoreal]);
               return $sql;
             }
           }
         }

         ///////////////////////////////////////////////////////////////////////////////
       }
       else {
         $sql_type_capture= DB::table('GBXDia')->select('Captura')->where('hotels_id', $hotel)->where('Fecha', $fecha)->value('Captura');
         if ($sql_type_capture == '0') {
           $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $newbytes]);
           return $sql;
         }
         else if ($sql_type_capture == '1') {//PENDIENTE
           $sql_t_yesterday= DB::table('GBXDia')->select('Captura')->where('hotels_id', $hotel)->where('Fecha', $nuevafecha)->value('Captura');
           if ($sql_t_yesterday == '0' || $sql_t_yesterday == '') {
             $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $newbytes]);
             return $sql;
           }
           else if ($sql_t_yesterday == '1') {
             $sql_consumo_yesterday= DB::table('GBXDia')->select('ConsumoReal')->where('hotels_id', $hotel)->where('Fecha', $nuevafecha)->value('ConsumoReal');
             if ($sql_consumo_yesterday < $newbytes) {//$newbytes < $sql_consumo_yesterday
               $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $newbytes]);
               return $sql;
             }
             else  if ($sql_consumo_yesterday > $newbytes) {
               $consumoreal = $sql_consumo_yesterday + $newbytes;
               $sql = DB::table('GBXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->update(['CantidadBytes' => $newbytes, 'ConsumoReal' => $consumoreal]);
               return $sql;
             }
           }
         }
       }

    }
    public function creates(Request $request)
    {
       $hotel = $request->valora;
       $fecha = $request->d_cur;
       $newuser = $request->d_cant;
       $sql = DB::table('UsuariosXDia')->where('hotels_id', $hotel)->where('Fecha', $fecha)->update(['NumClientes' => $newuser]);
       return $sql;
    }

    public function update_edit_type_avatar(Request $request)
    {
      if($request->hasFile('upload_img_type')){
        $hotel= $request->select_one_type;
        $date= $request->month_upload_type;
        $dateNew=$date.'-01';

         $exist = DB::table('report_hotel_tipo')->select('img')
         ->where('id_hotel', '=', $hotel)
         ->where('fecha', '=', $dateNew)
         ->count();

         $val_exist = DB::table('report_hotel_tipo')->select('img')
         ->where('id_hotel', '=', $hotel)
         ->where('fecha', '=', $dateNew)
         ->value('img');

         if( $exist != 0){
           $file = public_path('img/devicetype/' . $val_exist);
           if (File::exists($file)) {
             chmod($file,0777);
             unlink($file);
           }
           $avatar = $request->file('upload_img_type');
           $filename = time() . '.' . $avatar->getClientOriginalExtension();
           Image::make($avatar)->resize(380,220)->save( public_path('/img/devicetype/' . $filename ) );
           $sql = DB::table('report_hotel_tipo')
           ->where('id_hotel', $hotel)
           ->where('fecha', $dateNew)
           ->update(['img' => $filename]);
           notificationMsg('success', 'Registro actualizado.!!');
         }
         else {
           notificationMsg('danger', 'No existe registro, imagen no registrada.!!');
         }
      }
      else {
        notificationMsg('errot', 'Completa los requerimientos.!!');
      }
      return redirect('/edit_report');
    }
    public function update_edit_band_avatar(Request $request)
    {
      if($request->hasFile('upload_img')){
        $hotel= $request->select_one_band;
        $date= $request->month_upload;
        $dateNew=$date.'-01';

         $exist = DB::table('report_hotel_banda')->select('img')
         ->where('id_hotel', '=', $hotel)
         ->where('fecha', '=', $dateNew)
         ->count();

         $val_exist = DB::table('report_hotel_banda')->select('img')
         ->where('id_hotel', '=', $hotel)
         ->where('fecha', '=', $dateNew)
         ->value('img');

         if( $exist != 0){
           $file = public_path('img/anchobanda/' . $val_exist);
           if (File::exists($file)) {
             chmod($file,0777);
             unlink($file);
           }
           $avatar = $request->file('upload_img');
           $filename = time() . '.' . $avatar->getClientOriginalExtension();
           Image::make($avatar)->resize(600,200)->save( public_path('/img/anchobanda/' . $filename ) );
           $sql = DB::table('report_hotel_banda')
           ->where('id_hotel', $hotel)
           ->where('fecha', $dateNew)
           ->update(['img' => $filename]);
           notificationMsg('success', 'Registro actualizado.!!');
         }
         else {
           notificationMsg('danger', 'No existe registro, imagen no registrada.!!');
         }
      }
      else {
        notificationMsg('errot', 'Completa los requerimientos.!!');
      }
      return redirect('/edit_report');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class AssignTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $selectDatahotel = DB::table('HotelUserReport')
                                  ->select('IDHotels','Nombre_hotel')
                                  ->where('IDUsuario', '!=', '38')
                                  ->where('IDUsuario', '!=', '1')
                                  ->where('Nombre_hotel', 'NOT LIKE', 'Bodega%')
                                  ->orderBy('IDHotels', 'asc')
                                  ->get();

      $selectTypeRep = DB::table('TipoReporteNEW')
                                ->select('id','Nombre')
                                ->where('Estado', '=', '1')
                                ->get();

      return view('assigntype.assigntypeh', compact('selectDatahotel', 'selectTypeRep'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $id_hotel = $request->select_one;
      $id_report = $request->select_two;

      $sql = DB::table('hotel_tipo_reporte')
            ->where('fk_hotel', '=', $id_hotel)
            ->where('fk_tiporeportenew', '=', $id_report)
            ->count();

      if ($sql == 0) {
        $sql= DB::table('hotel_tipo_reporte')->insert([
          ['fk_tiporeportenew' => $id_report,
           'fk_hotel' => $id_hotel]
        ]);
        return '1';
      }
      else {
        return '0';
      }
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
    public function show(Request $request)
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class QuizResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('quiz.quizresults');
    }

    public function view(Request $request)
    {
      $year= $request->searchyear;
      $vertical= $request->searchvertical;

      if ($year == '' && $vertical == '') {
        $sql= DB::table('resultEnc')
              ->get();
      }

      if ($year != '' && $vertical != '') {
        $sql= DB::table('resultEnc')
              ->where('years', '=', $year)
              ->where('vertical', '=', $vertical)
              ->get();
      }
      if ($year != '' && $vertical == '') {
        //$v='si hay año pero no vertical';
        $sql= DB::table('resultEnc')
              ->where('years', '=', $year)
              ->get();
      }
      if ($year == '' && $vertical != '') {
        //$v='no hay año pero si vertical';
        $sql= DB::table('resultEnc')
              ->where('vertical', '=', $vertical)
              ->get();
      }
      return json_encode($sql);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DateTime;

class QuizQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('quiz.quizquestions');
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
      $req_radio = $request->radio;

      $req_com_a = $request->comment_a;
      $req_com_b = $request->comment_b;
      $req_com_c = $request->comment_c;

      $req_radb1 = $request->radiob1;
      $req_radb2 = $request->radiob2;
      $req_radb3 = $request->radiob3;

      $req_radc1= $request->radioc1;
      $req_radc2= $request->radioc2;
      $req_radc3= $request->radioc3;

      $req_rating = $request->rating;

      if($req_radio == 0){
        $resta=0;

      }
      if($req_radio == 100){
        $now = new \DateTime();
        $date= $now->format('Y-m-d');

        // $sql= DB::table('calificaciones')->insert([
        //   ['Calificacion' => $fechaSalidaAP,
        //    'Mes' => ,
        //    'Year1' => ,
        //    'Probabilidad' =>  ,
        //    'Pregunta1' =>  ,
        //    'Pregunta2' =>  ,
        //    'Comentario1' =>  ,
        //    'Comentario2' =>  ,
        //    'Comentario3' =>  ,
        //    'Fecha' =>  $date,
        //    'hotels_id' =>  ]
        // ]);
      }
      if($req_radio == 'ninguna'){ }

      return $date;
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

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
        $validacion = 0;
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

        $fechain = date("Y-m-d");
        $mes = date("F");
        $year = date("Y");


        //DB::beginTransaction();

        if($req_radio == 100){
        // $sql= DB::table('calificaciones')->insert([
        //   ['Calificacion' => $req_rating,
        //    'Mes' => $mes,
        //    'Year1' => $year,
        //    'Probabilidad' =>  $req_radio,
        //    'Comentario3' =>  $req_com_c,
        //    'Fecha' =>  $date,
        //    'hotels_id' =>  ]
        // ]);
        }

        if($req_radio == 0){
        if (!empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
            $valores = $req_radb1 . "|" . $req_radb2 . "|" . $req_radb3;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario1' =>  $req_com_a,
            //    'Comentario2' =>  $req_com_b,
            //    'Comentario3' =>  $req_com_c,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }
        if (!empty($req_com_a) && empty($req_com_b) && empty($req_com_c)) {
            $valores = $req_radb2;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario1' =>  $req_com_a,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }
        if (!empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
            $valores = $req_radb2 . "|" . $req_radb3;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario1' =>  $req_com_a,
            //    'Comentario2' =>  $req_com_b,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }
        if (!empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
            $valores = $req_radb2 . "|" . $req_radb1;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario1' =>  $req_com_a,
            //    'Comentario3' =>  $req_com_c,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }
        if (empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
            $valores = $req_radb3;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario2' =>  $req_com_b,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }
        if (empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
            $valores = $req_radb1;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario3' =>  $req_com_c,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }
        if (empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
            $valores = $req_radb3 . "|" . $req_radb1;
            // $sql= DB::table('calificaciones')->insert([
            //   ['Calificacion' => $fechaSalidaAP,
            //    'Mes' => $mes,
            //    'Year1' => $year,
            //    'Pregunta1' => $valores,
            //    'Probabilidad' =>  $req_radio,
            //    'Comentario2' =>  $req_com_b,
            //    'Comentario3' =>  $req_com_c,
            //    'Fecha' =>  $date,
            //    'hotels_id' =>  ]
            // ]);
        }

        }

        if($req_radio == 'ninguna'){
            if (!empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
                $valores = $req_radc1 . "|" . $req_radc2 . "|" . $req_radc3;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario1' =>  $req_com_a,
                //    'Comentario2' =>  $req_com_b,
                //    'Comentario3' =>  $req_com_c,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }
            if (!empty($req_com_a) && empty($req_com_b) && empty($req_com_c)) {
                $valores = $req_radc2;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario1' =>  $req_com_a,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }
            if (!empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
                $valores = $req_radc2 . "|" . $req_radc3;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario1' =>  $req_com_a,
                //    'Comentario2' =>  $req_com_b,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }
            if (!empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
                $valores = $req_radc2 . "|" . $req_radc1;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario1' =>  $req_com_a,
                //    'Comentario3' =>  $req_com_c,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }
            if (empty($req_com_a) && !empty($req_com_b) && empty($req_com_c)) {
                $valores = $req_radc3;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario2' =>  $req_com_b,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }
            if (empty($req_com_a) && empty($req_com_b) && !empty($req_com_c)) {
                $valores = $req_radc1;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario3' =>  $req_com_c,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }
            if (empty($req_com_a) && !empty($req_com_b) && !empty($req_com_c)) {
                $valores = $req_radc3 . "|" . $req_radc1;
                // $sql= DB::table('calificaciones')->insert([
                //   ['Calificacion' => $fechaSalidaAP,
                //    'Mes' => $mes,
                //    'Year1' => $year,
                //    'Pregunta1' => $valores,
                //    'Probabilidad' =>  $req_radio,
                //    'Comentario2' =>  $req_com_b,
                //    'Comentario3' =>  $req_com_c,
                //    'Fecha' =>  $date,
                //    'hotels_id' =>  ]
                // ]);
            }

      }
      //DB::commit();
      return $validacion;
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

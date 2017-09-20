<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use Auth;

class QuizQuestionsAdminController extends Controller
{
    public function index()
    {
      $sql = DB::table('relacionclientes')->select('id_hotels', 'Nombre_hotel')->where('privilegio', '=', 'Encuestado')->get();
    	return view('quiz.quizmanual', compact('sql'));
    }
    public function search(Request $request)
    {
      $id_hotel = $request->xa_iden;
      $sql = DB::table('relacionclientes')
                       ->select('id_clientes', 'email')
                       ->where('privilegio', '=', 'Encuestado')
                       ->where('id_hotels', '=', $id_hotel)
                       ->get();
        return json_encode($sql);

    }

}

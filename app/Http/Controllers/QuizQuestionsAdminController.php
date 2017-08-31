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
    	$sql = DB::table('relacionclientes')->select('id_hotels', 'Nombre_hotel')->get();
    	//dd($sql);

    	return view('quiz.quizmanual', compact('sql'));
    }


}

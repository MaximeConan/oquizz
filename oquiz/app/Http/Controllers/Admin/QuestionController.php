<?php

//comme notre controller se  situe dans le dossier admin , namespace -> App\Http\Controllers\Admin
namespace App\Http\Controllers\Admin;


use App\Answer;
use App\Utils\UserSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// BONUS - ADMINISTRATION CONTENU - edit answer
class AnswerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // BONUS - ADMINISTRATION CONTENU -  test si utilisateur admin sinon pas d'acces -> redirection

        $this->isUserAllowedToAdminArea();
    }

    public function edit(){

        $quizzes = Answer::all();

        return view('admin.quiz.list', [
            'quizzes' => $quizzes
        ]); 

    }

}
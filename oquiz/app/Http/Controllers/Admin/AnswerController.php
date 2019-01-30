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

        $this->isUserAllowedToAdminArea();
    }

    //modification contenu question (appel via ajax cf updateAnswer() -> app.js)
    public function edit(Request $request){
        

        //recuperation param requete ajax
        $answerId = $request->input('answerId');
        $answerNewValue = $request->input('answerNewValue');

        //recuperation de la reponse a modifier
        $answerToUpdate = Answer::findOrFail($answerId);

        $answerToUpdate->description = $answerNewValue; 

        $answerToUpdate->save();

        // definition d'un retour homogene json (avec code erreur custom) pour savoir facilement si sucess ou non (hors erreur technique 404, 500)
        return response()->json([
            'statusCode' => 1, // 1 = success
            'errors' => [],
            'values' => [
                'answerId' => $answerToUpdate->id,
                'answerText' => $answerToUpdate->description
            ]
        ]);
       
    }

}
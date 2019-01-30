<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\User;
use App\Level;
use App\Answer;
use App\Question;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Utils\Mailer;

class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // AUTHENT 7.2 - Prise en compte du constructeur parent -> ajout data session globales views
        parent::__construct();
    }

    public function list(){

        // HOME 6.1.1 - Liste des quiz sans jointures
        $quizzes = Quiz::all();
        $users = User::all();

        $userList = [];

        // HOME 6.1.3 - permet de recuperer directement tout les users afin de simuler la jointure
        foreach($users as $user){
            $userList[$user->id] = $user->firstname . ' ' . $user->lastname;
        }

        //TAG : permet de creer un tableau contenant pour chaque clef l'objet quizz concerné et ses objets tags associés
        foreach($quizzes as $quiz){

            $tagsForCurrentQuiz = $this->getTagsByQuiz($quiz->id);
            
            $quizTagList[] = [
                'quiz' => $quiz,
                'tags' => $tagsForCurrentQuiz
            ];
        }

        return view('quiz.list', [
            'quizTagList' => $quizTagList,
            'userList' => $userList
        ]);
    }

    // QUIZ 6.2.2 - recuperation id quizz
    public function show($quizId, Request $request){

        // QUIZ 6.2.3 - recuperation du quizz
        $currentQuiz = Quiz::findOrFail($quizId);

        // QUIZ 6.2.4 - recuperation des questions associée au quiz

        // alternative RAW $users = DB::select('select * from app_user where quizzes_id = ?', [$currentQuiz->id]);
        // where = contrainte, get = recupere les resultats
        $questions = Question::where('quizzes_id', '=', $currentQuiz->id)->get();

        // QUIZZ 6.2.7 - affichage des réponses sans random 

        /*

        foreach($questions as $question){
            $answers = Answer::where('id_question', '=', $question->id)->get();

            $questionAnswerList[$question->id]= $answers;            
        }
        
        */

        // QUIZZ 6.2.8 - Rendre aleatoire l'affichage des réponses
        $questionAnswerList = $this->getRandomizedAnswers($questions);

        // QUIZZ 6.2.6 - Recupérer auteur
        $author = User::find($currentQuiz->app_users_id);
        
        // QUIZZ 6.2.9 - Recupérer les niveaux
        $levels = Level::all();

        $levelList = [];

        // HOME 6.1.3 - permet de recuperer directement tout les users afin de simuler la jointure
        foreach($levels as $level){
            $levelList[$level->id] = $level->name;
        }

        //AFFICHAGE TAG SUR UN QUIZ

        $tags =  $this-> getTagsByQuiz($currentQuiz->id);

        //TRAITEMENT REPONSES QUIZ

        //tableau de stockage des bonnes et mauvaises reponses
        $result = [];
        $result['total'] = 0;

        if($request->method() == 'POST'){

            //recupere le contenu de tout mes radios button ayant pour name l'id de la question et pour value l'id de la reponse selectionnée
            foreach($questions as $question){

                $selectAnswerId = $request->input($question->id);

                //si la bonne reponse en DB est identique à l'id envoyé = bonne reponse
                if($question->answers_id == $selectAnswerId){

                    $result['byQuestion'][$question->id] = true;
                    $result['total'] += 1; //nb total bonne reponses

                } else {
                    $result['byQuestion'][$question->id] = false;
                }
            }

            //BONUS - MAIL SCORE
            
            $mailer = new Mailer();

            //Note : Mettre l'email de votre choix et ne pas oublier de configurer les constantes de .env
            $mailer->setTo('claireoclock@gmail.com');
            $mailer->setSubject('Votre participation au jeu oQuiz : '. $currentQuiz->title);
            $mailer->setBody('Votre score est de ' . $result['total'] . ' / '. count($result['byQuestion']));

            $mailer->sendMail(); //envoi du mail

        }

        return view('quiz.show', [
            'currentQuiz' => $currentQuiz,
            'questions' => $questions,
            'author' => $author, // QUIZ 6.2.6
            'questionAnswerList' => $questionAnswerList, // QUIZ 6.2.8
            'levelList' => $levelList, // QUIZ 6.2.9
            'tags' => $tags,
            'quizResult'=> $result
        ]);
    }


    //LISTE QUIZ PAR TAG

    public function listByTag(Request $request){

        $tagId = intval($request->tagId);
        
        //permet d'afficher la liste de tag disponibles sur lequel filtrer
        $tags = Tag::all();

        $quizzes =  DB::select('SELECT quizzes.id, quizzes.title
                             FROM quizzes
                             INNER JOIN  quizzes_has_tags ON (quizzes.id = quizzes_has_tags.quizzes_id)
                             WHERE quizzes_has_tags.tags_id = ?', [$tagId]
        );

        $quizTagList = [];
       
        //TAG : permet de creer un tableau contenant pour chaque clef l'objet quizz concerné et ses objets tags associés

        foreach($quizzes as $quiz){

            $tagsForCurrentQuiz = $this->getTagsByQuiz($quiz->id);
            
            $quizTagList[] = [
                'quiz' => $quiz,
                'tags' => $tagsForCurrentQuiz
            ];
        }

        return view('quiz.listByTag', [
            'quizTagList' => $quizTagList,
            'tagsToFilter' => $tags,
            'selectedTagId' => $tagId //permettra de mettre en avant le tag selectionné
        ]); 
    }

    // QUIZZ 6.2.8 - Retourner et rendre aleatoire l'affichage des réponses
    private function getRandomizedAnswers($questions){

        $questionAnswerList = [];

        foreach($questions as $question){

            //On execute la requete pour chaque tour de boucle 
            //Note: optimisation si requete + jointure

            /*
             shuffle fonction utile de l'objet Illuminate\Database\Eloquent\Collection retourné  par Eloquent : https://laravel.com/docs/5.7/collections#method-shuffle
             */
            $answers = Answer::where('questions_id', '=', $question->id)->get()->shuffle();

            //on attribue les reponses melangée pour chaque id
            $questionAnswerList[$question->id]= $answers;
            
        }
    
        return $questionAnswerList;
    }

    // evite de dupliquer ce code utilisé dans toutes les fonctions d'affichage d'un quiz

    private function getTagsByQuiz($id = 1){

        $tags = DB::select('SELECT tags.id, tags.name 
                             FROM quizzes
                             INNER JOIN  quizzes_has_tags ON (quizzes.id = quizzes_has_tags.quizzes_id)
                             INNER JOIN  tags ON (quizzes_has_tags.tags_id = tags.id)
                             WHERE quizzes.id = ?', [$id]
        );

        return $tags;
    }
}
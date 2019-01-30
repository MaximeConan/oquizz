<?php

//comme notre controller se  situe dans le dossier admin , namespace -> App\Http\Controllers\Admin
namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Quiz;
use App\User;
use App\Level;
use App\Answer;
use App\Question;
use App\QuizHasTag;
use App\Utils\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// BONUS - ADMINISTRATION CONTENU - ajout controller + route + nav conditionné
class QuizController extends Controller
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

    public function list(){

        $quizzes = Quiz::all();

        return view('admin.quiz.list', [
            'quizzes' => $quizzes
        ]); 

    }

    public function edit($quizId, Request $request){

        $quiz = Quiz::findOrFail($quizId);

        $questions = Question::where('quizzes_id', '=', $quiz->id)->get();
        
        $questionAnswerList = [];

        foreach($questions as $question){

            $answers = Answer::where('questions_id', '=', $question->id)->get();

            $questionAnswerList[$question->id]= $answers;
            
        }

        // user du quiz
        $author = User::find($quiz->app_users_id);

        // liste des users a afficher
        $authors = User::all();
        
        $levels = Level::all();

        $levelList = [];

        foreach($levels as $level){
            $levelList[$level->id] = $level->name;
        }

        $tags = $this-> getTagsByQuiz($quiz->id);

        //retourne les tags non associés pour ce quiz
        $availableTags = $this->getAvailableTagForQuiz($quiz->id);

        if($request->method() == 'POST'){


            //recupere le contenu des input relatifs au quiz

            $title = $request->input('quizTitle');
            $description = $request->input('quizDescription');
            $userId = $request->input('userId');

            //set les nouvelles valeurs de l'objet
            $quiz->title = $title;
            $quiz->description = $description;
            $quiz->app_users_id = $userId;

            //sauvegarde du quizz
            $quiz->save();

            foreach($questions as $question){

                //recupere le contenu des input relatifs aux question du quiz

                $questionLevel = $request->input('questionLevel-' . $question->id);
                $questionLabel = $request->input('questionLabel-' . $question->id);
                $answerId = $request->input('questionGoodAnswer-' . $question->id);
                $questionAnecdote = $request->input('questionAnecdote-' . $question->id);
                $questionWiki = $request->input('questionWiki-' . $question->id);

                //set les nouvelles valeurs de l'objet sur la question courante

                $question->question = $questionLabel;
                $question->anecdote = $questionAnecdote;
                $question->wiki = $questionWiki;
                $question->answers_id = $answerId;
                $question->levels_id = $questionLevel;

                //sauvegarde de la question courante
                $question->save();
            }

        }
        
        return view('admin.quiz.edit', [
            'currentQuiz' => $quiz,
            'questions' => $questions,
            'currentAuthor' => $author,
            'authors' => $authors,
            'questionAnswerList' => $questionAnswerList,
            'levelList' => $levelList,
            'tags' => $tags,
            'availableTags' => $availableTags
        ]);
    }

    //ajout tag (appel via ajax cf addTagToQuiz() -> app.js)
    public function addTag(Request $request){ 
        

        //recuperation param requete ajax
        $quizId = $request->input('quizId');
        $tagId = $request->input('tagId');

        $quizHasTag = new QuizHasTag();

        $quizHasTag->quizzes_id = $quizId;
        $quizHasTag->tags_id = $tagId;

        $quizHasTag->save();

        // definition d'un retour homogene json (avec code erreur custom) pour savoir facilement si sucess ou non (hors erreur technique 404, 500)
        return response()->json([
            'statusCode' => 1, // 1 = success
            'errors' => [],
            'values' => [
                'availableTagForQuiz' => $this->getAvailableTagForQuiz($quizHasTag->quizzes_id), //retourne la liste a jour de tag a rajouter
                'tagList' => $this->getTagsByQuiz($quizHasTag->quizzes_id) //retourne la liste a jour des tag appliqués sur le quiz
            ]
        ]);
       
    }

        //suppression tag (appel via ajax cf deleteTagToQuiz() -> app.js)
        public function deleteTag(Request $request){ 
        

            //recuperation param requete ajax
            $quizId = $request->input('quizId');
            $tagId = $request->input('tagId');
            //dump($quizId);
            //dump($tagId);
            $deletedRow = QuizHasTag::where('quizzes_id', $quizId )
                          ->where('tags_id', $tagId )
                          ->delete();

            return response()->json([
                'statusCode' => 1, // 1 = success
                'errors' => [],
                'values' => [
                    'availableTagForQuiz' => $this->getAvailableTagForQuiz($quizId), //retourne la liste a jour de tag a rajouter
                    'tagList' => $this->getTagsByQuiz($quizId) //retourne la liste a jour des tag appliqués sur le quiz
                ]
            ]);
           
        }

    private function getTagsByQuiz($id = 1){

        $tags = DB::select('SELECT tags.id, tags.name 
                            FROM quizzes
                            INNER JOIN  quizzes_has_tags ON (quizzes.id = quizzes_has_tags.quizzes_id)
                            INNER JOIN  tags ON (quizzes_has_tags.tags_id = tags.id)
                            WHERE quizzes.id = ?', [$id]
        );

        return $tags;
    }

    private function getAvailableTagForQuiz($id)
    {
        //recupere les tag deja associés au quiz

        $tags = $this->getTagsByQuiz();

        foreach($tags as $tag){

            $tagListAlreadyAssociatedToQuiz[] = $tag->id;
        }

        //ne retourne que les id non present dans la liste des tags associés
        $tags = Tag::whereNotIn('id', $tagListAlreadyAssociatedToQuiz)->get();

        return $tags;
    }



}
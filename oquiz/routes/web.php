<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// ROUTES 3.1 / 3.2 - Rajouter les routes enonce + routes supplementaires

// La homepage du site conciste en l'affichage de la liste des quiz => pas de HomeController
$router->get('/', [
    'as' => 'quiz_list', 'uses' => 'QuizController@list'
]);

$router->get('quiz/{quizId}', [
    'as' => 'quiz_show', 'uses' => 'QuizController@show'
]);

//REPONSES AU QUIZ
$router->post('quiz/{quizId}', [
    'as' => 'quiz_show', 'uses' => 'QuizController@show'
]);

$router->get('signup', [
    'as' => 'user_signup', 'uses' => 'UserController@signup'
]);

$router->post('signup', [
    'as' => 'user_signup', 'uses' => 'UserController@signup'
]);

$router->get('signin', [
    'as' => 'user_signin', 'uses' => 'UserController@signin'
]);
// FORM LOGIN 6.3.3 - declaration de la route post
$router->post('signin', [
    'as' => 'user_signin', 'uses' => 'UserController@signin'
]);

// PAGE PROFIL
$router->get('account', [
    'as' => 'user_profile', 'uses' => 'UserController@profile'
]);

// 3.2 route supp
$router->get('logout', [
    'as' => 'user_logout', 'uses' => 'UserController@logout'
]);

// 3.2 route supp
//Possibilité de factorisation sur la route quiz
$router->get('quiz/tag/{tagId}', [
    'as' => 'quiz_listByTag', 'uses' => 'QuizController@listByTag'
]);


// 3.2 route supp
$router->get('tag', [
    'as' => 'tag_list', 'uses' => 'TagController@list'
]);

// BONUS - ADMINISTRATION CONTENU - quiz

$router->get('admin/quiz', [
    'as' => 'admin_quiz_list', 'uses' => 'Admin\QuizController@list'
]);

// BONUS - ADMINISTRATION CONTENU - quiz
$router->get('admin/quiz/edit/{quizId}', [
    'as' => 'admin_quiz_edit', 'uses' => 'Admin\QuizController@edit'
]);

$router->post('admin/quiz/edit/{quizId}', [
    'as' => 'admin_quiz_edit', 'uses' => 'Admin\QuizController@edit'
]);

// BONUS - ADMINISTRATION CONTENU - add tag (ajax)
$router->post('admin/quiz/add/tag', [
    'as' => 'admin_quiz_add_tag', 'uses' => 'Admin\QuizController@addTag'
]);

// BONUS - ADMINISTRATION CONTENU - add tag (ajax)
$router->post('admin/quiz/delete/tag', [
    'as' => 'admin_quiz_delete_tag', 'uses' => 'Admin\QuizController@deleteTag'
]);

// BONUS - ADMINISTRATION CONTENU - edit label (ajax)
$router->post('admin/answer/edit', [
    'as' => 'admin_answer_edit', 'uses' => 'Admin\AnswerController@edit'
]);

// BONUS - ADMINISTRATION CONTENU - tag

$router->get('admin/tag', [
    'as' => 'admin_tag_list', 'uses' => 'Admin\TagController@list'
]);

$router->get('admin/tag/add', [
    'as' => 'admin_tag_add', 'uses' => 'Admin\TagController@add'
]);

$router->post('admin/tag/add', [
    'as' => 'admin_tag_add', 'uses' => 'Admin\TagController@add'
]);

$router->get('admin/tag/edit/{tagId}', [
    'as' => 'admin_tag_edit', 'uses' => 'Admin\TagController@edit'
]);

$router->post('admin/tag/edit/{tagId}', [
    'as' => 'admin_tag_edit', 'uses' => 'Admin\TagController@edit'
]);

$router->get('admin/tag/delete/{tagId}', [
    'as' => 'admin_tag_delete', 'uses' => 'Admin\TagController@delete'
]);




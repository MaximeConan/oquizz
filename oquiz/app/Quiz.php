<?php
//MODELS (1) 2.4 - Création models 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    //MODELS (1) 2.5 - Mapping nom de table associé à la classe
    protected $table = 'quizzes';

}
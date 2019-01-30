<?php

namespace App\Http\Controllers\Admin;


use App\Tag;
use App\QuizHasTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// BONUS - ADMINISTRATION CONTENU - Tag
class TagController extends Controller
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

    public function list(){

        $tags = Tag::all();

        return view('admin.tag.list', [
            'tags' => $tags
        ]); 

    }

    public function add(Request $request){

        if($request->method() == 'POST'){

            $tagName = $request->input('tagName');

            $tag = new Tag();

            $tag->name = $tagName;

            //enregistre le nouveau tag
            $tag->save();
        }

        return view('admin.tag.add', [
          
        ]); 
    }

    public function edit(Request $request){

        $id = $request->tagId;

        //je recupere le tag a modifier
        $tag = Tag::findOrFail($id);

        if($request->method() == 'POST'){

            $tagName = $request->input('tagName');
    
            $tag->name = $tagName;
    
            //enregistre les modification du tag
            $tag->save();
        }     

        return view('admin.tag.edit', [
          'tag' => $tag
        ]); 
    }

    public function delete(Request $request){

        $tagId = $request->tagId;

        //dans un premier suppression des données de la jointures avant la données original 
        //=> permet d'eviter les erreurs et empecher les données orphelines (un id qui appartient a rien)
         $a = QuizHasTag::where('tags_id', $tagId)->delete();

        //suppression definitive du Tag 
        $b = Tag::find($tagId)->delete();
   
        return redirect()->route('admin_tag_list');
    }
}
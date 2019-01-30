<?php

namespace App\Http\Controllers;

class TagController extends Controller
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
        return view('tag.list', []);    
    }
}
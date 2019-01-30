<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

// AUTHENT 7.2 https://laravel.com/docs/5.7/views#passing-data-to-views
use Illuminate\Support\Facades\View;
use App\Utils\UserSession;

class Controller extends BaseController
{
    // AUTHENT 7.2 Partage de données de session dans toutes les vues
    public function __construct()
    {
        View::share('isConnected', UserSession::isConnected());
        View::share('currentUser', UserSession::getUser());

        //BONUS - ADMINISTRATION CONTENU
        View::share('isAdmin', UserSession::isAdmin());
    }

    // permet de verifier si l'utilisateur est bien admin (reservé a l'admin) -> sinon redirection
    public function isUserAllowedToAdminArea(){
        if(!UserSession::isAdmin()) {
            $this->redirectToHome();
        }
    }

    //permet de verifier si l'utilisateur est authentifié tout role confondu-> sinon redirection
    public function isUserAuthenticated(){

        if(!UserSession::isConnected()) {
            $this->redirectToHome();
        }

    }

    public function redirectToHome() {

        header('Location: ' . route('quiz_list'));

            //IMPORTANT exit() - sinon en cas de lecture avec apache -> ne prendra pas en compte le header location jusqu'au render de la view (donc pas de redirection)
        exit();
    }
}

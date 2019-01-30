<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

// AUTHENT 7 
use App\Utils\UserSession;

class UserController extends Controller
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

    public function signup(Request $request){
        
        $errorList = [];
        
        if ($request->isMethod('POST')) {
 
             $email = $request->input('email', '');
             $firstname = $request->input('firstname', '');
             $lastname = $request->input('lastname', '');
             $password = $request->input('password', '');

             // FORM SIGNUP 6.4.4 - Recuperation champs passwordConfirm

             $passwordConfirm = $request->input('passwordConfirm');

             $email = trim($email);
             $firstname = trim($firstname);
             $lastname = trim($lastname);
             $password = trim($password);
             $passwordConfirm = trim($passwordConfirm); // FORM SIGNUP 6.4.4 
             
             if (empty($lastname)) {
                $errorList[] = 'Nom vide';
             }

             if (empty($firstname)) {
                $errorList[] = 'Prénom vide';
             }

             if (empty($email)) {
                 $errorList[] = 'Email vide';
             }
             else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                 $errorList[] = 'Email incorrect';
             }
 
             if (empty($password)) {
                 $errorList[] = 'Mot de passe vide';
             }
             if (strlen($password) < 8) {
                 $errorList[] = 'Le mot de passe doit faire au moins 8 caractères';
             }

             // FORM SIGNUP 6.4.5 - Test d'erreur de saisie de $passwordConfirm
             if (empty($passwordConfirm)) {
                $errorList[] = 'Confirmation de mot de passe vide';
             }
             if ($password != $passwordConfirm) {
                $errorList[] = 'Les 2 mots de passe sont différents';
             }

             if (empty($errorList)) {
                 
                 // FORM SIGNUP 6.4.6 - test si account existant 
                 $user = User::where('email', '=', $email)->first();
                 
                 if ($user) {                     
                                      
                    $errorList[] = 'Un compte avec cet email existe déjà';

                 } else {

                    // FORM SIGNUP 6.4.7 - encryptage password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
                    
                    // FORM SIGNUP 6.4.8 - save de l'utilisateur
                    $newUser = new User();
                    $newUser->email = $email;
                    $newUser->password = $hashedPassword;
                    $newUser->last_name = $lastname;
                    $newUser->first_name = $firstname;
                    $newUser->save();
                    
                    // redirection vers la page de login
                    return redirect()->route('user_signin'); 
                 }
             }
        }

        return view('user.signup', $errorList);
    }

    public function signin(Request $request){
        
         // FORM LOGIN 6.3.5 - gestion des erreurs de saisie
        $errorList = [];
        
        // FORM LOGIN 6.3.4 - test de la methode post (envoi du form)
        if ($request->isMethod('post')) {

            // FORM LOGIN 6.3.5 - gestion des erreurs de saisie
            $email = $request->input('email', '');
            $password = $request->input('password', '');

            $email = trim($email);
            $password = trim($password);
            
            if(
                empty($email) || 
                filter_var($email, FILTER_VALIDATE_EMAIL === false) ||
                empty($password) ||
                strlen($password) < 8 
            ){
                $errorList[] = 'Identifiant ou mot de passe incorrect';
            } 

            if (empty($errorList)) {

                 // FORM LOGIN 6.3.6 - user by email
                $user = User::where('email', '=', $email)->first();

                if ($user) {
                    
                    // FORM LOGIN 6.3.7 - user by email
                    if (password_verify($password, $user->password)) {

                        // AUTHENT 7 - cf use
                       UserSession::connect($user);

                        // FORM LOGIN 6.3.8 - redirection
                        return redirect()->route('quiz_list');

                    } else {
                        $errorList[] = 'L\'identifiant et/ou mot de passe incorrect';
                    }     

                } else {
                    $errorList[] = 'L\'identifiant et/ou mot de passe incorrect';
                }
            }
        }

        return view('user.signin', ['errorList' => $errorList]);
    }

    public function logout(){

        // DECONNEXION 8 - suppression session + redirection liste
        UserSession::disconnect();

        return redirect()->route('quiz_list'); 
    }

    //PAGE DE PROFIL
    public function profile(){

        $this->isUserAllowedToAdminArea();

        //pas de data supp -> controller parent + share
        return view('user.profile', []);
    }
}
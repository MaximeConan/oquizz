<?php

namespace App\Utils;

//necessaire au typehint fonction connect()
use App\User;

abstract class UserSession {
    

    const SESSION_DATA_NAME = 'currentUser';
    
    //connecte l'utilisateur
    public static function connect(User $userModel) : bool {
        $_SESSION[self::SESSION_DATA_NAME] = $userModel;
        
        return true;
    }

    //deconnecte l'utilisateur
    public static function disconnect() : bool {
        unset($_SESSION[self::SESSION_DATA_NAME]);
        
        return true;
    }

    //retourne si un utilisateur est deja stocké en session
    public static function isConnected() : bool {
        return !empty($_SESSION[self::SESSION_DATA_NAME]);
    }
    
    //retourne l'utilisateur courant
    public static function getUser() {

        if (self::isConnected()) {
            return $_SESSION[self::SESSION_DATA_NAME];
        }

        return false;
    }

    // ROLES & PERMISSIONS 9.3 - retourne le role Id

    public static function getRoleId() : int {
        // Si user connecté
        if (self::isConnected()) {
            return self::getUser()->roles_id;
        }
        return 0; //si pas de roles attribué en DB (par securité)
    }
    
    // ROLES & PERMISSIONS 9.3 - si le statut de l'utilisateur (si admin)
    public static function isAdmin() : bool {
        return (self::getRoleId() == 1); // 1 = role admin , 2  = role user
    }
    
}

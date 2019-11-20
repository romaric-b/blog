<?php
namespace App\controller;
require_once '';

use App\model\entities\User;
use App\model\UserManager ;


// Je set les données sur mon entités, je les controle, si c'est ok : je les get dans mon manager pour préparer leurs envoies en bases et j'envoie(envoie en base)
// OU je contrôle les $_POST dans le controleur, je set les entrées à mon entités si ok. Je get dans mon manager pour envoyer

class UserController
{
    /**
     * Lors de l'inscription, contrôle l'existance des données utilisateur, leurs types et leurs formats, sécurise le pass et vérifier que le pseudo est pas déjà pris.
     */
    private function register()
    {
        $user = new User( //RegistDate on le passera
        [
            'nickname' => htmlspecialchars($_POST['nickname']),
            'email' => htmlspecialchars($_POST['email']),
            'password' => htmlspecialchars($_POST['password']),
            'password2' => htmlspecialchars($_POST['password2'])
        ]);

        $user->getNickname();
        $user->getEmail();
        $user->getPassword();
        $user->getPassword2();

        var_dump($user);


    }

    private function login()
    {


    }

    private function disconnect()
    {

    }

    private function listUsers() //pour l'admin ce droit
    {

    }

    private function banUser() //pour l'admin ce droit
    {

    }
}


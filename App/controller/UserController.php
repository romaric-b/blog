<?php
namespace App\controller;
require_once '';

use App\model\entities\User;
use App\model\UserManager ;



class UserController
{
    public function __construct()
    {
        $this->userManager = new UserManager();
    }
    /**
     * Lors de l'inscription, contrôle l'existance des données utilisateur, leurs types et leurs formats, sécurise le pass et vérifier que le pseudo est pas déjà pris.
     */
    private function register()
    {
        // 1 : L'utilisateur rentre des données dans son formulaires, elles sont affectées à User et contrôlées
        $user = new User( //RegistDate on le passera
        [
            'nickname' => htmlspecialchars($_POST['nickname']),
            'email' => htmlspecialchars($_POST['email']),
            'password' => htmlspecialchars($_POST['password']),
            'password2' => htmlspecialchars($_POST['password2'])
        ]);

        // 2 : J'appelle l'UserManager qui va transporter ça jusqu'à la BDD et le créer
        $this->userManager->createMember($user);

        // 3 : TODO j'appelle une vue confirmant son inscription

    }

    private function login()
    {
        // 1 : L'utilisateur rentre des données dans son formulaires, elles sont affectées à User et contrôlées
        $user = new User( //RegistDate on le passera
        [
            'nickname' => htmlspecialchars($_POST['nickname']),
            'password' => htmlspecialchars($_POST['password'])
        ]);



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


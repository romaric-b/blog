<?php
namespace App\controller;
require_once '';

use App\model\entities\User;
use App\model\UserManager ;



class UserController
{
    private $msg;

    public function __construct()
    {
        $this->userManager = new UserManager();
        // TODO j'instancie la class gérant les vues
    }
    /**
     * Lors de l'inscription, contrôle l'existance des données utilisateur, leurs types et leurs formats, sécurise le pass et vérifier que le pseudo est pas déjà pris.
     */
    private function register()
    {
        if(isset($_POST['registForm'])) //vérifie si notre formulaire a été envoyé (submit)
        {
            //Je passe les données utilisateur à $user qui cntrôlera les variables
            $user = new User(
            [
                //A gauche clé pour setter
                'nickname' => htmlspecialchars($_POST['registNickname']),
                'email' => htmlspecialchars($_POST['registEmail']),
                'password' => password_hash($_POST['registPassword']),
                'password2' => password_hash($_POST['registPassword2'])
            ]);

            //je contrôle si le pseudo à déjà été utilisé grace à mon manager
            $registingUser = $user->getNickname();
            var_dump($registingUser);

            //$registingUser est nettoyé et près à être utilisé dans une requête (pas d'injection sql)


            //je récup_re mes utilisateurs ayant un COUNT($registingUser) via PDO par une class à définir si abstraite


        } //else il se passe rien d'autre




        $this->userManager->createMember($user);

        // 3 : TODO j'appelle une vue confirmant son inscription

    }

    private function login()
    {
        if(isset($_POST['loginForm']))
        // 1 : L'utilisateur rentre des données dans son formulaires, elles sont affectées à User et nettoyées
        $user = new User(
        [
            //A gauche clé pour setter
            'nickname' => htmlspecialchars($_POST['loginNickname']),
            'password' => htmlspecialchars($_POST['loginPassword'])
        ]);


        // 2 je récupère le mot de passe traité qui vient d'être rentré
        $passwordLogin = $user->getPassword();



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


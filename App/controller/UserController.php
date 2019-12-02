<?php
namespace App\controller;


use App\model\entities\User;
use App\model\UserManager ;



class UserController
{
    public $msg;

    public function __construct()
    {
        $this->userManager = new UserManager();
        // TODO j'instancie la class gérant les vues
    }
    /**
     * Lors de l'inscription, contrôle l'existance des données utilisateur,, les formats, sécurise le pass et vérifier que le pseudo est pas déjà pris.
     */
    public function register()
    {
//        require 'front-office/public/index.html';

        if(isset($_POST['registForm'])) //vérifie si notre formulaire a été envoyé (submit)
        {
            //Je passe les données utilisateur à $newUser qui contrôlera les variables
            $newUser = new User(
            [
                //A gauche clé pour setter
                'nickname' => trim(htmlspecialchars($_POST['registNickname'])),
                'email' => trim(htmlspecialchars($_POST['registEmail'])),
                'password' => htmlspecialchars($_POST['registPassword']),
                'password2' => htmlspecialchars($_POST['registPassword2'])
            ]);
            //je contrôle si le pseudo à déjà été utilisé grace à mon manager
            $matchedNickname = $this->userManager->readMember($newUser);
            var_dump($matchedNickname);
            //Si les pseudo matchent
            if($matchedNickname > 0)
            {
                return $this->msg = "Ce pseudo est déjà utilisé, choisissez en un autre";
            }

            //comparaison MDP
            if ($newUser->getPassword() !== $newUser->getPassword2())
            {
                return $this->msg = "Les mots de passe entrés sont différents";
            }
            else
            {
                password_hash($newUser->getPassword(),PASSWORD_DEFAULT);
            }
            $this->userManager->createMember($newUser);
            echo '<p>Inscription bien validées, vous pouvez dès à présent vous connecter : 
                    <a href="/index.php">Connexion</a>
                  </p>';
        }
    }

    public function login()
    {
        if(isset($_POST['loginForm']))
        // 1 : L'utilisateur rentre des données dans son formulaires, elles sont affectées à User et nettoyées
        $loginUser = new User(
        [
            //A gauche clé pour setter
            'nickname' => trim(htmlspecialchars($_POST['loginNickname'])),
            'password' => trim(password_hash($_POST['registPassword'], PASSWORD_DEFAULT))
        ]);

        // 2 je récupère ce qui vient d'être entré dans le formulaire
        $nicknameLogin = $loginUser->getNickname();
        $passwordLogin = $loginUser->getPassword();

        //J'enregistre les pseudo de la base matchant avec celui rentré dans le formulaire
        $matchedMember = $this->userManager->readMember($nicknameLogin);

        //Si les pseudo matchent
        if($matchedMember)
        {
            $isPasswordCorrect = password_verify($passwordLogin, $matchedMember['password']); //ou user_password je sais plus

            if($isPasswordCorrect)
            {
                session_abort();
                $_SESSION['id'] = $matchedMember['id'];
                $_SESSION['nickname'] = $nicknameLogin;

                //Si la case à cocher connexion auto
                if(isset($_POST['autolog'])) //Comment checker la sécurité d'une checkbox
                {
                    // !!! PARTIE SI DESSOUS A ADAPTER A MON CAS !!!
                    $hashPass = password_hash($passwordLogin, PASSWORD_DEFAULT);
                    //j'enregistre en cookie le mdp
                    $_COOKIE['nickname'] = $nicknameLogin;
                    $_COOKIE['password'] = $hashPass;
                }

                echo '<p>Vous êtes connecté !</p>';
                header('Location: espacemembre.php'); //  !!! A READATER !!!
            }
        }
        else
        {
            $this->msg = "Erreur d'identifiant ou de mot de passe";
        }
    }

    public function disconnect()
    {

    }

    public function listUsers() //pour l'admin ce droit
    {

    }

    public function banUser() //pour l'admin ce droit
    {

    }
}


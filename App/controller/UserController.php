<?php
namespace App\controller;


use App\model\entities\User;
use App\model\UserManager ;
use App\controller\FrontController;



class UserController
{
    public $msg;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->frontController = new FrontController();
    }
    /**
     * Lors de l'inscription, contrôle l'existance des données utilisateur,, les formats, sécurise le pass et vérifier que le pseudo est pas déjà pris.
     */
    public function register() //Testé et fonctionne
    {
//        require 'front-office/public/index.html';

        if(isset($_POST['registForm'])) //Name du form, vérifie si notre formulaire a été envoyé (submit)
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

            $this->userManager->createMember($newUser);
            echo '<p>Inscription bien validées, vous pouvez dès à présent vous connecter : 
//                    <a href="/index.php">Connexion</a>
                  </p>';
        }
    }

    public function login() //Testé et fonctionne
    {
        //Si l'utilisateur avait choisi la co automatique (cette condition est vérifiée
//        if (isset($_COOKIE['nickname']) AND isset($_COOKIE['password']))
//        {
//            echo 'Bonjour ' . $_COOKIE['nickname'] . ', vous allez être connecté automatiquement';
//            //Je redirige l'user vers son espace membre
//            //header('Location: '); TODO actualiser le statut sur connecté dans le header de l'utilisateur (peu importe la page) en faisant apparaitre 'deconnexion' au lieu de 'connexion' et 'inscription'
//        }

        //S'il se connecte manuellement
        if(isset($_POST['loginForm'])) //Name du form
        // 1 : L'utilisateur rentre des données dans son formulaires, elles sont affectées à User et nettoyées
        $loginUser = new User(
        [
            //A gauche clé pour setter
            'nickname' => trim(htmlspecialchars($_POST['loginNickname'])),
            'password' => htmlspecialchars($_POST['loginPassword']) //le mot de passe est haché plus tard
        ]);

        //je contrôle si le pseudo à déjà été utilisé grace à mon manager
        $matchedUser = $this->userManager->readMember($loginUser);

        //Si pas d'utilisateur correspondant trouvé
        if(!$matchedUser)
        {
            echo '<p>Mauvais identifiant ou mot de passe !</p>'; //Remarque en vrai seul l'identifiant est mauvais mais autant ne pas donner trop d'indications sur ce qui est faux exactement, par souci de sécurité mais quid de l'accessibilité ?
        }
        else //Le cas ou le pseudo match avec un existant
        {
            // Comparaison du pass envoyé via le formulaire en param gauche avec celui du matching dans la base en param droit
            $isPasswordCorrect = password_verify($loginUser->getPassword(), $matchedUser['user_password']);

            //TODO sécurité, visibilité ou accès à ce hash ?

            if($isPasswordCorrect) //Ne rentre pas ici à cause de mot de passe
            {
                $hashLoginUserPass = password_hash($loginUser->getPassword(), PASSWORD_DEFAULT);

//               //Si la case à cocher connexion auto //Si j'ai le temps de faire ça... revoir comment utiliser cooki
//               if(isset($_POST['autolog'])) //Comment checker la sécurité d'une checkbox
//               {
//                   //je hash le pass avant qu'il soit enregistré en cookie
//                   $hashLoginUserPass = password_hash($loginUser->getPassword(), PASSWORD_DEFAULT);
//                   $_COOKIE['id'] = $matchedUser['user_id'];
//                   $_COOKIE['nickname'] = $loginUser->getNickname();
//                   $_COOKIE['password'] = $hashLoginUserPass;
//               }
                //j'enregistre en session l'id utilisateur le pseudo et le mdp haché
                $_SESSION['user_id'] = $matchedUser['user_id'];
                $_SESSION['user_nickname'] = $loginUser->getNickname();
                $_SESSION['user_password'] = $hashLoginUserPass;
                $_SESSION['user_role'] = $loginUser->getRole(); //servira à rediriger suivant si admin ou membre

                if($_SESSION['user_role'] = 'member')
                {
                    header('location: index.php?action=listPosts');
                }
                elseif ($_SESSION['user_role'] = 'administrator')
                {
                    header('location: index.php?action=home_dashboard'); //le require se fera sûrement dans l'index
                }
            }
            else // Mauvais mot de passe
            {
                echo '<p>Mauvais identifiant ou mot de passe !</p>'; //Remarque en vrai seul l'identifiant est mauvais mais autant ne pas donner trop d'indications sur ce qui est faux exactement, par souci de sécurité mais quid de l'accessibilité ?
            }
        }
        //TODO prévoir un message de confirmation
    }

    public function disconnect() //fonctionne
    {
        $_SESSION = array();
        session_destroy();
        header('Location: index.php?action=viewHome');
    }

    public function listUsers() //testé et fonctionne TODO : voir comment sécuriser ça avec if (admin...) ou quelque chose comme
    {
        $this->userManager->readAllMembers();
        $this->frontController->loadView("members_dashboard");
    }

    public function banUser() //Non testé mais à faire lorsque le back office sera en place car faisable depuis le tableau de gestion membres TODO : voir comment sécurisé, utilisable que par l'admin
    {
        $this->userManager->deleteMember();
        $this->frontController->loadView("members_dashboard");
    }
}


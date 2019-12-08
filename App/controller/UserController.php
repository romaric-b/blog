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
                    <a href="/index.php">Connexion</a>
                  </p>';
        }
    }

    public function login() //Testé et fonctionne
    {
        //Si l'utilisateur avait choisi la co automatique (cette condition est vérifiée
        if (isset($_COOKIE['nickname']) AND isset($_COOKIE['password']))
        {
            echo 'Bonjour ' . $_COOKIE['nickname'] . ', vous allez être connecté automatiquement';
            //Je redirige l'user vers son espace membre
            //header('Location: '); TODO actualiser le statut sur connecté dans le header de l'utilisateur (peu importe la page) en faisant apparaitre 'deconnexion' au lieu de 'connexion' et 'inscription'
        }

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
               //session_start(); //TODO a déplacer dans le template en début de page je crois

//               $_SESSION['id'] = $matchedUser['id'];
//               $_SESSION['nickname'] = $loginUser->getNickname();

               //Si la case à cocher connexion auto
               if(isset($_POST['autolog'])) //Comment checker la sécurité d'une checkbox
               {
                   //je hash le pass avant qu'il soit enregistré en cookie
                   $hashLoginUserPass = password_hash($loginUser->getPassword(), PASSWORD_DEFAULT);

                   //j'enregistre en cookie le pseudo et le mdp
                   $_COOKIE['nickname'] = $loginUser->getNickname();
                   $_COOKIE['password'] = $hashLoginUserPass;
               }

               //echo '<p>Vous êtes connecté !</p>';

                //header('Location: '); TODO actualiser le statut sur connecté dans le header de l'utilisateur (peu importe la page) en faisant apparaitre 'deconnexion' au lieu de 'connexion' et 'inscription'
            }
            else // Mauvais mot de passe
            {
                echo '<p>Mauvais identifiant ou mot de passe !</p>'; //Remarque en vrai seul l'identifiant est mauvais mais autant ne pas donner trop d'indications sur ce qui est faux exactement, par souci de sécurité mais quid de l'accessibilité ?
            }
        }
    }

    public function disconnect()
    {
        // TODO à déplacer une fois le front préparé
//        session_start();
//        // Suppression des variables de session et de la session
//        $_SESSION = array();
//        session_destroy();
        //Warning: Cannot modify header information - headers already sent by (output started at C:\wamp64\www\blog\App\view\template.php:8) in C:\wamp64\www\blog\App\controller\UserController.php on line 131

        // Suppression des cookies de connexion automatique
        $forgetNickname = setcookie('nickname', '');
        $forgetPassword = setcookie('password', '');

        var_dump($forgetNickname); //RENVOIE FALSE
        var_dump($forgetPassword);//RENVOIE FALSE

        echo '<p>Vous avez bien été déconnecté, à bientôt sur mon blog</p>'; //S'est bien affiché

        //On redirige vers (quoi d'ailleurs, la liste des chapitres ou la landing page ?)
//        header('Location:');
    }

    public function listUsers() //testé et fonctionne TODO : voir comment sécuriser ça avec if (admin...) ou quelque chose comme
    {
        $this->userManager->readAllMembers();
    }

    public function banUser() //Non testé mais à faire lorsque le back office sera en place car faisable depuis le tableau de gestion membres TODO : voir comment sécurisé, utilisable que par l'admin
    {
        $this->userManager->deleteMember();
    }
}


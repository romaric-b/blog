<?php

//A garder
use App\controller\UserController;
use App\controller\FrontController;

//A effacer après test :
//use App\model\entities\User;

require 'vendor/autoload.php';

try
{
    $userCont = new UserController();
    $frontCont = new FrontController();
    $frontCont->viewHome();


    if (isset($_GET['action']))
    {
        if ($_GET['action'] == 'register')
        {
            var_dump('register ok');
            $userCont->register();
            echo '<p>Inscription bien validées, vous pouvez dès à présent vous connecter : 
                    <a href="/index.php">Connexion</a>
                  </p>';
        }
        elseif ($_GET['action'] == 'login')
        {
            $userCont->login();
        }
    }
    else
    {
        $frontCont->viewHome();
    }
}
catch(Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ***************************************************** PARTIE TEST TEMPORAIRE ********************************************
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//$user = new User( //RegistDate on le passera
//    [
//        'nickname' => '',
//        'email' => 'ggleking@gmail.com',
//        'password' => '1234',
//        'password2' => '1234'
//    ]
//);
//$testPseudo = $user->getNickname();
//
//
//var_dump($testPseudo);
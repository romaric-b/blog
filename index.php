<?php

//A garder
use App\controller\UserController;
use App\controller\FrontController;

//A effacer après test :
//use App\model\entities\User;
use App\model\entities\Post;


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
            $userCont->register();

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
$post = new Post(
    [
        'postTitle' => 'Un titre un peu trop looooonng',
        'postExtract' => 'Un extrait un peu trop long ',
        'postContent' => 'Une longue histoire'
    ]
);

var_dump($post);
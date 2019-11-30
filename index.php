<?php

//A garder
use App\controller\UserController;

//A effacer après test :
//use App\model\entities\User;

require 'vendor/autoload.php';

try
{
    switch(isset($_GET['action']))
    {
        case 'register':
            $userCont = new UserController(); //Comment j'évite ça à chaque fois ? class static ?
            $userCont->register();
            break;

        case 'login':
            $userCont = new UserController(); //Comment j'évite ça à chaque fois ? class static ?
            $userCont->login();
            break;


    }
}
catch(Exception $e)
{ // S'il y a eu une erreur, alors...
    echo 'Erreur : ' . $e->getMessage();
}









//try
//{
//
//    if (isset($_GET['action']))
//    {
//
//
//    }
//    else
//    {
////        listPosts(); //TODO créer class dans PostManager
//    }
//}
//catch(Exception $e)
//{
//    echo 'Erreur : ' . $e->getMessage();
//}



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
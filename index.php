<?php

use App\controller\Controller;
use App\model\entities\User;

require 'vendor/autoload.php';


//use model\entities\User;

//require 'controller\UserController.php';
//
//try
//{
//    if (isset($_GET['action']))
//    {
//
//    }
//    else
//    {
//        listPosts(); //TODO créer class dans PostManager
//    }
//}
//catch(Exception $e)
//{
//    echo 'Erreur : ' . $e->getMessage();
//}

//$maValeur = "Romaric";
//$test = new User( //RegistDate on le passera
//    [
//        'nickname' => htmlspecialchars($_POST['nickname']),
//        'email' => htmlspecialchars($_POST['email']),
//        'password' => htmlspecialchars($_POST['password']),
//        'password' => htmlspecialchars($_POST['password2'])
//    ]
//);

$user = new User( //RegistDate on le passera
    [
        'nickname' => 'gérard',
        'email' => 'ggleking@gmail.com',
        'password' => '1234',
        'password2' => '1234'
    ]
);

echo $user->getNickname();
echo $user->getEmail();
echo $user->getPassword();
echo $user->getPassword2();

//ge
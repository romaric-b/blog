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

$maValeur = "Romaric";
$test = new User(
    ['nickname' => $maValeur]
);
$test->getNickname();

$controller = new Controller();
$controller->testecho();

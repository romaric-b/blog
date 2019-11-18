<?php

require 'vendor/autoload.php';

use App\model\entities\User;
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
$test = new User(
    $user_nickname = 'test'
);
$test->getNickname();
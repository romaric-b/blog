<?php

use App\model\entities\User;

require 'vendor/autoload.php';


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



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ***************************************************** PARTIE TEST TEMPORAIRE ********************************************
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$user = new User( //RegistDate on le passera
    [
        'nickname' => 'gérard',
        'email' => 'ggleking@gmail.com',
        'password' => '1234',
        'password2' => '1234'
    ]
);

var_dump($user);
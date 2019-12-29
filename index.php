<?php

use App\controller\FrontController;
use App\controller\BackController;

require 'vendor/autoload.php';

try
{
    session_start();
    /*Controllers*/
    $backController = new BackController();
    $frontController = new FrontController();

    if (isset($_GET['action']))
    {
        switch ($_GET['action'])
        {
            ////////////////////////////////////////
            //  Front actions
            ///////////////////////////////////////
            case 'register':
                $frontController->register();
                break;
            case 'login':
                $frontController->login();
                break;
            case 'createComment':
                $frontController->createComment($_GET['id']);
                break;
            case 'listPosts':
                $frontController->listPosts();
                break;
            case 'viewPost':
                $frontController->viewPost($_GET['id']);
                break;
            case 'listComments':
                $frontController->listComments();
                break;
            case 'viewComment':
                $frontController->viewComment();
                break;
            case 'updateComment':
                $frontController->updateComment();
                break;
            case 'signalComment':
                $frontController->signalComment($_GET['id']);
                break;
            case 'disconnect':
                $frontController->disconnect();
                break;

                ////////////////////////////////////////
                //  Back actions
                ///////////////////////////////////////
            case 'createPost':
                $backController->createPost();
                break;
            case 'viewHomeDashboard':
                $backController->viewHomeDashboard();
                break;
            case 'listUsers':
                $backController->listUsers();
                break;
            case 'updatePost':
                $backController->updatePost();
                break;
            case 'deletePost':
                $backController->deletePost();
                break;
            case 'deleteComment':
                $backController->deleteComment();
                break;
            case 'banUser':
                $backController->banUser();
                break;
            default:
                var_dump('routeur defaut');
                header('Location: index.php');
                exit;
        }
    }
    else
    {
        require('App/View/home.php');
    }
}
catch(Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}

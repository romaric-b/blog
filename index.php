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
            case 'viewHome':
                $frontController->viewHome();
                break;
            case 'register':
                $frontController->register(); //ok
                break;
            case 'login':
                $frontController->login(); //ok
                break;
            case 'createComment':
                $frontController->createComment($_GET['id']); //ok
                break;
            case 'listPosts':
                $frontController->listPosts(); //ok
                break;
            case 'viewPost':
                $frontController->viewPost($_GET['post']); //ok
                break;
//            case 'listComments':
//                $frontController->listComments();
//                break;
            case 'signalComment':
                $frontController->signalComment($_GET['id']); //ok
                break;
            case 'disconnect':
                $frontController->disconnect(); //ok
                break;

            ////////////////////////////////////////
            //  Back actions
            ///////////////////////////////////////
            case 'createPost':
                $backController->createPost(); //ok
                break;
            case 'viewHomeDashboard':
                $backController->viewHomeDashboard(); //ok
                break;
            case 'viewCommentDashboard':
                $backController->viewCommentDashboard(); //ok
                break;
            case 'viewPostDashboard':
                $backController->viewPostDashboard();
                break;
            case 'viewPostToUpdate':
                $backController->viewPostToUpdate($_GET['post']);
                break;
            case 'viewMemberDashboard':
                $backController->viewMemberDashboard();
                break;
            case 'listUsers':
                $backController->listUsers();
                break;
            case 'updatePost':
                $backController->updatePost($_GET['postId']);
                break;
            case 'unsignalReadedComment':
                $backController->unsignalReadedComment($_GET['commentId']);
                break;
            case 'updateReadedComment':
                $backController->updateReadedComment($_GET['commentId']);
                break;
            case 'deletePost':
                $backController->deletePost($_GET['postId']);
                break;
            case 'deleteComment':
                $backController->deleteComment($_GET['commentId']);
                break;
            case 'banUser':
                $backController->banUser($_GET['userId']);
                break;
            default:
//                var_dump('routeur defaut');
//                header('Location: index.php');
//                $frontController->viewHome();
                $frontController->viewErrorPage();
                exit;
        }
    }
    else
    {
        //landing page
        $frontController->viewHome();
    }
}
catch(Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}

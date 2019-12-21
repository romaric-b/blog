<?php

//A garder
use App\controller\UserController;
use App\controller\FrontController;
use App\controller\CommentController;
use App\controller\PostController;

//A effacer après test :
//use App\model\entities\User;
//use App\model\UserManager;
//use App\model\entities\Post;
//use App\model\PostManager;
//use App\model\entities\Comment;
//use App\model\CommentManager;

require 'vendor/autoload.php';

try
{
    session_start();

    /*Controllers*/
    $userController = new UserController();
    $postsController = new PostController();
    $commentsController = new CommentController();
    $frontController = new FrontController();

    if (isset($_GET['action']))
    {
        switch ($_GET['action'])
        {
            case 'register':
                $userController->register();
                break;
            case 'login':
                $userController->login();
                break;
            case 'listUsers':
                $userController->listUsers();
                break;
            case 'banUser':
                $userController->banUser();
                break;
            case 'disconnect':
                $userController->disconnect();
                break;
            case 'createComment':
                $commentsController->createComment();
                break;
            case 'deleteComment':
                $commentsController->deleteComment();
                break;
            case 'updateComment':
                $commentsController->updateComment();
                break;
            case 'listComments':
                $commentsController->listComments();
                break;
            case 'viewComment':
                $commentsController->viewComment();
                break;
            case 'deletePost':
                $postsController->deletePost();
                break;
            case 'updatePost':
                $postsController->updatePost();
                break;
            case 'createPost':
                $postsController->createPost();
                break;
            case 'listPosts':
                $postsController->listPosts();
                break;
            case 'viewPost':
                $postsController->viewPost();
                break;
            default:
                header('Location: index.php');
                exit;
        }
    }
    else
    {
        $frontController->loadView("home");
    }
}
catch(Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ***************************************************** PARTIE TEST TEMPORAIRE ********************************************
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//$user = new User(
//    [
//        'userId' => '7'
//    ]
//);
//$userManager = new UserManager(); //tout fonctionne
//$userManager->updateMember($user); //fonctionne
//$userManager->deleteMember($user); //fonctionne


//
//var_dump($testPseudo);
//$post = new Post(
//    [
//        'postTitle' => 'Un titre un peu trop looooonng',
//        'postExtract' => 'Un extrait un peu trop long ',
//        'postContent' => 'Une longue histoire'
//    ]
//);
//
//var_dump($post);

//Test Post et PostManager
//$post = new Post(
//    [
//        'postId' => '3',
//        'postTitle' => 'JEEEEJ',
//        'postExtract' => 'Ah ! Les boules noires sont vraiment trop noires !',
//        'postContent' => 'Ca veut dire que les femmes ne savent pas faire de cabanne ?'
//    ]
//);
//
//$postManager = new PostManager();
//$postManager->createPost($post); //fonctionne
//$postManager->readPost($post); //fonctionne
//$postManager->readAllPosts(); //fonctionne
//$postManager->updatePost($post); //fonctionne
//$postManager->deletePost($post); //fonctionne

//Test Comment et CommentManager
//$comment = new Comment(
//    [
//        'commentId' => '2'
//    ]
//);
//var_dump($comment);
//$commentManager = new CommentManager();
//$commentManager->createComment($comment); //fonctionne
//$commentManager->updateComment($comment); //fonctionne
//$commentManager->readComment($comment); //fonctionne
//$commentManager->readAllComments(); //fonctionne

//$commentManager->deleteComment($comment); //fonctionne


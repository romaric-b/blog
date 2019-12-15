<?php

//A garder
use App\controller\UserController;
use App\controller\FrontController;

//A effacer après test :
use App\model\entities\User;
use App\model\UserManager;
//use App\model\entities\Post;
//use App\model\PostManager;
//use App\model\entities\Comment;
//use App\model\CommentManager;

require 'vendor/autoload.php';

//je démarre la session ici pour avoir une portée sur tout le site


try
{
    session_start();
    $userCont = new UserController();
    $frontCont = new FrontController();
    $frontCont->viewHome();

//    $userCont->listUsers(); testé fonctionne


    if (isset($_GET['action']))
    {
        if ($_GET['action'] == 'register')
        {
            $userCont->register();

        }
        if ($_GET['action'] == 'login')
        {
            var_dump('dans login');
            $userCont->login();
        }
        if ($_GET['action'] == 'disconnect')
        {
            var_dump('dans action disconnect');
            $userCont->disconnect();
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


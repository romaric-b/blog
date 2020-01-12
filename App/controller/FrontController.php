<?php

namespace App\controller;

use App\model\entities\User;
use App\model\entities\Post;
use App\model\entities\Comment;
use App\model\UserManager ;
use App\model\CommentManager;
use App\model\PostManager;

class FrontController
{
    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
    }

    /**
     * Register users will be control their nickname, password and confirmation, then
     */
    public function register()
    {
        if(isset($_POST['registForm']))
        {
            $newUser = new User(
                [
                    'nickname' => trim(htmlspecialchars($_POST['registNickname'])),
                    'email' => trim(htmlspecialchars($_POST['registEmail'])),
                    'password' => htmlspecialchars($_POST['registPassword']),
                    'password2' => htmlspecialchars($_POST['registPassword2']),
                    'role' => 'member'
                ]);
            //I call used same nicknames
            $matchedNickname = $this->userManager->readMember($newUser);
            //If nicknames match
            if($matchedNickname > 0)
            {
                $msg = "<p>Ce pseudo est déjà utilisé, choisissez en un autre.
                                <a href=\"index.php?action=viewHome\">Retourner à l'accueil</a>
                              </p>";
                require('App/view/messageView.php');
                return;
            }
            //comparison of passwords entered by the user
            if ($newUser->getPassword() !== $newUser->getPassword2())
            {
                $msg = '<p>Les mots de passe rentrés sont différents. 
                    <a href="index.php?action=viewHome">Retourner à l\'accueil</a>
                  </p>';
                require('App/view/messageView.php');
                return;
            }
            //If my object user as an error interne of entity, it will rapport message
            if ($newUser->getMessage())
            {
                $msg = $newUser->getMessage();
                require('App/view/messageView.php');
                return;

            }
            elseif($newUser->getMessage() == NULL)
            {
                $this->userManager->createMember($newUser);
                $msg = '<p>Inscription validée. 
                    <a href="index.php?action=listPosts">Aller à la liste des chapitres</a>
                  </p>';
                require('App/view/messageView.php');
                return;
            }
            else
            {
                $msg = '<p>Inscription non valide. 
                    <a href="index.php?action=listPosts">Retourner à la liste des chapitres</a>
                  </p>';
                require('App/view/messageView.php');
                return;
            }
        }
    }

    public function login()
    {
        if(isset($_POST['loginForm']))
        {
            $loginUser = new User(
                [
                    'nickname' => trim(htmlspecialchars($_POST['loginNickname'])),
                    'password' => htmlspecialchars($_POST['loginPassword']) //le mot de passe est haché plus tard
                ]);
            //I request matched user
            $matchedUser = $this->userManager->readMember($loginUser);
            if(!$matchedUser)//if user account doesn't exist
            {
                //For security not give exactly information to user
                $msg =  '<p>Mauvais identifiant ou mot de passe.</p>
                                <a href="index.php?action=viewHome">Retourner à l\'accueil</a>';
                require('App/view/messageView.php');
                return;
            }
            else
            {
                //comparison of passwords entered by the user with an eventualy matching from database
                $isPasswordCorrect = password_verify($loginUser->getPassword(), $matchedUser['user_password']);

                if($isPasswordCorrect)
                {
                    $hashLoginUserPass = password_hash($loginUser->getPassword(), PASSWORD_DEFAULT);
                    //I save user informations in session
                    $_SESSION['user_id'] = $matchedUser['user_id'];
                    $_SESSION['user_nickname'] = $loginUser->getNickname();
                    $_SESSION['user_password'] = $hashLoginUserPass;
                    $_SESSION['role'] = $matchedUser['user_role'];

                    if($_SESSION['role'] === 'member')
                    {
                        $msg =  '<p>Vous êtes bien connecté</p>
                                <a href="index.php?action=viewHome">Aller à l\'accueil</a>
                                <a href="index.php?action=listPosts">Aller à la liste des chapitres</a>
                                ';
                        require('App/view/messageView.php');
                        return;
                    }
                    elseif($_SESSION['role'] === 'administrator')
                    {
                        $msg =  '<p>Vous êtes bien connecté</p>
                                <a href="index.php?action=viewHomeDashboard">Aller au tableau de bord</a><br>
                                <a href="index.php?action=listPosts">Aller à la liste des chapitres</a>
                                ';
                    }
                }
                else
                {
                    $msg =  '<p>Mauvais identifiant ou mot de passe.</p>
                             <a href="index.php?action=viewHome">Retourner à l\'accueil</a>';
                    require('App/view/messageView.php');
                    return;
                }
            }
            require('App/view/messageView.php');
        }
    }

    public function disconnect() //fonctionne
    {
        $_SESSION = array();
        session_destroy();
        $msg = '<p>Vous êtes bien déconnecté</p>
                <a href="index.php?action=viewHome">Retourner à l\'accueil</a>';
        require('App/view/messageView.php');
    }

    /**
     * used to view posts
     * @return objects $posts
     */
    public function listPosts()
    {
        $totalPosts = count($this->postManager->readAllPosts());
        $postPerpage = 5;
        $totalPages = ceil($totalPosts/$postPerpage); //ceil around superior number
        if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0)
        {
            $_GET['page'] = intval($_GET['page']);
            $currentPage = $_GET['page'];
        }
        else
        {
            $currentPage = 1;
        }
        $start = ($currentPage - 1)*$postPerpage;
        $posts = $this->postManager->countPost($start, $postPerpage);
        require('App/view/listPosts.php');
    }

    /**
     * to the landing page
     */
    public function viewHome()
    {
        require('App/view/home.php');
    }

    /**
     * view one post
     * @return $post asked
     * @param $post_id post ID
     */
    public function viewPost($postId)
    {
        //request comments of the post
        $comments = $this->commentManager->readCommentsOfPost($postId);
        require('App/view/post.php');
    }

    public function createComment($postId)
    {
        $createdComment = new Comment(
            [
                'commentUserId' => $_SESSION['user_id'],
                'commentContent' => htmlspecialchars($_POST['createCommentContent']),
                'commentPostId' => htmlspecialchars($postId),
                'commentStatus' => 'unsignaled',
                'CommentRead' => 'not read'
            ]
        );
        $this->commentManager->createComment($createdComment);
        $msg =  '<p>Votre commentaire a bien été ajouté</p>
                <a href="index.php?action=viewPost&amp;post='  .  $postId .  '">Retourner au dernier chapitre</a>';
        require('App/view/messageView.php');
    }

    /**
     * the error page if bad URL action
     */
    public function viewErrorPage()
    {
        require('App/view/errorPage.php');
    }

    /**
     * @param $comment_id id of the comment to signal
     */
    public function signalComment($comment_id)
    {
        $signaledComment = new Comment(
            [
                'commentId' => $comment_id,
                'commentStatus' => 'signaled'
            ]
        );
        $this->commentManager->updateSignalComment($signaledComment);
        $msg =  '<p>Le commentaire a bien été signalé et sera éxaminé par l\'aministrateur .</p>
                 <a href="index.php?action=listPosts">Aller à la liste des chapitres</a>';
        require('App/view/messageView.php');
    }
}
?>
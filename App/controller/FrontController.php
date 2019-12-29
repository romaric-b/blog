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
    public $msg;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
    }

    /**
     * Lors de l'inscription, contrôle l'existance des données utilisateur,, les formats, sécurise le pass et vérifier que le pseudo est pas déjà pris.
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
            //je contrôle si le pseudo à déjà été utilisé grace à mon manager
            $matchedNickname = $this->userManager->readMember($newUser);
            //Si les pseudo matchent
            if($matchedNickname > 0)
            {
                echo "Ce pseudo est déjà utilisé, choisissez en un autre";
                header('location: index.php?action=listPosts');
                return;
            }
            //comparaison MDP
            if ($newUser->getPassword() !== $newUser->getPassword2())
            {
                header('location: index.php?action=listPosts');
                return;
            }
            $this->userManager->createMember($newUser);
            echo '<p>Inscription bien validées, vous pouvez dès à présent vous connecter : 
                    <a href="index.php?action=login">Connexion</a>
                  </p>';
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
            //je contrôle si le pseudo à déjà été utilisé grace à mon manager
            $matchedUser = $this->userManager->readMember($loginUser);
            //Si pas d'utilisateur correspondant trouvé
            if(!$matchedUser)
            {
                echo '<p>Mauvais identifiant ou mot de passe !</p>';
            }
            else //Le cas ou le pseudo match avec un existant
            {
                // Comparaison du pass envoyé via le form en param gauche avec celui du matching base en param droit
                $isPasswordCorrect = password_verify($loginUser->getPassword(), $matchedUser['user_password']);

                if($isPasswordCorrect)
                {
                    $hashLoginUserPass = password_hash($loginUser->getPassword(), PASSWORD_DEFAULT);
                    //j'enregistre en session l'id utilisateur le pseudo et le mdp haché
                    $_SESSION['user_id'] = $matchedUser['user_id'];
                    $_SESSION['user_nickname'] = $loginUser->getNickname();
                    $_SESSION['user_password'] = $hashLoginUserPass;
                    $_SESSION['role'] = $matchedUser['user_role']; //servira à rediriger suivant si admin ou membre

                    if($_SESSION['role'] == 'member')
                    {
                        header('location: index.php?action=listPosts');
                    }
                    elseif($_SESSION['role'] == 'administrator')
                    {
                        //TODO transformer ça en header avec un action car les commentaires signalés, la liste des articles, commantires etc... doivent être chargés
//                        require('App/view/home_dashboard.php');
                        header('Location: index.php?action=viewHomeDashboard');
                    }
                }
                else // Mauvais mot de passe
                {
                    echo '<p>Mauvais identifiant ou mot de passe !</p>';
                }
            }
        }
        //TODO prévoir un message de confirmation
    }

    public function disconnect() //fonctionne
    {
        $_SESSION = array();
        session_destroy();
        header('Location: index.php?action=viewHome');
    }

    /**
     * used to view posts
     * @return objects $posts
     */
    public function listPosts()
    {
//        $count = $this->postManager->countPost();
//        var_dump($count);
//
//        $currentPage = $_GET['page'] ?? 1;
//        var_dump($currentPage);
//
//        if(!filter_var($currentPage, FILTER_VALIDATE_INT))
//        {
//            $this->msg='Numéro de page invalide';
//            echo 'Numéro de page invalide';
//        }
//        if($currentPage <= 0)
//        {
//            $this->msg='Numéro de page invalide';
//            echo 'Numéro de page invalide';
//        }
//        if($currentPage === '1')
//        {
//            header('Location: index.php?action=listPosts');
//        }
//        $perPage = 5;
//        $start = $perPage * ($currentPage-1);
//        $pages = ceil($count /$perPage);
//        if ($currentPage > $pages){
//            $this->msg='Cette page n\'existe pas';
//        }
//        $posts = $this->postManager->paginateListPosts($start,$perPage);

        $posts = $this->postManager->readAllPosts();
        require('App/view/listPosts.php');
    }

    /**
     * view one post
     * @return $post asked
     * @param $post_id post ID
     */
    public function viewPost($post_id)
    {
        $post = $this->postManager->readPost($post_id);
        //obtenir aussi les commentaires du post pour cette vue
        $comments = $this->commentManager->readCommentsOfPost($post_id);
        require('App/view/post.php');
    }

    public function createComment($postId)
    {
        $createdComment = new Comment(
            [
                'commentUserId' => '8',
                'commentContent' => htmlspecialchars($_POST['createCommentContent']),
                'commentPostId' => htmlspecialchars($postId),
                'commentStatus' => 'unsignaled',
                'CommentRead' => 'not read'
            ]
        );
        $this->commentManager->createComment($createdComment);
    }

    /**
     * used to view Comments
     * @return objects $Comments
     */
    public function listComments()
    {
        $this->commentManager->readAllComments();
        if($_SESSION['user_role'] = 'member')
        {
//            header('location: index.php?action=listPosts');
        }
        elseif ($_SESSION['user_role'] = 'administrator')
        {
//            header('location: index.php?action=home_dashboard'); //le require se fera sûrement dans l'index
        }
    }

    /**
     * view one Comment
     * @return $Comment asked
     * @param $comment_id comment ID
     */
    public function viewComment($comment_id)
    {
        $this->commentManager->readComment($comment_id);
    }

    /**
     * update a comment
     */
    public function updateComment()
    {
        $updatedComment = new Comment(
            [
                'CommentContent' => htmlspecialchars($_POST['createContent'])
            ]
        );
        //On connait l'ID car il est enregistré en session avant depuis l'article qu'on visionne
        $this->commentManager->updateComment($updatedComment);
    }

    public function signalComment($comment_id)
    {
        $signaledComment = new Comment(
            [
                'commentId' => $comment_id,
                'commentStatus' => 'signaled'
            ]
        );
        $this->commentManager->updateStatusComment($signaledComment);
    }
}
?>
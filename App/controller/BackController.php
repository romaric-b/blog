<?php

namespace App\controller;

use App\model\entities\Comment;
use App\model\entities\Post;
use App\model\PostManager;
use App\model\UserManager;
use App\model\CommentManager;
use http\Header;

class BackController
{
    public $msg;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
    }

    public function listUsers() //testé et fonctionne TODO : voir comment sécuriser ça avec if (admin...) ou quelque chose comme
    {
        $this->userManager->readAllMembers();
        require('App/view/members_dashboard.php');
    }

    public function createPost()
    {
        $createdPost = new Post(
            [
                'postTitle' =>  $_POST['createTitle'],
                'postExtract' => $_POST['createExtract'],
                'postContent' => $_POST['createContent']
            ]
        );

        $this->postManager->createPost($createdPost);

        echo '<p>article envoyé avec succès</p>';
    }

    public function viewHomeDashboard()
    {
        $signaledComments = $this->commentManager->readAllSignaledComments();

        $posts = $this->postManager->readAllPosts(); //A caler dans un tableau à overflow scroll en vertical
        require('App/view/home_dashboard.php');
    }

    public function viewCommentDashboard()
    {
        $comments = $this->commentManager->readAllCommentsForDashboard();
        require('App/view/comments_dashboard.php');
    }

    public function viewPostDashboard()
    {
        $posts = $this->postManager->readAllPosts();
        require('App/view/posts_dashboard.php');
    }

    public function viewMemberDashboard()
    {
        $users = $this->userManager->readAllMembers();
        require('App/view/members_dashboard.php');
    }

    /**
     * used to view posts
     * @return objects $posts
     */
    public function listPostsAdmin()
    {
        $posts = $this->postManager->readAllPosts();
        require('App/view/listPosts.php');
    }

    /**
     * update a post
     */
    public function updatePost()
    {
        //1 lire le post en question et tenter afficher


        $updatedPost = new Post(
            [
                'postTitle' =>  htmlspecialchars($_POST['createTitle']),
                'postExtract' => htmlspecialchars($_POST['createExtract']),
                'postContent' => htmlspecialchars($_POST['createContent'])
            ]
        );
        $this->postManager->updatePost($updatedPost);
    }

    /**
     * Update a comment on moderated status
     * @param $comment_id
     */
    public function unsignalReadedComment($comment_id)
    {
        $signaledComment = new Comment(
            [
                'commentId' => $comment_id,
                'commentStatus' => 'moderated',
                'commentRead' => 'read'
            ]
        );
        $this->commentManager->updateStatusComment($signaledComment);
    }

    /**
     * Update a comment on moderated status
     * @param $comment_id
     */
    public function updateReadedComment($comment_id)
    {
        $readedComment = new Comment(
            [
                'commentId' => $comment_id,
                'commentRead' => 'read'
            ]
        );
        var_dump($readedComment);
        $this->commentManager->updateReadedComment($readedComment);
    }

    /**
     * Delete one post
     * $post asked
     * @param $post_id post ID
     */
    public function deletePost($post_id)
    {
        $this->postManager->deletePost($post_id);
    }

    /**
     * Delete one comment
     * $comment asked
     * @param $comment_id comment ID
     */
    public function deleteComment($comment_id)
    {
        $this->commentManager->deleteComment($comment_id);
    }

    public function banUser($user_id) //Non testé mais à faire lorsque le back office sera en place car faisable depuis le tableau de gestion membres TODO : voir comment sécurisé, utilisable que par l'admin
    {
        $this->userManager->deleteMember($user_id);
        echo 'Le membre a été supprimé avec succès';
        header('location: index.php?action=viewMemberDashboard');
    }
}
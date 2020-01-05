<?php

namespace App\controller;

use App\model\entities\Comment;
use App\model\entities\Post;
use App\model\PostManager;
use App\model\UserManager;
use App\model\CommentManager;
//use http\Header;

class BackController
{
    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();
        $this->postManager = new PostManager();
    }

    public function listUsers()
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
        $msg =  '<p>Le nouvel article a bien été crée.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewPostDashboard">Aller à la gestion des articles</a>
                 ';
        require('App/view/messageView.php');
    }

    public function viewHomeDashboard()
    {
        $signaledComments = $this->commentManager->readAllSignaledComments();
        $posts = $this->postManager->readAllPosts();
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
     * @param $postId id of the post to update
     */
    public function viewPostToUpdate($postId)
    {
        require('App/view/postToUpdate.php');
    }

    /**
     * update a post
     * @param $postId id of post to update
     */
    public function updatePost($postId)
    {
        $updatedPost = new Post(
            [
                'postId' => $postId,
                'postTitle' =>  htmlspecialchars($_POST['updateTitle']),
                'postExtract' => $_POST['updateExtract'],
                'postContent' => $_POST['updateContent']
            ]
        );
        $this->postManager->updatePost($updatedPost);
        $msg =  '<p>L\'article a bien été modifié.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewPostDashboard">Aller à la gestion des articles</a>
                 ';
        require('App/view/messageView.php');
    }

    /**
     * Update a comment on moderated status. For comment whose been signaled and administrator want unsignal
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
        $msg =  '<p>Le commantaire a bien été modéré.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewCommentDashboard">Aller à la gestion des commentaires</a>
                 ';
        require('App/view/messageView.php');
    }

    /**
     * Update a comment on read status
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
        $this->commentManager->updateReadedComment($readedComment);
        $msg =  '<p>Le commantaire a bien été marqué comme lu.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewCommentDashboard">Aller à la gestion des commentaires</a>
                 ';
        require('App/view/messageView.php');
    }

    /**
     * Delete one post
     * $post asked
     * @param $post_id post ID
     */
    public function deletePost($post_id)
    {
        $this->postManager->deletePost($post_id);
        $msg =  '<p>L\'article a bien été supprimé.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewPostDashboard">Aller à la gestion des articles</a>
                 ';
        require('App/view/messageView.php');
    }

    /**
     * Delete one comment
     * $comment asked
     * @param $comment_id comment ID
     */
    public function deleteComment($comment_id)
    {
        $this->commentManager->deleteComment($comment_id);
        $msg =  '<p>Le commantaire a bien été effacé.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewCommentDashboard">Aller à la gestion des commentaires</a>
                 ';
        require('App/view/messageView.php');
    }

    /**
     * delete a user of database
     * @param $user_id id of the choised user
     */
    public function banUser($user_id)
    {
        $this->userManager->deleteMember($user_id);
        $msg =  '<p>Le membre a bien été bannis.</p>
                 <a href="index.php?action=viewHomeDashboard">Aller sur le tableau de bord</a>
                 <a href="index.php?action=viewMemberDashboard">Aller à la gestion des membres</a>
                 ';
        require('App/view/messageView.php');
    }
}
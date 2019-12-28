<?php


namespace App\controller;

use App\model\entities\Comment;
use App\model\CommentManager;
use App\controller\FrontController;

class CommentController
{
    public $msg;

    public function __construct()
    {
        $this->commentManager = new CommentManager();
        $this->frontController = new FrontController();
    }

    public function createComment($postId)
    {
        $createdComment = new Comment(
            [
//                'commentUserId' => $_SESSION['user_id'],
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
        //On connait l'ID car il est enregistré en session avant depuis l'article qu'on visionne TODO un article vue doit passer en session
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
        var_dump($signaledComment);
        $this->commentManager->updateStatusComment($signaledComment);
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
}
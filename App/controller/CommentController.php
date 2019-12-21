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

    public function createComment()
    {
        $createdComment = new Comment(
            [
                'commentUserId' => $_SESSION['user_id'],
                'commentContent' => htmlspecialchars($_POST['createCommentContent'])
            ]
        );
        //Je contrôle s'il n'y a pas déjà un chapitre portant le même titre pour éviter un double Comment
        $matchedComment = $this->postManager->readComment($createdComment);

        if($matchedComment > 0)
        {
            return $this->msg = "Vous avez déjà posté un article comportant ce titre";
        }
        $this->commentManager->createComment($createdComment);
        $this->frontController->loadView("post");
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
        $this->frontController->loadView("comments_dashboard");
    }

    /**
     * view one Comment
     * @return $Comment asked
     * @param $comment_id comment ID
     */
    public function viewComment($comment_id)
    {
        $this->commentManager->readComment($comment_id);
        $this->frontController->loadView("comment");
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
        $this->frontController->loadView("comment");
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
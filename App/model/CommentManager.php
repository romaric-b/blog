<?php


namespace App\model;

use App\model\entities\Comment;

class CommentManager extends Manager
{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          CREATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /**
     * Insert object Comment on database
     * @param Comment $comment object of type class Comment
     */
    public function createComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('
INSERT INTO blog_comments (comment_date, comment_status, comment_content, comment_post_id, comment_user_id, comment_read)
    VALUES (NOW(), :status, :content, :comment_post_id, :comment_user_id, :comment_read)');

        $req->execute([
            'status' => $comment->getCommentStatus(),
            'content' => $comment->getCommentContent(),
            'comment_post_id' => $comment->getCommentPostId(),
            'comment_user_id' => $comment->getCommentUserId(),
            'comment_read' => $comment->getCommentRead()
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * INNER JOIN (example : for comments in a post view)
     * join comments of a post
     * @param $postId id of the post
     * @return array ojects $comments
     */
    public function readCommentsOfPost($postId)
    {
        $req = $this->dbConnect()->prepare('SELECT comment_id, comment_content, comment_status, user_nickname AS author, comment_post_id,
        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\') AS comment_date_fr FROM blog_comments 
        INNER JOIN blog_user ON comment_user_id = user_id
        INNER JOIN blog_posts ON comment_post_id = post_id
        WHERE comment_post_id = ? ORDER BY comment_date DESC');

        $comments = [];
        $req->execute(array($postId));
        //PDO runs the lines as long as there are results
        while ($comment = $req->fetchObject('\App\model\entities\Comment'))
        {
            //Save result in an array
            $comments[] = $comment;
        }
        return $comments;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Request All signaled comments with their posts and authors associated
     * @return false|\PDOStatement
     */
    public function readAllSignaledComments()
    {
        $req = $this->dbConnect()->query('SELECT comment_id, comment_content, 
        user_nickname AS author, comment_post_id, post_title AS comment_post_title, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\') 
        AS comment_date_fr FROM blog_comments 
        INNER JOIN blog_user ON comment_user_id = user_id
        INNER JOIN blog_posts ON comment_post_id = post_id
        WHERE comment_status = "signaled"
        GROUP BY comment_id ORDER BY comment_date DESC');

        $comments = [];
        //PDO runs the lines as long as there are results
        while ($comment = $req->fetchObject('\App\model\entities\Comment'))
        {
            //Save result in an array
            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * Request all comments for the admin dashboard
     * @return false|\PDOStatement
     */
    public function readAllCommentsForDashboard()
    {
        $req = $this->dbConnect()->query('SELECT comment_id, comment_content, comment_status, comment_read,
        user_nickname AS author, comment_post_id, post_title AS comment_post_title,DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin\')
        AS comment_date_fr FROM blog_comments 
        INNER JOIN blog_user ON comment_user_id = user_id
        INNER JOIN blog_posts ON comment_post_id = post_id
        GROUP BY comment_id ORDER BY comment_date DESC');

        $comments = [];
        //PDO runs the lines as long as there are results
        while ($comment = $req->fetchObject('\App\model\entities\Comment'))
        {
            //Save result in an array
            $comments[] = $comment;
        }
        return $comments;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Update only status status of comment
     * @param Comment $comment the comment to update
     * @return bool true success | false fail
     */
    public function updateSignalComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_comments set comment_status = :status WHERE comment_id = :comment_id LIMIT 1'); //Limit 1 for secure update only 1 object

        $req->execute([
            'status' => $comment->getCommentStatus(),
            'comment_id' => $comment->getCommentId()
        ]);

        return $req->execute();
    }

    /**
     * To change status of a comment. Exemple : if Administrator want unsignal an already readed comment
     * @param Comment $comment
     * @return bool true success | false fail
     */
    public function updateStatusComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_comments set comment_status = :status, comment_read = :readed WHERE comment_id = :comment_id LIMIT 1'); //Limit 1 for secure update only 1 object

        $req->execute([
            'status' => $comment->getCommentStatus(),
            'readed' => $comment->getCommentRead(),
            'comment_id' => $comment->getCommentId()
        ]);

        return $req->execute();
    }


    /**
     * Update readed status of a comment
     * @param Comment $comment object of type Class Comment
     * @return boolean true for success | false for error
     */
    public function updateReadedComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_comments set comment_read = :comment_read WHERE comment_id = :comment_id LIMIT 1'); //Limit 1 for secure update only 1 object

        $req->execute([
            'comment_read' => $comment->getCommentRead(),
            'comment_id' => $comment->getCommentId()
        ]);

        return $req->execute();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          DELETE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Delete a comment in database
     * @param Comment $comment objet de type Comment
     * @return boolean true for success | false for error
     */
    public function deleteComment($comment_id)
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_comments WHERE comment_id = ?');

        $req->execute(array($comment_id));

        return $req->execute();
    }
}
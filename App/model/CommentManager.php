<?php


namespace App\model;

use App\model\entities\Comment;

class CommentManager extends Manager //testé et fonctionne
{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          CREATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /**
     * Insert un objet Comment dans la bdd et met à jour l'objet passé en argument en lui spécifiant un identifiant (id)
     * @param Comment $comment objet de type Comment
     * @return boolean true si l'objet a bien été inséré, false si une erreur survient
     */
    public function createComment(Comment $comment) //Pas le choix si je veux pas de bordel dans le code comment_user_id sera coonnu à partir d'un cooki
    {
        var_dump('createComment ok');

        $req = $this->dbConnect()->prepare('
INSERT INTO blog_comments (comment_date, comment_status, comment_content, comment_post_id, comment_user_id, comment_read)
    VALUES (NOW(), :status, :content, :comment_post_id, :comment_user_id, :comment_read)'); //A savoir je peux mettre ce que je veux dans les values il faut juste quelque chose de parlant : extract semble réservé en sql donc j'écris excerpt

        //array( 'clé' => 'valeur' , ... ) qui sera plus lisible et compréhensible
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
     * Récupère un objet Comment à partir de son titre
     * @param Comment $comment objet de type Comment
     * @return bool
     */
    public function readComment($comment_id) //ou $comment_Id pour un Id de commentaire précis requêté
    {
        //J'affecte à ma variable pdoStatement le résultat de la préparation de cette requête
        $req = $this->dbConnect()->prepare("SELECT * FROM blog_comments WHERE comment_id = :comment_id");

        $req->execute([
            'comment_id' => $comment_id
        ]);
        $comment = $req->fetchObject('\App\model\entities\Comment');

        return $comment;
    }

    //INNER JOIN (example : for comments in a post view)
    public function readCommentsOfPost($postId)
    {
        $req = $this->dbConnect()->prepare('SELECT comment_id, comment_content, user_nickname AS author, comment_post_id,
        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM blog_comments 
        INNER JOIN blog_user ON comment_user_id = user_id
        INNER JOIN blog_posts ON comment_post_id = post_id
        WHERE comment_post_id = ? ORDER BY comment_date DESC');

//        $req->execute(array($postId));
//        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
//            '\App\model\entities\Comment');
//        $comments = $req->fetchAll();

        $comments = [];

        $req->execute(array($postId));
        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas false
        while ($comment = $req->fetchObject('\App\model\entities\Comment')) {
            //je stocke dans le tableau chaque $comment correspondant aux lignes en bdd
            $comments[] = $comment;
        }
//        var_dump($comments);
        return $comments;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Récupère tous les objets Comment de la bdd
     *
     * @return array|boolean : tableau d'objets comment ou un tableau vide s'il n'y a aucun objet en bdd, ou false si une erreur survient
     */
    public function readAllComments()
    {
        $req = $this->dbConnect()->query('SELECT * FROM blog_comments ORDER BY comment_id DESC');
        $comments = [];

        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas user false
        while ($comment = $req->fetchObject('\App\model\entities\Comment')) {
            //je stocke dans le tableau chaque $comment correspondant aux lignes en bdd
            $comments[] = $comment;
        }
        return $comments;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Pour que l'admin différencie les commentaires lus et nons lus
    /**
     * Met à jour un objet stocké en bdd
     * @param Comment $comment objet de type Comment
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function updateReadComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_comments set comment_read = :comment_read WHERE comment_id = :comment_id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

        //liaison des paramètres à leurs valeurs
        $req->execute([
            'content' => $comment->getCommentContent(),
            'status' => $comment->getCommentStatus(),
            'comment_read' => $comment->getCommentRead(),
            'comment_id' => $comment->getCommentId() //Putain ce con me retourne pas d'erreur (il me retourne rien) si je me trompe d'id, bizarre
        ]);

        //exécution de la requête
        //POSSIBLEMENT EN TROP :
        return $req->execute(); //renverra true si ça a fonctionné false si ça n'est pas le cas
    }

    //Pour qu'un membre signale un commentaire ou pour passer le statut sur modéré si l'admin
    public function updateStatusComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_comments set comment_status = :status WHERE comment_id = :comment_id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

        //liaison des paramètres à leurs valeurs
        $req->execute([
            'status' => $comment->getCommentStatus(),
            'comment_id' => $comment->getCommentId() //Putain ce con me retourne pas d'erreur (il me retourne rien) si je me trompe d'id, bizarre
        ]);

        //exécution de la requête
        //POSSIBLEMENT EN TROP :
        return $req->execute(); //renverra true si ça a fonctionné false si ça n'est pas le cas
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          DELETE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Supprime un objet stocké en bdd
     * @param Comment $comment objet de type Comment
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function deleteComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_comments WHERE comment_id = :comment_id LIMIT 1'); //LIMIT 1 signifie que lors de l\'update ceci ne peut s\'appliquer qu\'à UNE SEULE ligne ce qui limite fortement les erreurs possibles

        $req->execute([
            'comment_id' => $comment->getCommentId()
        ]);

        //exécution de la requête
        return $req->execute();
    }
}
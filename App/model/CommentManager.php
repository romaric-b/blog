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
    public function readComment(Comment $comment)
    {
        //J'affecte à ma variable pdoStatement le résultat de la préparation de cette requête
        $req = $this->dbConnect()->prepare("SELECT * FROM blog_comments WHERE comment_id = :comment_id");

        $req->execute([
            'comment_id' => $comment->getCommentId()
        ]);
        $comment = $req->fetch();

        return $comment;
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
        $req = $this->dbConnect()->query('SELECT * FROM blog_comments ORDER BY comment_id');
        $comments = [];

        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas user false
        while ($comment = $req->fetchObject('\App\model\entities\Comment')) {
            //je stocke dans le tableau chaque $comment correspondant aux lignes en bdd
            $comments[] = $comment;
        }
        var_dump($comments);
        return $comments;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // * A savoir create et update pourraient être réunies en une seule méthode (save)
    /**
     * Met à jour un objet stocké en bdd
     * @param Comment $comment objet de type Comment
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function updateComment(Comment $comment)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_comments set comment_content = :content, comment_status = :status , comment_read = :comment_read, comment_date = NOW() WHERE comment_id = :comment_id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

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
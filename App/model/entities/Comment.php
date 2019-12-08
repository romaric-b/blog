<?php


namespace App\model\entities;


class Comment //test unitaire ok restera les données dynamiques (jointures, dates, auteur id etc)
{
    /**
     * @var int $comment_id
     * @var string enum('unsignaled' || 'signaled' || 'moderated') $comment_status
     * @var datetime $comment_date
     * @var string $comment_content
     * @var int $comment_post_id foreign key
     * @var int $comment_user_id foreign key
     * @var string enum('read' || 'not read')
     */
    private $comment_id;
    private $comment_status;
    private $comment_date;
    private $comment_content;
    private $comment_post_id; //foreign key
    private $comment_user_id; //foreign key
    private $comment_read;

    public $msg;

    public function __construct(array $datas = array())
    {
        //On hydrate pas un tableau de données vide
        if (!empty($datas))
        {
            $this->hydrate($datas);
        }
    }

    //// Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).
    ///
    /// PARCOURS du tableau $datas (avec pour clé $key et pour valeur $value)
    //  On assigne à $setter la valeur « 'set'.$key », en mettant la 
    //  première lettre de $key en majuscule (utilisation de ucfirst())
    //  SI la méthode set$key de notre classe existe ALORS
    //    On invoque set$key($valeur)
    //  FIN SI
    //FIN PARCOURS
    public function hydrate(array $datas) //Et si j'ai bien compris, ça rend les setters autoexecutants comme on pouvait faire en JS lorsqu'on appelait une méthode dans son constructeur
    {
        foreach ($datas as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
                // il existe on peut l'appeler
                $this->$method($value);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         SETTERS : affecter une valeur à une propriété d'objet private
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////
    // VERIFICATIONS : En théorie la seule input utilisateur est le comment_content
    //////////////
    ///
    /**
     * @param mixed $comment_id
     */
    public function setCommentId($comment_id)
    {
        $this->comment_id = $comment_id;
    }

    /**
     * @param mixed $comment_status
     */
    public function setCommentStatus($comment_status)
    {
        $this->comment_status = $comment_status;
    }

    /**
     * @param mixed $comment_date
     */
    public function setCommentDate($comment_date)
    {
        $this->comment_date = $comment_date;
    }

    /**
     * @param mixed $comment_content
     */
    public function setCommentContent($comment_content) // TODO voir si limite de caractère à prévoir, genre 500 caractères
    {
        if(isset($comment_content) && !empty($comment_content) && is_string($comment_content) && strlen($comment_content) <= 500)
        {
            $this->comment_content = $comment_content;
        }
        else
        {
            return $this->msg = 'Le format ou la longueur de votre commentaire n\'est pas correct';
        }
    }

    /**
     * @param mixed $comment_post_id
     */
    public function setCommentPostId($comment_post_id) //clé étrangère
    {
        $this->comment_post_id = $comment_post_id;
    }

    /**
     * @param mixed $comment_user_id
     */
    public function setCommentUserId($comment_user_id) //clé étrangère
    {
        $this->comment_user_id = $comment_user_id;
    }

    /**
     * @param mixed $comment_read
     */
    public function setCommentRead($comment_read)
    {
        $this->comment_read = $comment_read;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //      GETTERS méthode chargée de renvoyer la valeur d'un attribut
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->comment_id;
    }

    /**
     * @return mixed
     */
    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->comment_date;
    }

    /**
     * @return mixed
     */
    public function getCommentContent()
    {
        return $this->comment_content;
    }

    /**
     * @return mixed
     */
    public function getCommentPostId()
    {
        return $this->comment_post_id;
    }

    /**
     * @return mixed
     */
    public function getCommentUserId()
    {
        return $this->comment_user_id;
    }

    /**
     * @return mixed
     */
    public function getCommentRead()
    {
        return $this->comment_read;
    }
}
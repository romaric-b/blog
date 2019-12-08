<?php


namespace App\model\entities;


class Post //Testé et fonctionne
{

    private $post_id;
    private $post_title;
    private $post_extract;
    private $post_content;
    private $post_date;

    public $msg;


    public function __construct(array $datas = array())
    {
        //On hydrate pas un tableau de données vide
        if (!empty($datas))
        {
            $this->hydrate($datas);
        }
    }

    public function hydrate(array $datas)
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

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id) //Normalement pas besoin
    {
        $this->post_id = $post_id;
    }

    /**
     * @param mixed $post_title
     */
    public function setPostTitle($post_title)
    {
        if(isset($post_title))
        {
            if(!empty($post_title))
            {
                if(is_string($post_title) && strlen($post_title) <= 100)
                {
                    $this->post_title = $post_title;
                }
                else
                {
                    return $this->msg = 'Le titre est trop long';
                }
            }
        }
    }

    /**
     * @param mixed $post_extract
     */
    public function setPostExtract($post_extract)
    {
        if(isset($post_extract))
        {
            if(!empty($post_extract))
            {
                if(is_string($post_extract))
                {
                    $this->post_extract = $post_extract;
                }
                else
                {
                    return $this->msg = 'Erreur sur le format de cet extrait';
                }
            }
        }
    }

    /**
     * @param mixed $post_content
     */
    public function setPostContent($post_content)
    {
        if(isset($post_content))
        {
            if(!empty($post_content))
            {
                if(is_string($post_content))
                {
                    $this->post_content = $post_content;
                }
                else
                {
                    return $this->msg = 'Erreur sur le format du contenu de l\'article';
                }
            }
        }

    }

    /**
     * @param mixed $post_date
     */
    public function setPostDate($post_date)
    {
        $this->post_date = $post_date;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //      GETTERS méthode chargée de renvoyer la valeur d'un attribut
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @return mixed
     */
    public function getPostTitle()
    {
        return $this->post_title;
    }

    /**
     * @return mixed
     */
    public function getPostExtract()
    {
        return $this->post_extract;
    }

    /**
     * @return mixed
     */
    public function getPostContent()
    {
        return $this->post_content;
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->post_date;
    }
}
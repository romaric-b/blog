<?php


namespace App\model\entities;


class Post
{

    private $post_id;
    private $post_title;
    private $post_extract;
    private $post_content;
    private $post_date;

    public $msg;


    public function __construct(array $datas = array())
    {
        if (!empty($datas))
        {
            $this->hydrate($datas);
        }
    }

    /**
     * @param array $datas setted to my entity's parameters
     */
    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
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
    public function setPostId($post_id)
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
                    $this->msg = 'Le titre est trop long';
                    return;
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
                    $this->msg = 'Erreur sur le format de cet extrait';
                    return;
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
                    $this->msg = 'Erreur sur le format du contenu de l\'article';
                    return;
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
    //      GETTERS
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

    public function getMessage()
    {
        return $this->msg;
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->post_date;
    }
}
<?php


namespace App\model;

use App\model\entities\Post;

class PostManager extends Manager //testé entièrement et fonctionne
{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          CREATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Insert post object in database
     * @param Post $post object of type Class Post
     */
    public function createPost(Post $post)
    {
        $req = $this->dbConnect()->prepare('
INSERT INTO blog_posts (post_title, post_extract, post_content, post_date)
    VALUES (:title, :excerpt, :content, NOW())');

        $req->execute([
            'title' => $post->getPostTitle(),
            'excerpt' => $post->getPostExtract(),
            'content' => $post->getPostContent()
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @return post object in database
     * @param $post_Id property id of a post object
     */
    public function readPost($post_Id)
    {
        $req = $this->dbConnect()->prepare("SELECT * FROM blog_posts WHERE post_id = :post_id");

        $req->execute(array('post_id' => $post_Id));
        $post = $req->fetchObject('\App\model\entities\Post');

        return $post;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Receive all posts of database
     * @return array which contains $post
     */
    public function readAllPosts()
    {
        $req = $this->dbConnect()->query('SELECT * FROM blog_posts ORDER BY post_id DESC');
        $posts = [];
        while($post = $req->fetchObject('\App\model\entities\Post'))
        {
            $posts[] = $post;
        }
        return $posts;
    }

    /**
     * receive the articles according to the desired pagination
     * @param $start number start post to display
     * @param $postPerpage number of post per page
     * @return array
     */
    public function countPost($start, $postPerpage)
    {
        $req = $this->dbConnect()->query('SELECT * FROM blog_posts ORDER BY post_id DESC LIMIT '. $start .',' .$postPerpage);
        while($post = $req->fetchObject('\App\model\entities\Post'))
        {
            $posts[] = $post;
        }
        return $posts;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Update a post in database
     * @param Post $post object of Class Post type
     * @return boolean true success | false fail
     */
    public function updatePost(Post $post)
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_posts set post_id = :post_id, post_title = :title, post_extract = :excerpt , post_content = :content, post_date=NOW() WHERE post_id = :post_id LIMIT 1'); //LIMIT 1 for security update only 1 post

        $req->execute([
            'post_id' => $post->getPostId(),
            'title' => $post->getPostTitle(),
            'excerpt' => $post->getPostExtract(),
            'content' => $post->getPostContent()
        ]);

        return $req->execute();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          DELETE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Delete post in database
     * @param $post_id id of the post to delete
     * @return boolean true success | false fail
     */
    public function deletePost($post_id)
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_posts WHERE post_id = ? LIMIT 1');//LIMIT 1 for security update only 1 post
        $req->execute(array($post_id));
        return $req->execute();
    }
}
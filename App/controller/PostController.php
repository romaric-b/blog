<?php


namespace App\controller;

use App\model\entities\Post;
use App\model\PostManager;
use App\controller\FrontController;

class PostController //TODO a tester
{
    public $msg;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->frontController = new FrontController();
    }

    public function createPost()
    {
        $createdPost = new Post(
            [
                'postTitle' =>  htmlspecialchars($_POST['createTitle']),
                'postExtract' => htmlspecialchars($_POST['createExtract']),
                'postContent' => htmlspecialchars($_POST['createContent'])
            ]
        );
        //Je contrôle s'il n'y a pas déjà un chapitre portant le même titre pour éviter un double post
        $matchedPost = $this->postManager->readPost($createdPost);

        if($matchedPost > 0)
        {
            return $this->msg = "Vous avez déjà posté un article comportant ce titre";
        }
        $this->postManager->createPost($createdPost);
        $this->frontController->loadView("create_post");
    }

    /**
     * used to view posts
     * @return objects $posts
     */
    public function listPosts()
    {
        $posts = $this->postManager->readAllPosts(); //return $posts
        //var_dump($posts); //posts OK
//        $this->frontController->loadView("listPosts");
        require('App/view/listPosts.php');
    }

    /**
     * view one post
     * @return $post asked
     * @param $post_id post ID
     */
    public function viewPost($post_id)
    {
        $post = $this->postManager->readPost($post_id); //Toute la liste est chargée déjà à partir de la base dans ce contexte
        var_dump($post);
        require('App/view/post.php');
    }

    /**
     * update a post
     */
    public function updatePost()
    {
        $updatedPost = new Post(
            [
                'postTitle' =>  htmlspecialchars($_POST['createTitle']),
                'postExtract' => htmlspecialchars($_POST['createExtract']),
                'postContent' => htmlspecialchars($_POST['createContent'])
            ]
        );
        //On connait l'ID car il est enregistré en session avant depuis l'article qu'on visionne TODO un article vue doit passer en session
        $this->postManager->updatePost($updatedPost);
        $this->frontController->loadView("create_post");
    }

    /**
     * Delete one post
     * $post asked
     * @param $post_id post ID
     */
    public function deletePost($post_id)
    {
        $this->postManager->deletePost($post_id);
        $this->frontController->loadView("posts_dashboard");

    }
}
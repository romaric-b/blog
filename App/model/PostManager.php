<?php


namespace App\model;

use App\model\entities\Post;

class PostManager extends Manager
{

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          CREATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /**
     * Insert un objet Post dans la bdd et met à jour l'objet passé en argument en lui spécifiant un identifiant (id)
     * @param Post $post objet de type Post
     * @return boolean true si l'objet a bien été inséré, false si une erreur survient
     */
    public function createPost(Post $post)
    {
        var_dump('createPost ok');

        $req = $this->dbConnect()->prepare('
INSERT INTO blog_posts (post_title, post_extract, post_content, post_date)
    VALUES (:title, :excerpt, :content, NOW())'); //A savoir je peux mettre ce que je veux dans les values il faut juste quelque chose de parlant : extract semble réservé en sql donc j'écris excerpt

        //array( 'clé' => 'valeur' , ... ) qui sera plus lisible et compréhensible
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
     * Récupère un objet post à partir de son titre
     * @param Post $post objet de type Post
     * @return bool
     */
    public function readPost(Post $post)
    {
        //J'affecte à ma variable pdoStatement le résultat de la préparation de cette requête
        $req = $this->dbConnect()->prepare("SELECT * FROM blog_posts WHERE post_title = :title");

        $req->execute([
            'title' => $post->getPostTitle()
        ]);
        $post = $req->fetch();

        return $post;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          READ : ALL
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Récupère tous les objets Post de la bdd
     *
     * @return array|boolean : tableau d'objets post ou un tableau vide s'il n'y a aucun objet en bdd, ou false si une erreur survient
     */
    public function readAllPosts()
    {
        $req = $this->dbConnect()->query('SELECT * FROM blog_posts ORDER BY post_id');
        $posts = [];

        //pdo va parcourir les lignes tant qu'il ne tombera pas sur un cas post false
        while($post = $req->fetchObject('\App\model\entities\Post'))
        {
            //je stocke dans le tableau chaque $post correspondant aux lignes en bdd
            $posts[] = $post;
        }
        var_dump($posts);
        return $posts;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          UPDATE
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // * A savoir create et update pourraient être réunies en une seule méthode (save)
    /**
     * Met à jour un objet stocké en bdd
     * @param Post $post objet de type Post
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function updatePost(Post $post)//TODO a tester une fois le back office en place
    {
        $req = $this->dbConnect()->prepare('UPDATE blog_posts set post_title=:title, post_extract=:excerpt , post_content=:content, post_date=NOW() WHERE post_id =:id LIMIT 1'); //LIMIT 1 signifie que lors de l'update ceci ne peut s'appliquer qu'à UNE SEULE ligne ce qui limite fortement les erreurs de MAJ possible

        //liaison des paramètres à leurs valeurs
        $req->execute([
            'post_title' => $post->getPostTitle(),
            'excerpt' => $post->getPostExtract(),
            'content' => $post->getPostContent()
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
     * @param Post $post objet de type Post
     * @return boolean true en cas de succès ou false en cas d'erreur
     */
    public function deletePost(Post $post)//TODO a tester une fois le back office en place
    {
        $req = $this->dbConnect()->prepare('DELETE FROM blog_posts WHERE post_id=:id LIMIT 1'); //LIMIT 1 signifie que lors de l\'update ceci ne peut s\'appliquer qu\'à UNE SEULE ligne ce qui limite fortement les erreurs possibles

        //Méthode de PDO statement, le paramètre en méthode abstraite permet entre autre de sécuriser le type de donné, ici un INT
        $req->bindValue(':id', $post->getPostId(), PDO::PARAM_INT);

        //exécution de la requête
        return $req->execute();
    }
}
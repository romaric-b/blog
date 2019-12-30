<?php

$title = 'Tableau de bord : Chapitres'; ?>

<?php ob_start(); ?>

<h2>Les articles de votre blog</h2>

<table class="text-center table-striped table-borderless table-responsive table w-100 d-block d-sm-table d-md-table">
    <thead class="thead-dark">
    <tr>
        <th>Titre</th>
        <th>Extrait</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
    </thead>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= htmlspecialchars($post->getPostTitle())?></td>
            <td><?=$post->getPostExtract()?></td>
            <td><?=$post->getPostDate()?></td>
            <td class="btn-group" role="group" aria-label="actions">
                <a href="index.php?action=updatePost&amp;postId=<?=$post->getPostId()?>" class="btn btn-secondary p-1">modifier article</a>
                <?php $_SESSION['post' . $post->getPostId()] = $post;?>
                <a class="nav-link" target="_blank" href="index.php?action=viewPost&amp;postId=<?=$post->getPostId()?>">Lire l'article</a>
                <a href="index.php?action=deletePost&amp;postId=<?=$post->getPostId()?>" class="btn btn-danger p-1">Effacer article</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<section>
    <form action="index.php?action=createPost" method="POST" class="flex-column">
        <label for="post_title">Titre :
            <input id="post_title" name="createTitle" id="title">
        </label>
        <label for="post_extract">Rédigez un extrait de votre article :
            <textarea class="tinymce-edition" id="post_extract" name="createExtract">
            </textarea>
        </label>
        <label for="post_content">Rédigez le contenu de votre article :
            <textarea class="tinymce-edition" id="post_content" name="createContent">
            </textarea>
        </label>
        <p>
            <input type="submit"  value="Valider"/>
        </p>
    </form>

</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

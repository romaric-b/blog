<?php

$title = 'Blog de Jean Forteroche : Chapitres'; ?>

<?php ob_start(); ?>
<h2>liste des articles</h2>

    <article>
        <h3>
            <?=$post->getPostTitle()?>
            <?=$post->getPostDate() ?>
        </h3>
        <p>
            <?=$post->getPostContent()?>
        </p>
    </article>

<!--Edition du commentaire -->




<!--Commentaires existants -->
<?php foreach ($comments as $comment): ?>

    <div>
        <h3>

            <?=$comment->getCommentDate()?>

            <?=$comment->getCommentContent()?>


        </h3>
        <p>
            <?=$comment->getPostExtract()?>

        </p>
    </div>


<?php endforeach; ?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

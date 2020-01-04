<?php

$title = 'Blog de Jean Forteroche : Chapitres'; ?>

<?php ob_start();
$post = $_SESSION['post' . $postId];
//unset($_SESSION['post' . $postId]);
?>


<h2>Article</h2>
<section>
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
<?php if(isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['user_nickname'])): ?>
    <h2>Commentaires</h2>
    <form action="index.php?action=createComment&amp;id=<?= $post->getPostId() ?>" method="post">
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label for="message">Commentaire</label>
                <textarea rows="5" class="form-control" name="createCommentContent" placeholder="Tapez votre commentaire" id="message" required></textarea>
            </div>
        </div>
        <br>
        <div id="success-send"></div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="sendMessageButton">Soumettre</button>
        </div>
    </form>
    <?php endif;?>
<?php endif;?>
<?php if(empty($_SESSION['user_nickname'])): ?>
    <p>
        <a class="nav-link" data-toggle="modal" data-target="#login-modal"  href="#">Connectez-vous pour écrire un commantaire</a>
    </p>
<?php endif;?>
<!--Commentaires existants -->
<?php foreach ($comments as $comment): ?>
    <div>
        <p>
            <span><?=$comment->getAuthor()?>, </span>
            <span>le <?=$comment->getCommentDate()?></span>
            <a href="index.php?action=signalComment&amp;id=<?= $comment->getCommentId() ?>">Signaler Commentaire</a>
            <?=$comment->getCommentContent()?>
        </p>
    </div>
<?php endforeach; ?>
</section>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

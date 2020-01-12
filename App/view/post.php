<?php

$title = 'Blog de Jean Forteroche : Chapitres'; ?>

<?php ob_start();
$post = $_SESSION['post' . $postId];
//unset($_SESSION['post' . $postId]);
if($post == NULL)
{
    header('location: index.php?action=viewErrorPage');
}
?>

<section class="bg-light container">
    <h2>Chapitres</h2>
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
            <button type="submit" class="btn btn-primary" id="sendMessageButton"><i class="far fa-comment"></i> Soumettre</button>
        </div>
    </form>
    <?php endif;?>
<?php endif;?>
<?php if(empty($_SESSION['user_nickname'])): ?>
    <p>
        <a class="nav-link" data-toggle="modal" data-target="#login-modal"  href="#"><i class="fas fa-sign-in-alt"></i>Connectez-vous pour écrire un commentaire</a>
    </p>
<?php endif;?>
<!--Commentaires existants -->
<?php foreach ($comments as $comment): ?>
    <div>
        <p>
            <span><?=$comment->getAuthor()?>, </span>
            <span>le <?=$comment->getCommentDate()?></span>
            <?php if($comment->getCommentStatus() == 'signaled'):?>
            <span class="font-italic">Commentaire signalé</span>
            <?php endif;?>
            <?php if($comment->getCommentStatus() == 'moderated'):?>
            <span class="font-italic">Commentaire modéré</span>
            <?php endif;?>
            <?php if($comment->getCommentStatus() == 'unsignaled'): ?>
            <a href="index.php?action=signalComment&amp;id=<?= $comment->getCommentId() ?>">Signaler Commentaire</a>
            <?php endif;?>
            <?=$comment->getCommentContent()?>
        </p>
    </div>
<?php endforeach; ?>
</section>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

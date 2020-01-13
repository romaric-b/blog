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

<section class="bg-light-opacity full-vh container pad-2">
    <article class="bg-light pad-2">
        <h2 class="d-flex flex-column">
            <span class="border-bottom pad-light"><?=$post->getPostTitle()?></span>
            <span class="font-italic date-post-title text-secondary marg-top">le <?=$post->getPostDate() ?></span>
        </h2>
        <p class="marg-top">
            <?=$post->getPostContent()?>
        </p>
    </article>
<!--Edition du commentaire -->
<?php if(isset($_SESSION)): ?>
    <?php if(!empty($_SESSION['user_nickname'])): ?>
    <form class="marg-top" action="index.php?action=createComment&amp;id=<?= $post->getPostId() ?>" method="post">
        <div class="control-group">
            <div class="form-group floating-label-form-group controls">
                <label for="message">Commentez ce chapitre :</label>
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
    <p class="marg-top">
        <a class="nav-link" data-toggle="modal" data-target="#login-modal"  href="#"><i class="fas fa-sign-in-alt"></i>Connectez-vous pour écrire un commentaire</a>
    </p>
<?php endif;?>
<!--Commentaires existants -->
    <h3 class="marg-top">Commentaires des membres</h3>
<?php foreach ($comments as $comment): ?>
    <div>
        <p class="d-flex flex-column">
            <div class="d-flex row pad-light comment-head--div">
                <span><?=$comment->getAuthor()?>, &nbsp;</span>
                <span class="font-italic text-secondary"> le <?=$comment->getCommentDate()?></span>
                <?php if($comment->getCommentStatus() == 'signaled'):?>
                    <span class="font-italic text-secondary"">&nbsp; Commentaire signalé</span>
                <?php endif;?>
                <?php if($comment->getCommentStatus() == 'moderated'):?>
                    <span class="font-italic text-secondary"">&nbsp; Commentaire modéré</span>
                <?php endif;?>
                <?php if($comment->getCommentStatus() == 'unsignaled'): ?>
                    <a class="text-danger" href="index.php?action=signalComment&amp;id=<?= $comment->getCommentId() ?>">&nbsp;  <i class="fas fa-exclamation-triangle"></i> Signaler Commentaire</a>
            <?php endif;?>
            </div>
            <?=$comment->getCommentContent()?>
        </p>
    </div>
<?php endforeach; ?>
</section>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>

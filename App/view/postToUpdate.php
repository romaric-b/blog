<?php

$title = 'Blog de Jean Forteroche : Modification article'; ?>

<?php ob_start();
$post = $_SESSION['post' . $postId];
if($post == NULL)
{
    header('location: index.php?action=viewErrorPage');
}
?>
<?php if (isset($_SESSION)): ?>
<?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>

<section id="update_post" class="update_post--section bg-light full-vh container">
    <form action="index.php?action=updatePost&amp;postId=<?=$post->getPostId()?>" method="POST" class="d-flex flex-column marg-auto">
        <label class="marg-top marg-bot-small"  for="post_title">Titre :
            <input id="post_title" name="updateTitle" id="title" value="<?= htmlspecialchars($post->getPostTitle())?>">
        </label>
        <label class="marg-top marg-bot-small" for="post_extract">Rédigez un extrait de votre chapitre :
            <textarea class="tinymce-edition marg-top" id="post_extract" name="updateExtract">
                <?=$post->getPostExtract()?>
            </textarea>
        </label>
        <label class="marg-top marg-bot-small"  for="post_content">Rédigez le contenu de votre chapitre :
            <textarea class="tinymce-edition marg-top" id="post_content" name="updateContent">
                <?=$post->getPostContent()?>
            </textarea>
        </label>
        <p class="marg-top">
            <input class="btn bg-info text-light" type="submit"  value="Valider les modifications"/>
        </p>
    </form>
</section>
 <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
 $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

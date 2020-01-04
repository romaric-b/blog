<?php

$title = 'Blog de Jean Forteroche : Modification article'; ?>

<?php ob_start();
$post = $_SESSION['post' . $postId];
?>

<section id="update_post" class="update_post--section">
    <form action="index.php?action=updatePost&amp;postId=<?=$post->getPostId()?>" method="POST" class="flex-column">
        <label for="post_title">Titre :
            <input id="post_title" name="updateTitle" id="title" value="<?= htmlspecialchars($post->getPostTitle())?>">
        </label>
        <label for="post_extract">Rédigez un extrait de votre article :
            <textarea class="tinymce-edition" id="post_extract" name="updateExtract">
                <?=$post->getPostExtract()?>
            </textarea>
        </label>
        <label for="post_content">Rédigez le contenu de votre article :
            <textarea class="tinymce-edition" id="post_content" name="updateContent">
                <?=$post->getPostContent()?>
            </textarea>
        </label>
        <p>
            <input type="submit"  value="Valider"/>
        </p>
    </form>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>

<?php

$title = 'Commentaires'; ?>

<?php ob_start(); ?>

<section>
    <p>Vu d'un commentaire</p>
</section>

<?php $content = ob_get_clean(); ?>

<?php require ('post.php'); ?>
<?php require('template.php'); ?>

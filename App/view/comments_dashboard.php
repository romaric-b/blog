<?php
$title = 'Tableau de bord : Commentaires'; ?>

<?php ob_start(); ?>
<h2>Les commentaires de votre blog</h2>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
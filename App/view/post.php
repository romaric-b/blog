<?php

$title = 'Blog de Jean Forteroche : Chapitres'; ?>

<?php ob_start(); ?>
<h2>liste des articles</h2>

<article>
    Contenu article


</article>

<div>
    <p>Liste de commentaires</p>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?><?php

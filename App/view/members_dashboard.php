<?php
$title = 'Tableau de bord : Membres'; ?>

<?php ob_start(); ?>

    <h2>Les membres de votre blog :</h2>
    <section>
        <p>tableau</p>
    </section>
<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
<?php
$title = 'Blog de Jean Forteroche : Chapitres'; ?>
<!--testé et fonctionne-->

<?php ob_start(); ?>

    <section id="chapters-list">

        <h2>Liste des chapitres</h2>

        <?php foreach ($posts as $post): ?>

        <article>
            <h3>
                <?=$post->getPostTitle()?>
                <?=$post->getPostDate() ?>
            </h3>
            <p>
                <?=$post->getPostExtract()?>
            </p>
        </article>
        <?php endforeach;?>

    </section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
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

            <a class="nav-link" href="index.php?action=viewPost&amp;id=<?= $post->getPostId() ?>">Lire l'article</a>

        <?php endforeach;?>

        <a></a>
    </section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
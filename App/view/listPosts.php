<?php
$title = 'Blog de Jean Forteroche : Chapitres'; ?>
<!--testé et fonctionne-->

<?php ob_start(); ?>

<!--    <div class="modal fade" id="signal-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <h5 class="modal-title" id="exampleModalLabel">Commentaire signalé</h5>-->
<!--                    <button type="button" id="close-login-modal" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">&times;</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    <p>Votre signalement a bien été pris en compte et sera examiné par l'administrateur</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

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

        <?php $_SESSION['post' . $post->getPostId()] = $post;
        ?>
            <a class="nav-link" href="index.php?action=viewPost&amp;post=<?=$post->getPostId()?>">Lire l'article</a>
        <?php endforeach;?>

        <?php

        for($i=1; $i<=$totalPages; $i++)
        {
            echo '<a href="index.php?action=listPosts&amp;page='.$i.'">'.$i.'</a> ';
        }
            ?>

    </section>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>
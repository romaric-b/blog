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
        <?php $_SESSION['post' . $post->getPostId()] = $post;
        ?>
            <a class="nav-link" href="index.php?action=viewPost&amp;post=<?=$post->getPostId()?>">Lire l'article</a>
        <?php endforeach;?>
        <div>Pages :</div>
        <?php
        for($i=1; $i<=$totalPages; $i++)
        {
            echo '<a href="index.php?action=listPosts&amp;page='.$i.'">'.$i.'</a> ';
        }
            ?>
    </section>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
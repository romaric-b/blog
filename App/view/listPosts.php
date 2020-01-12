<?php
$title = 'Blog de Jean Forteroche : Chapitres'; ?>
<!--testé et fonctionne-->

<?php ob_start(); ?>
    <section class="bg-light-opacity container" id="chapters-list">

        <h2 class="marg-top">Chapitres</h2>

        <?php foreach ($posts as $post): ?>
        <article class="bg-light chapter--article">
            <h3>
                <?=$post->getPostTitle()?>
                <span class="font-italic date-post-title text-secondary">le <?=$post->getPostDate() ?></span>
            </h3>
            <p>
                Extrait de ce chapitre :
                <?=$post->getPostExtract()?>
            </p>
        </article>
        <?php $_SESSION['post' . $post->getPostId()] = $post;
        ?>
            <a class="nav-link text-black-50 link-view-chapter" href="index.php?action=viewPost&amp;post=<?=$post->getPostId()?>"><i class="fas fa-book-open"></i>Lire ce chapitre</a>
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
<?php
$title = 'Blog de Jean Forteroche : Chapitres'; ?>
<!--testé et fonctionne-->

<?php ob_start(); ?>
    <section class="bg-light-opacity container full-vh" id="chapters-list">

        <h2 class="marg-top d-inline-flex">Chapitres</h2>

        <?php if(empty($posts) OR $posts == NULL): ?>
            <p>Aucun chapitre.</p>

        <?php elseif(!empty($posts)): ?>

        <?php foreach ($posts as $post): ?>
        <article class="bg-light chapter--article">
            <h3 class="border-bottom pad-light">
                <?=$post->getPostTitle()?>
                <span class="font-italic date-post-title text-secondary">le <?=$post->getPostDate() ?></span>
            </h3>
            <p class="d-flex flex-column">
                <span class="text-black-50">Extrait :</span>
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
            echo '<a class="text-black-50" href="index.php?action=listPosts&amp;page='.$i.'">'.$i.'</a> ';
        }
            ?>
    <?php endif; ?>
    </section>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
<?php

$title = 'Blog de Jean Forteroche : Chapitres'; ?>

<?php ob_start(); ?>


    <main class="main-content " id="chapters">

        <div>
            <h3>
                <strong>
                    <?= $post['title']?></strong>
            </h3>
            <p>Par
                <strong> Jean Forteroche </strong> posté le
                <?=$post['post_date_fr']?>
            </p>
            <p>
                <?= $post['content']?>
            </p>
        </div>


        <form action="index.php?action=postComment&amp;postId=<?=$post['id']?>" method="post" class="form-group">

            <?php if(isset($_SESSION['login'])): ?>
                <div>
                    <label for="comment">Commentaire</label><br />
                    <textarea id="comment" name="comment" cols="50" rows="5" required class="form-control form-control-sm"></textarea>
                </div>
                <div>
                    <input type="submit" value="Envoyer" class="btn btn-primary mt-3 mb-0 p-1" />
                </div>
            <?php else: ?>
                <p><strong>Vous devez vous connecter pour pouvoir poster un commentaire</strong></p>
            <?php endif; ?>

        </form>
        <section id="comments">

            <?php $i = 0; ?>
            <?php foreach ($postComments as $comment): ?>
                <p>
                    <strong>
                        <?= $comment['user_name'];?></strong>
                    Le
                    <?= $comment['comment_date_fr'];?>
                    <?php if(isset($_SESSION['login'])) : ?>
                        <a href="index.php?action=reportComment&postId=<?= $comment['post_id'] ?>&commentId=<?= $comment['id'] ?>" class="btn btn-danger p-1" id="comment<?= $i++; ?>">Signaler</a>
                    <?php endif; ?>
                </p>
                <p>
                    <?= htmlspecialchars($comment['content']);?>
                </p>
            <?php endforeach;?>

            <p><a href="index.php" class="btn btn-secondary p-1">Retour</a></p>
        </section>

    </main>



<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?><?php

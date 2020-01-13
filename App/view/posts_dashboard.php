<?php

$title = 'Tableau de bord : Chapitres'; ?>

<?php ob_start(); ?>
    <?php if (isset($_SESSION)): ?>
        <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
        <div class="container bg-light full-vh">
            <h1 class="marg-bot">Gestion de vos chapitres</h1>
            <?php if(empty($posts) OR $posts == NULL): ?>
                <p>Aucun chapitre.</p>

                <div class="bg-light">
                    <button class="btn btn-primary marg-top" type="button" data-toggle="collapse" data-target="#create_post" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-pencil-alt"></i>
                        Écrire un nouveau chapitre
                    </button>
                </div>
                <section id="create_post" class="creation_post--section collapse marg-h border-top border-bottom">
                    <form action="index.php?action=createPost" method="POST" class="d-flex marg-auto flex-column w-80">
                        <label class="marg-bot-small marg-top-strong" for="post_title">Titre :
                            <input id="post_title" name="createTitle" id="title">
                        </label>
                        <label  class="marg-bot-small"  for="post_extract">Rédigez un extrait de votre chapitre :
                            <textarea class="tinymce-edition" id="post_extract" name="createExtract">
                        </textarea>
                        </label>
                        <label  class="marg-bot-small"  for="post_content">Rédigez le contenu de votre chapitre :
                            <textarea class="tinymce-edition" id="post_content" name="createContent">
                        </textarea>
                        </label>
                        <p>
                            <input type="submit" class="btn btn-primary text-light" value="Valider ce chapitre"/>
                        </p>
                    </form>
                </section>

            <?php elseif(!empty($posts)): ?>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class="text-center table-striped table-borderless table-responsive bg-light table w-100 d-block d-sm-table d-md-table">
                    <thead class="thead-dark">
                    <tr>
                        <th>Titre</th>
                        <th>Extrait</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= htmlspecialchars($post->getPostTitle())?></td>
                            <td><?=$post->getPostExtract()?></td>
                            <td><?=$post->getPostDate()?></td>
                            <td class="btn-group" role="group" aria-label="actions">
                                <?php $_SESSION['post' . $post->getPostId()] = $post;
                                ?>
                                <a class="btn bg-info text-light" target="_blank" href="index.php?action=viewPostToUpdate&amp;post=<?=$post->getPostId()?>" ><i class="far fa-edit"></i>Modifier ce chapitre</a>
                                <a class="btn btn-secondary" target="_blank" href="index.php?action=viewPost&amp;post=<?=$post->getPostId()?>"><i class="fas fa-arrow-right"></i>Aller au chapitre</a>
                                <a href="index.php?action=deletePost&amp;postId=<?=$post->getPostId()?>" class="btn btn-danger p-1"><i class="far fa-trash-alt"></i>Effacer ce chapitre</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <div class="bg-light">
                <button class="btn btn-primary marg-top" type="button" data-toggle="collapse" data-target="#create_post" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-pencil-alt"></i>
                    Écrire un nouveau chapitre
                </button>
            </div>
            <section id="create_post" class="creation_post--section collapse marg-h border-top border-bottom">
                <form action="index.php?action=createPost" method="POST" class="d-flex marg-auto flex-column w-80">
                    <label class="marg-bot-small marg-top-strong" for="post_title">Titre :
                        <input id="post_title" name="createTitle" id="title">
                    </label>
                    <label  class="marg-bot-small"  for="post_extract">Rédigez un extrait de votre chapitre :
                        <textarea class="tinymce-edition" id="post_extract" name="createExtract">
                        </textarea>
                    </label>
                    <label  class="marg-bot-small"  for="post_content">Rédigez le contenu de votre chapitre :
                        <textarea class="tinymce-edition" id="post_content" name="createContent">
                        </textarea>
                    </label>
                    <p>
                        <input type="submit" class="btn btn-primary text-light" value="Valider ce chapitre"/>
                    </p>
                </form>
            </section>
            <?php endif; ?>
        </div>
    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>

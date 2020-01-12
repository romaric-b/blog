<?php

$title = 'Tableau de bord : Chapitres'; ?>

<?php ob_start(); ?>
    <?php if (isset($_SESSION)): ?>
        <?php if(!empty($_SESSION['role']) AND $_SESSION['role'] == 'administrator'): ?>
        <div class="container bg-light">
            <h1>Gestion de vos chapitres</h1>
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
                                <?php $_SESSION['post' . $post->getPostId()] = $post;?>
                                <a class="btn btn-primary" target="_blank" href="index.php?action=viewPostToUpdate&amp;post=<?=$post->getPostId()?>" ><i class="far fa-edit"></i>Modifier ce chapitre</a>
                                <a class="nav-link" target="_blank" href="index.php?action=viewPost&amp;post=<?=$post->getPostId()?>"><i class="fas fa-arrow-right"></i>Aller au chapitre</a>
                                <a class="btn btn-danger" data-toggle="modal" data-target="#delete-modal"  href="#"><i class="far fa-trash-alt"></i>Effacer ce chapitre</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
            <div class="bg-light">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#create_post" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-pencil-alt"></i>
                    Ecrire un nouveau chapitre
                </button>
            </div>
            <section id="create_post" class="creation_post--section collapse">
                <form action="index.php?action=createPost" method="POST" class="flex-column">
                    <label for="post_title">Titre :
                        <input id="post_title" name="createTitle" id="title">
                    </label>
                    <label for="post_extract">Rédigez un extrait de votre chapitre :
                        <textarea class="tinymce-edition" id="post_extract" name="createExtract">
                        </textarea>
                    </label>
                    <label for="post_content">Rédigez le contenu de votre chapitre :
                        <textarea class="tinymce-edition" id="post_content" name="createContent">
                        </textarea>
                    </label>
                    <p>
                        <input type="submit"  value="Valider"/>
                    </p>
                </form>
            </section>
            <div>
                <!--delete Modal-->
                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" id="close-login-modal" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="index.php?action=login" method="POST">
                                    <p>
                                        Êtes-vous sûr de vouloir supprimer ce chapitre ?
                                    </p>
                                    <p>
                                        <a href="index.php?action=deletePost&amp;postId=<?=$post->getPostId()?>" class="btn btn-danger p-1"><i class="far fa-trash-alt"></i>Effacer ce chapitre</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif (empty($_SESSION['role']) OR $_SESSION['role'] == 'member'):
        header('Location: index.php?action=viewHome');
        exit;
    endif;
endif;
$content = ob_get_clean(); ?>

<?php require('template.php'); ?>

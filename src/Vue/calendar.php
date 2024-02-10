<?php
    /** @var array $data */
    $eventsData = json_encode($data);
/** @var array $publications */
/** @var array $nbLikes */
/** @var array $publicationsLikedByConnectedUser */
/** @var array $answers */
/** @var array $connectedUserPublications */
/** @var array $images */
?>
<div id="calendarInfo">
    <div id="calendar" style="min-height: 100vh; margin-top: 70px"></div>

    <?php foreach ($publications as $publication) : ?>
        <!-- Modal -->
        <div class="modal fade" id="<?=$publication->getID()?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?=$publication->getID()?>"><span class="moderately-bold"><?=$publication->getUserID() ?></span><span
                                    class="grey">&nbsp;-&nbsp;<?= $publication->calculateTime()?></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Conteneur des posts -->
                        <article class="card mb-3 border border-0" style="max-width: 30rem;">
                            <div class="card-header d-flex bg-transparent border border-0 justify-content-between px-1">
                                <div>
                                    <?=htmlspecialchars($publication->getTitle()) ?>
                                </div>
                                <!-- User can delete or modify post -->
                                <?php if ($connectedUserPublications[$publication->getID()]): ?>
                                    <a id="showEditBtn" role="button" class="nav-link" data-bs-toggle="modal"
                                       data-bs-target="#popupEdit">
                                        &#8230;
                                    </a>
                                    <div class="modal fade" id="popupEdit" tabindex="=-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered rounded" style="max-width: 300px;">
                                            <div class="modal-content rounded">
                                                <div class="card">
                                                    <form action="../web/controleurFrontal.php" method="post" id="editForm">
                                                        <ul class="list-group list-group-flush rounded">
                                                            <li class="list-group-item link-danger btn-behaviour d-flex justify-content-center" id="deleteBtn">Supprimer</li>
                                                            <li class="list-group-item d-flex justify-content-center" id="editBtn">
                                                                Editer
                                                            </li>
                                                        </ul>
                                                        <input type="hidden" name="controleur" value="publication"/>
                                                        <input type="hidden" name="action" value="deletePublication"/>
                                                        <input type="hidden" name="publicationID" value="<?= $publication->getID() ?>"/>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Carousel -->
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Go left button -->
                                    <div class="col-1 d-flex align-items-center px-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left d-none left-btn" id="leftBtnMain<?=$publication->getID()?>" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                                        </svg>
                                    </div>
                                    <div class="col-10 justify-content-center d-flex position-relative my-3 p-0">
                                        <?php for($i=0; $i<sizeof($images[$publication->getID()]); $i++):?>
                                            <div class="carousel-image-main carousel-image-main<?=$publication->getID()?> <?php if ($i!=0) echo 'd-none';?>" id="slideMain<?=$i+1?>">
                                                <img class="img-fluid" src="<?=$images[$publication->getID()][$i]->getPathToImage()?>" alt="Image"/>
                                            </div>
                                        <?php endfor;?>
                                    </div>
                                    <!-- Go right button -->
                                    <div class="col-1 ps-1 pe-0 d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" id="rightBtnMain<?=$publication->getID()?>" class="bi bi-chevron-right right-btn <?php if(sizeof($images[$publication->getID()])<=1) echo 'd-none'?>" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-1">
                                <div class="row">
                                    <span class="stand-out" style="font-weight: bold">Date évènement : </span>
                                    <span class="stand-out"><?=$publication->getEventDate()?></span>
                                    <span class="stand-out" style="font-weight: bold">Horaire évènement :</span>
                                    <span class="stand-out"><?=substr($publication->getTime(), 0, 5)?></span>
                                    <span class="stand-out" style="font-weight: bold">Lieu évènement :</span>
                                    <span class="stand-out"><?=$publication->getAddress()?></span>
                                    <span class="stand-out"><?=$publication->getTown()?></span>
                                    <span class="stand-out"><?=$publication->getZip()?></span>
                                </div>
                                <!-- Interact buttons -->
                                <div class="row">
                                    <div class="d-flex align-items-center">
                                        <div class="heart-btn ps-0" data-publication-id="<?=$publication->getID()?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                 class="bi bi-heart heart<?=$publication->getID()?>" viewBox="0 0 16 16">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                            </svg>
                                        </div>
                                        <div class="ps-2">
                                            <a href="./controleurFrontal.php?action=afficherDefaultPage&controleur=forum">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                     class="bi bi-chat" viewBox="0 0 16 16">
                                                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <p class="card-text nbLikes<?= $publication->getID(); ?>"><?= $nbLikes[$publication->getID()] ?>
                                    J'aime</p>
                            </div>
                            <div class="card-footer bg-transparent"></div>
                            <p class="card-text"><?= $publication->getDescription() ?></p>
                        </article>
                        <!-- Comments popup -->
                        <div class="modal fade comment-popup" id="popup<?= $publication->getID(); ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-4 d-flex align-items-center justify-content-center border-end">
                                                <img src="<?php //$publication->getPathToImage() ?>" class="img-fluid"
                                                     alt="Image évènement">
                                            </div>
                                            <div class="col-8 p-0 d-flex flex-column">
                                                <div class="modal-header">
                                                    <div class="modal-title" id="popupLabel"><?= $publication->getTitle() ?>&nbsp;-&nbsp;<?= $publication->getEventDate() ?></div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="justify-content-start border-top d-flex">
                                                    <div class="ms-2 heart-btn" data-publication-id="<?= $publication->getID() ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-heart heart<?= $publication->getID() ?>"
                                                             viewBox="0 0 16 16">
                                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                                        </svg>
                                                    </div>
                                                    <div class="ms-2" onclick="focusOnInput('commentInput')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="ms-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                            <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="nbLikes<?= $publication->getID() ?> ms-2"><?= $nbLikes[$publication->getID()] ?>
                                                    J'aime
                                                </div>
                                                <div class="justify-content-start text-secondary border-top">
                                                    <form action="../web/controleurFrontal.php" method="post" id="commentForm">
                                                        <div class="input-group">
                                                            <input name="comment" placeholder="Ajouter un commentaire..." type="text"
                                                                   id="commentInput"
                                                                   class="form-control rounded-0 border-0 no-outline-focus">
                                                            <div class="input-group-append">
                                                                <button class="btn link-primary" type="submit">Publier</button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="controleur" value="commentaire">
                                                        <input type="hidden" name="action" value="addComment">
                                                        <input type="hidden" name="publicationID" value="<?= $publication->getID() ?>">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (in_array($publication, $publicationsLikedByConnectedUser)) : ?>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                fillHeart(<?=$publication->getID()?>);
                            });
                        </script>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


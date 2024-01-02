<?php
/** @var array $publications */
/** @var array $nbLikes */
/** @var array $publicationsLikedByConnectedUser */
/** @var array $comments */
?>
<!-- Conteneur des posts -->
<div class="container-fluid d-flex flex-column justify-content-center align-items-center" id="publicationsContainer">
    <!-- Les posts -->
    <?php foreach ($publications as $publication) :?>
    <article class="card mb-3" style="max-width: 25rem;">
        <img src="<?=$publication->getPathToImage()?>" class="card-img-top" alt="Image évènement">
        <div class="card-body">
            <p class="card-text"><?=$publication->getDescription()?></p>
            <p class="card-text" id="nbLikes<?=$publication->getID()?>"><?=$nbLikes[$publication->getID()]?> J'aime</p>
        </div>
        <div class="card-footer bg-transparent d-flex align-items-center">
            <button class="btn heart-btn" data-publication-id="<?=$publication->getID()?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16" id="heart<?=$publication->getID()?>">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                </svg>
            </button>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#popup">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                </svg>
            </button>
            <button class="btn" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                    <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                </svg>
            </button>
        </div>
    </article>
        <!-- Comments popup -->
        <div class="modal fade" id="popup" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center border-end">
                                <img src="<?=$publication->getPathToImage()?>" class="img-fluid" alt="Image évènement">
                            </div>
                            <div class="col-8 p-0">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="popupLabel">Commentaires</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php foreach($comments[$publication->getID()] as $comment):?>
                                    <div class="card-text">
                                        <?=$comment->getComment();?>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                                <div class="justify-content-start border-top">
                                    <button class="btn ms-0 heart-btn"  data-publication-id="<?=$publication->getID()?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16" id="heart">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                        </svg>
                                    </button>
                                    <span class="me-3" onclick="focusOnInput('commentInput')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                            </svg>
                                        </span>
                                    <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                                            </svg>
                                        </span>
                                </div>
                                <div class="justify-content-start text-secondary border-top">
                                    <input type="text" id="commentInput" class="form-control rounded-0 border-0 no-outline-focus">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php if (in_array($publication, $publicationsLikedByConnectedUser)) :?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof fillHeart === 'function') {
                    fillHeart(document.getElementById("heart<?=$publication->getID()?>"));
                }
            });
        </script>
    <?php endif;
    endforeach;?>
</div>
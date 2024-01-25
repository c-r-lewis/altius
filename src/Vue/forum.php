<?php
use App\Altius\Lib\ConnexionUtilisateur;

/** @var array $res */
/** @var \App\Altius\Modele\DataObject\Publication $publication */
$pubID = $res[0];
$messages = $res[1];
$userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();

$title = htmlspecialchars($publication->getTitle() ?? "Pas de titre");
$description = htmlspecialchars($publication->getDescription() ?? "Pas de description");
?>

<section class="mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-10 col-xl-10">
                <div class="card" id="chat1" style="border-radius: 15px;">
                    <div
                        class="d-flex align-items-center p-3 border-bottom-0">
                        <h1 class="mb-0 fw-bold"><?= $title ?></h1>
                    </div>
                    <div
                        class="d-flex align-items-center p-3 border-bottom-0">
                        <sub class="mb-0 fw-bold"><?= $description ?></sub>
                    </div>
                    <div class="card-body" style="margin-top: 100px">
                        <?php
                        foreach ($messages as $message) {
                            $comment = htmlspecialchars($message["comment"]) ?? "";
                            $userCommentID = htmlspecialchars($message["userID"]) ?? "";
                            $datePosted = htmlspecialchars($message["datePosted"]) ?? "";
                            // Si l'utilisateur est celui qui a posté le message, on affiche le message à droite sinon à gauche
                            // Avec l'image de profil à gauche ou à droite
                            if ($userCommentID == $userID) {
                                echo <<< HTML
                            <div class="d-flex flex-row justify-content-end mb-4">
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">$comment</p>
                                </div>
                                <img src="../assets/images/profilepicture.jpg"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                            </div>
                            HTML;
                            } else {
                                echo <<< HTML
                            <div class="d-flex flex-row justify-content-start mb-4">
                                <img src="../assets/images/profilepicture.jpg"
                                     alt="avatar 1" style="width: 45px; height: 100%;">
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">$comment</p>
                                </div>
                            </div>
                            HTML;
                            }
                        }
                        ?>

                        <!--
                        //TODO: Pour les images quand ce sera implémenter
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="../assets/images/profilepicture.jpg"
                                 alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="ms-3" style="border-radius: 15px;">
                                <div class="bg-image">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp"
                                         style="border-radius: 15px;" alt="video">
                                </div>
                                <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                    <p class="small mb-0">My message with image example</p>
                                </div>
                            </div>
                        </div>
                        -->

                        <form method="post" action="?controleur=commentaire&action=addComment">
                            <div class="form-outline p-3 rounded">
                                <label class="form-label" for="message" style="visibility: hidden">Message</label>
                                <textarea id="message" class="form-control" rows="4" name="message" placeholder="Ecrivez votre message ici"></textarea>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <label for="insertImage" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                        </svg>
                                    </label>
                                    <input type="file" id="insertImage" name="image" style="visibility: hidden">
                                    <input type="hidden" name="publicationID" value="<?= $pubID ?>">
                                    <input type="hidden" name="userID" value="<?= $userID ?>">
                                    <button type="submit" class="btn btn-primary btn-sm px-3" style="height: 32px">Envoyer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

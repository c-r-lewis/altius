<?php
use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Modele\DataObject\Event;

/** @var array $res */
/** @var Event $forum */
/** @var string $userID */
$forumID = $res[0];
$messages = $res[1];

$title = htmlspecialchars($forum->getTitle() ?? "Pas de titre");
$description = htmlspecialchars($forum->getDescription() ?? "Pas de description");
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
                        <p class="mb-0 fw-bold"><?= $description ?></p>
                    </div>
                    <div class="card-body" style="margin-top: 100px">
                        <?php
                        foreach ($messages as $message) {
                            $comment = htmlspecialchars($message["comment"] ?? "");
                            $login = htmlspecialchars($message["login"] ?? "");
                            $idUser = $message["userID"];
                            $datePosted = htmlspecialchars($message["datePosted"] ?? "");
                            $pathToImage = htmlspecialchars($message["pathToImage"] ?? "");
                            $imageHTML = "";
                            $messageHTML = "";
                            if ($pathToImage != "") {
                                $imageHTML = <<< HTML
                                    <img src="$pathToImage" style="border-radius: 15px; width: 70%" alt="image">
                                HTML;
                            }
                            if ($comment != "") {
                                $messageHTML = <<< HTML
                                    <div class="p-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                        <p class="small mb-0">$comment</p>
                                    </div>
                                HTML;
                            }

                            // Si l'utilisateur est celui qui a posté le message, on affiche le message à droite sinon à gauche
                            // Avec l'image de profil à gauche ou à droite
                            if ($idUser == $userID) {
                                echo <<< HTML
                                <div class="text-end" style="margin-right: 60px"><cite style="font-size: 13px">$login</cite></div>
                                <div class="d-flex flex-row justify-content-end mb-4">
                                    <div class="ms-3 d-flex flex-column align-items-end" style="border-radius: 15px;">
                                        <div class="d-flex justify-content-end">
                                            $imageHTML
                                        </div>
                                        $messageHTML
                                    </div>
                                    <img src="../assets/images/profilepicture.png"
                                         alt="avatar 1" style="width: 45px; height: 45px;">
                                </div>
                                HTML;
                            } else {
                                echo <<< HTML
                                <div class="text-start" style="margin-left: 60px"><cite style="font-size: 13px">$login</cite></div>
                                <div class="d-flex flex-row justify-content-start mb-4">
                                    <img src="../assets/images/profilepicture.png"
                                         alt="avatar 1" style="width: 45px; height: 45px;">
                                    <div class="ms-3 d-flex flex-column align-items-start" style="border-radius: 15px;">
                                        <div class="d-flex justify-content-start">
                                            $imageHTML
                                        </div>
                                        $messageHTML
                                    </div>
                                </div>
                                HTML;
                            }
                        }
                        ?>

                        <?php if(ConnexionUtilisateur::estConnecte()):?>
                        <form method="post" action="?controleur=commentaire&action=addComment" enctype="multipart/form-data">
                            <div class="form-outline p-3 rounded">
                                <label class="form-label" for="message" style="visibility: hidden">Message</label>
                                <textarea id="message" class="form-control" rows="4" name="message" placeholder="Ecrivez votre message ici"></textarea>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <input type="file" name="image">
                                    <input type="hidden" name="forumID" value="<?= $forumID ?>">
                                    <input type="hidden" name="userID" value="<?=$userID ?>">
                                    <button type="submit" class="btn btn-primary btn-sm px-3" style="height: 32px">Envoyer</button>
                                </div>
                            </div>
                        </form>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

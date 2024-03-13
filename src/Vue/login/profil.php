<?php
/** @var array $dataUser */
/** @var array $publications */
/** @var bool $estUserCo */
/** @var int $idUserCo */
/** @var int $nbAmis */
/** @var int $nbEvents */
?>

<section class="container-fluid p-4 border">
        <!-- Heads -->
    <div class="row">
        <aside class="col-md-2 p-3 flex-shrink-0 bg-white sidebar overflow-y-scroll">
            <ul class="list-unstyled ps-0 nav-pills ">
                <li class=" nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherProfil">Profil</a></li>
                <li class="nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherParametres">Paramètre</a></li>
                <li class="nav-item mb-3"><a class="nav-link" href="?controleur=utilisateur&action=afficherListeAmis">Liste d'amis</a></li>
                <li class="nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherListeDemandeAmis">Demande d'amis</a></li>
            </ul>
        </aside>
        <div class="col">
            <div class="d-flex align-items-center">
                <?php
                    /**@var $idUser1 **/
                $idUserUrl = urldecode($dataUser["idUser"]);
                    if (file_exists("../assets/uploads/pp/".$idUserUrl.".png")) {
                        $src = "../assets/uploads/pp/".$idUserUrl.".png";
                        echo '<img src="'.$src.'" alt="image de profil" style="width: 200px; height: 200px; margin-right: 5%">';
                    }else if(file_exists("../assets/uploads/pp/".$idUserUrl.".jpg")){
                        $src = "../assets/uploads/pp/".$idUserUrl.".jpg";
                        echo '<img src="'.$src.'" alt="image de profil" style="width: 200px; height: 200px; margin-right: 5%">';
                    }else{
                        echo '<img src="../assets/images/profilepicture.png" alt="Profile Picture" style="width: 200px; height: 200px; margin-right: 5%">';
                    }
                ?>
                <div>
                    <h1><?= htmlspecialchars($dataUser['login'] ?? "") ?></h1>
                    <div class="d-flex align-items-center justify-content-evenly">
                        <p><?= htmlspecialchars($nbEvents) ?> Évènements créés</p>
                        <p style="margin-left: 50px;"><?= htmlspecialchars($nbAmis) ?> Amis</p>
                    </div>
                    <p><?= htmlspecialchars($dataUser['statut'] ?? "") ?></p>
                    <p><?= htmlspecialchars($dataUser['description'] ?? "") ?></p>
                </div>
                <?php
                    if(!$estUserCo && !(new \App\Altius\Modele\Repository\FriendsRepository())->sontAmis($idUserCo,$dataUser["idUser"])){
                        $idUserUrl = urldecode($dataUser["idUser"]);
                        echo <<<HTML
                        <div class="p-4">
                        <a class="btn btn-primary" href="?controleur=friends&action=demanderAmis&idUser=$idUserUrl">Demander en ami</a>
</div>
HTML;

                    }
                ?>

            </div>
            <div class="mt-5 mb-5 text-center">
                <h2>Publications d'évènement</h2>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php
                        foreach ($publications as $publication) {
                            $titre = htmlspecialchars($publication['title']);
                            $description = htmlspecialchars($publication['description']);
                            $path = htmlspecialchars($publication['pathToImage'] ?? "");
                            echo <<< HTML
                                <div class="col">
                                    <div class="card">
                                        <img src="$path" class="card-img-top" alt="Pas d'image">
                                        <div class="card-body">
                                            <h5 class="card-title">$titre</h5>
                                            <p class="card-text">$description</p>
                                        </div>
                                    </div>
                                </div>
                            HTML;
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
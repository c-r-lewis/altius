<div class="container d-flex flex-column">
    <div class="column">
        <h1>Résultat Recherche</h1>
        <?php
        use App\Altius\Modele\Repository\FriendsRepository;

        /**
         * @var array $resultat
         * @var int $idUser1
         */
        if ($resultat[0] != "aucun nom ne correspond"):
            foreach ($resultat as $user):
                $loginHTML = htmlspecialchars($user[0]);
                $idUserUrl = urldecode($user[1]);
                $loginUrl = urldecode($user[0]);
                $nbAmisCommunHtml = htmlspecialchars($user[2]);
                ?>
                <div class="friend-request-card">
                    <div class="user-profile">
                        <div class="profile-picture">
                            <?php
                            if (file_exists("../assets/uploads/pp/".$idUserUrl.".png")) {
                                $src = "../assets/uploads/pp/".$idUserUrl.".png";
                                echo '<img src="'.$src.'" alt="image de profil" style="width: 45px; height: 45px; margin: 5px;">';
                            }else if(file_exists("../assets/uploads/pp/".$idUserUrl.".jpg")){
                                $src = "../assets/uploads/pp/".$idUserUrl.".jpg";
                                echo '<img src="'.$src.'" alt="image de profil">';
                            }else{
                                echo '<img src="../assets/images/inconnu-pp.png" alt="Profile Picture">       ';
                            }

                            ?>
                        </div>
                        <div class="user-details">
                            <h2><?= $loginHTML ?></h2>
                            <h2><?= $nbAmisCommunHtml ?> amis en commun</h2>
                        </div>
                    </div>
                    <div class="friend-request-actions">
                        <?php if (!(new FriendsRepository())->sontAmis($idUser1, $user[1]) && $user[1] !=$idUser1): ?>
                            <a class="nav-link button" href="?controleur=friends&action=demanderAmis&idUser=<?= $idUserUrl ?>" id="button-primary">
                                Demander en ami
                            </a>
                        <?php endif; ?>
                        <a class="nav-link button" href="?controleur=general&action=afficherProfil&idUser=<?= $idUserUrl ?>&login=<?= $loginUrl ?>" id="button-secondary">
                            Voir Profil
                        </a>
                    </div>
                </div>
            <?php
            endforeach;
        else:
            ?>
            <h2><?= htmlspecialchars($resultat[0]) ?></h2>
        <?php endif; ?>
    </div>
</div>

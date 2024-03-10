<div class="d-flex justify-content-center mb-5">
    <form class="container-md d-flex justify-content-around mt-2" method="post" action="?controleur=utilisateur&action=selectionParRecherche">
        <div class="container">
            <input class="form-control" type="text" name="recherche" placeholder="Recherche...">
        </div>
        <button class="btn btn-primary" type="submit">Envoyer</button>
    </form>
</div>
<link type="text/css" rel="stylesheet" href="../assets/css/amitie.css">
<link href="../assets/css/researchFriends.css" rel="stylesheet">
<div class="container">
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
                            <img src="../../assets/images/inconnu-pp.png" alt="Profile Picture">
                        </div>
                        <div class="user-details">
                            <h2><?= $loginHTML ?></h2>
                            <h2><?= $nbAmisCommunHtml ?> amis en commun</h2>
                        </div>
                    </div>
                    <div class="friend-request-actions">
                        <?php if (!(new FriendsRepository())->sontAmis($idUser1, $user[1])): ?>
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

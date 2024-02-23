
<link type="text/css" rel="stylesheet" href="../assets/css/amitie.css">
<section class="container-fluid p-4 border">
    <div class="row">
        <aside class="col-md-2 p-3 flex-shrink-0 bg-white sidebar overflow-y-scroll">
            <ul class="list-unstyled ps-0 nav-pills ">
                <li class=" nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherProfil">Profil</a></li>
                <li class="nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherParametres">Paramètre</a></li>
                <li class="nav-item mb-3"><a class="nav-link" href="?controleur=utilisateur&action=afficherListeAmis">Liste d'amis</a></li>
                <li class="nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherListeDemandeAmis">Demande d'amis</a></li>
            </ul>
        </aside>
        <div class="container col">
            <div class="column">

                <h1>Demandes d'amis</h1>
                <?php /** @var Friends[] $listeDemandeAmis
                * @var array $listeLoginAndIdDemandeur
                */

                use App\Altius\Modele\DataObject\Friends;

                for ($i=0;$i<count($listeDemandeAmis);$i++):
                    $loginHTML=htmlspecialchars($listeLoginAndIdDemandeur[$i][0]);
                    $idUrl= urldecode($listeDemandeAmis[$i]->getId());
                    $idUserUrl = urldecode($listeLoginAndIdDemandeur[$i][1]);
                    $loginUrl=urldecode($listeLoginAndIdDemandeur[$i][0]);
                    $nbAmisCommunHtml = htmlspecialchars($listeLoginAndIdDemandeur[$i][2]);
                    ?>
                    <div class="friend-request-card">
                        <div class="user-profile">
                            <div class="profile-picture">
                                <img src="../../assets/images/inconnu-pp.png" alt="">
                            </div>
                            <div class="user-details">
                                <h2><?= $loginHTML ?></h2>
                                <h2> <?= $nbAmisCommunHtml ?> amis en commun</h2>
                            </div>
                        </div>
                        <div class="friend-request-actions">
                            <a class="nav-link button" href="?controleur=friends&action=accepterDemande&id=<?=$idUrl?>" id="button-primary">Accepter</a>
                            <a class="nav-link button" href="?controleur=friends&action=refuserDemande&id=<?=$idUrl?>" id="button-secondary">Refuser</a>
                            <a class="nav-link button" href="?controleur=general&action=afficherProfil&idUser=<?=$idUserUrl?>&login=<?=$loginUrl?>" id="button-secondary">Voir Profil</a>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

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
                * @var array $listeLoginDemandeur
                */

                use App\Altius\Modele\DataObject\Friends;

                for ($i=0;$i<count($listeDemandeAmis);$i++): ?>
                    <div class="friend-request-card">
                        <div class="user-profile">
                            <div class="profile-picture">
                                <img src="../../assets/images/inconnu-pp.png" alt="">
                            </div>
                            <div class="user-details">
                                <h2><?= $listeLoginDemandeur[$i]?></h2>
                                <h2> [X] amis en commun</h2>
                            </div>
                        </div>
                        <div class="friend-request-actions">
                            <button class="button" id="button-primary">Confirmer</button>
                            <button class="button" id="button-secondary">Supprimer</button>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
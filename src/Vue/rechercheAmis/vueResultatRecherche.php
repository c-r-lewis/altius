<div class="d-flex justify-content-center mb-5">
    <form class="container-md d-flex justify-content-around" method="post" action="?controleur=utilisateur&action=selectionParRecherche">
        <div class="container">
            <input class="form-control" type="text" name="recherche" placeholder="Recherche...">
        </div>
        <button class="btn btn-primary" type="submit">Envoyer</button>
    </form>
</div>
<link type="text/css" rel="stylesheet" href="../assets/css/amitie.css">
<div class="container ">
    <div class="column">

        <h1>Resultat Recherche</h1>
        <?php  /**
         * @var array $resultat
         * @var int $idUser1
         */

        use App\Altius\Modele\DataObject\Friends;

        if($resultat[0]!="aucun nom ne correspond") {
            for ($i = 0; $i < count($resultat); $i++) {
                $loginHTML = htmlspecialchars($resultat[$i][0]);
                $idUserUrl = urldecode($resultat[$i][1]);
                $loginUrl = urldecode($resultat[$i][0]);
                echo <<<HTML
                    <div class="friend-request-card">
                    <div class="user-profile">
                        <div class="profile-picture">
                            <img src="../../assets/images/inconnu-pp.png" alt="">
                        </div>
                        <div class="user-details">
                            <h2>$loginHTML</h2>
                            <h2> [X] amis en commun</h2>
                        </div>
                    </div>
                    <div class="friend-request-actions">
                    HTML;
                if(!(new \App\Altius\Modele\Repository\FriendsRepository())->sontAmis($idUser1,$resultat[$i][1])){
                    echo '<a class="nav-link button" href="?controleur=friends&action=demanderAmis&idUser='.$idUserUrl.'" id="button-primary">Demander en ami</a>';
                }
                echo <<<HTML
                        <a class="nav-link button" href="?controleur=general&action=afficherProfil&idUser=$idUserUrl&login=$loginUrl" id="button-secondary">Voir Profil</a>
                    </div>
                </div>
HTML;
                    }
                }else echo '<h2>'.htmlspecialchars($resultat[0]).'</h2>'

                    ?>
    </div>
</div>

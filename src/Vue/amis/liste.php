
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

                <h1>Liste d'amis</h1>
                <?php /** @var array $logins
                 */

                use App\Altius\Modele\DataObject\Friends;
                foreach($logins as $login) {
                    if ($login != "Vous n'avez pas d'amis") {
                        $loginHTML = htmlspecialchars($login["login"]);
                        $loginUrl=urldecode($login["login"]);
                        $idAmis = urldecode($login["id"]);
                        $idUserUrl = urldecode($login["idUser"]);
                        $nbAmisCommunHtml = htmlspecialchars($login[3]);
                        echo <<<HTML
<div class="friend-request-card">
                        <div class="user-profile">
                            <div class="profile-picture">
HTML;
                        if (file_exists("../../assets/uploads/pp/".$idAmis.".png")) {
                            $src = "../../assets/uploads/pp/".$idAmis.".png";
                            echo '<img src="'.$src.'" alt="image de profil" style="width: 45px; height: 45px; margin: 5px;">';
                        }else if(file_exists("../assets/uploads/pp/".$idAmis.".jpg")){
                            $src = "../../assets/uploads/pp/".$idAmis.".jpg";
                            echo '<img src="'.$src.'" alt="image de profil" style="width: 45px; height: 45px; margin: 5px;">';
                        }else{
                            echo '<img src="../../assets/images/inconnu-pp.png" alt="">';
                        }
                        echo <<<HTML
                                
                            </div>
                            <div class="user-details">
                                <h2>$loginHTML</h2>
                                <h2>$nbAmisCommunHtml amis en commun</h2>
                            </div>
                        </div>
                        <div class="friend-request-actions">
                            <a class="nav-link button" href="?controleur=friends&action=supprimerAmis&idAmis=$idAmis" id="button-primary">Supprimer</a>
                            <a class="nav-link button" href="?controleur=general&action=afficherProfil&idUser=$idUserUrl&login=$loginUrl" id="button-secondary">Voir profil</a>
                        </div>
                    </div>';
HTML;
                    } else {
                        $loginHTML = htmlspecialchars($login);
                        echo '<h2>'.$loginHTML.'</h2>';
                    }
                }
                    ?>
            </div>
        </div>
    </div>
</section>

<?php use \App\Altius\Modele\DataObject\Utilisateur;
/**@var Utilisateur $utilisateur**/
$loginHTML = htmlspecialchars($utilisateur->getLogin());
$emailHTML = htmlspecialchars($utilisateur->getEmail());
$regionHTML = htmlspecialchars($utilisateur->getRegion());
$motDePasseHTML = htmlspecialchars($utilisateur->getMotDePasse());
$statutHTML = htmlspecialchars($utilisateur->getStatut());
$villeHTML = htmlspecialchars($utilisateur->getVille());
$numeroTelephoneHTML = htmlspecialchars($utilisateur->getNumeroTelephone());

echo <<<HTML

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Voulez vous vraiment supprimer votre compte ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
        <button type="button" class="btn btn-primary" onclick="window.location.href='?controleur=utilisateur&action=supprimerCompte';">Oui</button>
      </div>
    </div>
  </div>
</div>

<article class="row container border rounded-4 p-4" xmlns="http://www.w3.org/1999/html">
    <aside class="col-md-2 p-3 flex-shrink-0 bg-white sidebar overflow-y-scroll">
        <ul class="list-unstyled ps-0 nav-pills ">
            <li class=" nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherProfil">Profil</a></li>
            <li class="nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherParametres">Paramètre</a></li>
            <li class="nav-item mb-3"><a class="nav-link" href="?controleur=utilisateur&action=afficherListeAmis">Liste d'amis</a></li>
            <li class="nav-item mb-3"><a class="nav-link" href="?controleur=general&action=afficherListeDemandeAmis">Demande d'amis</a></li>
        </ul>
    </aside>

    <div class="col">
        <h1>Paramètres</h1>
        <div class="list-group">
            <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierLogin">
                <div class="form-label row">
                    <label class="col-md-3"> Login actuel</label>
                    <div class="col-md-9">
                        <span>$loginHTML</span>
                    </div>
                </div>
                <div class="form-label row">
                    <label class="col-md-3" for="ModifLogin">nouveau login</label>
                    <div class="col-md-9">
                        <input  id="ModifLogin" name="ModifLogin" type="text">
                    </div>
                </div>
                <button class="form-label">Enregistrer</button>
            </form>
            <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierStatut">
                <div class="form-label row">
                    <label class="col-md-3">Votre statut</label>
                    <div class="col-md-9">
                        <span>$statutHTML</span>
                    </div>
                </div>
                <div class="form-label row">
                    <label class="col-md-3" for="ModifStatut">Nouveau statut</label>
                    <div id="statut" class="col-md-9">
                        <select id="ModifStatut" name="ModifStatut" onchange="creerChampsAutre()">
                            <option value="Statut de l'utilisateur">Statut de l'utilisateur</option>
                            <option value="Organisateur">Organisateur</option>
                            <option value="PMR">PMR</option>
                            <option id="autre" value="autre">Autre...</option>
                        </select>
                    </div>
                </div>
        
                <button class="form-label">Enregistrer</button>    
            </form>
            <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierVille">
                <div class="form-label row">   
                    <label class="col-md-3">Ville de résidence actuelle</label>
                    <div class="col-md-9">
                        <span>$villeHTML</span>
                    </div>
                </div>
                <div class="form-label row">
                    <label class="col-md-3" for="ModifVilleResidence">Nouvelle ville de résidence</label>
                    <div class="col-md-9">
                        <input id="ModifVilleResidence" name="ModifVilleResidence" type="search" placeholder="Ville de Résidence">
                    </div>
                </div>
    
                <button>Enregistrer</button>
    
            </form>
            <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierEmail">
                <div class="form-label row">
                    <label class="col-md-3">Votre adresse mail </label>
                    <div class="col-md-9">
                        <span>$emailHTML</span>
                    </div>
                </div>
                <div class="form-label row">
                    <label class="col-md-3" for="ModifMail">Nouvelle adresse mail</label>
                    <div class="col-md-9">
                        <input id="ModifMail" name="ModifMail" type="email">
                    </div>
                </div>
            
                <button>Enregistrer</button>
            </form>
            <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierImagePP" enctype="multipart/form-data">
                <div class="form-label row">
                    <label class="col-md-3" for="ModifMail">Nouvelle image de profil</label>
                    <div class="col-md-9">
                        <input type="file" class="form-control" name="ModifimagePP" accept="image/png, image/jpeg">
                    </div>
                </div>
            
                <button>Enregistrer</button>
            </form>
            
            <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierMotDePasse">
                <div class="form-label row">
                    <label class="col-md-3" for="mdp1">Ancien mot de passe</label>
                    <div class="col-md-9">
                        <input type="password" id="mdp1" name="mdp1">
                    </div>
                </div>
                <div class="form-label row">
                    <label class="col-md-3" for="mdp2">Nouveau mot de passe</label>
                    <div class="col-md-9">
                        <input type="password" id=mdp2 name="mdp2">
                    </div>
                </div>
                <div class="form-label row">
                    <label class="col-md-3" for="mdp3"> Confirmer le mot de passe</label>
                    <div class="col-md-9">
                        <input id="mdp3" type="password" name="mdp3">
                    </div>
                </div>
        
                <button> Enregistrer</button>
            </form>
            <div class="list-group-item">
                <div class="form-label">
                    <p>
                        <label for="deleteAccount" id="labelDeleteAccount">Supprimer mon Compte</label
                    </p>
                </div>
                <div class="form-label">
                    <p>
                        <button id="deleteAccount" name="deleteAccount" data-bs-toggle="modal" data-bs-target="#exampleModal">Supprimer</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</article>
HTML;
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

<article class="container border rounded-4 p-4" xmlns="http://www.w3.org/1999/html">
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
                <div class="col-md-9">
                    <select id="ModifStatut" name="ModifStatut">
                        <option value="Statut de l'utilisateur">Statut de l'utilisateur</option>
                        <option value="Organisateur">Organisateur</option>
                        <option value="PMR">PMR</option>
                        <option value="autre">Autre...</option>
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
                <label class="col-md-3" for="ModifVilleResidence">Nouvelle la ville de résidence</label>
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
        <form class="list-group-item" method="post" action="?controleur=utilisateur&action=modifierMotDePasse">
            <div class="form-label row">
                <label class="col-md-3" for="ModifMdp">Nouveau mot de passe</label>
                <div class="col-md-9">
                    <input id="ModifMdp" name="mdp3">
                </div>
            </div>
            <div class="form-label row">
                <label class="col-md-3" for="mdp2"> Confirmer le mot de passe</label>
                <div class="col-md-9">
                    <input type="password" name="mdp2">
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
                    <button id="deleteAccount" name="deleteAccount">Supprimer</button>
                </p>
            </div>
        </div>
    </div>

</article>
HTML;
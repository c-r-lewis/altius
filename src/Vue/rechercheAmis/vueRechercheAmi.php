<link href="../assets/css/researchFriends.css" rel="stylesheet">
<div class="d-flex flex-column justify-content-center mb-2 pt-2">
    <form class="container-md d-flex justify-content-around" method="post" action="?controleur=utilisateur&action=selectionParRecherche">
        <div class="container d-flex flex-column">
            <input class="form-control" type="text" name="recherche" placeholder="Recherche..." id="searchBar">
            <ul class="mt-2 list-group" id="researchResults"></ul>
        </div>
        <button class="btn btn-primary" type="submit" style="max-height: 38px" id="sendBtn">Envoyer</button>
    </form>
    <div id="findContent">

    </div>
</div>
<script src="../assets/js/rechercher.js"></script>
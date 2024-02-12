<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="../assets/css/amitie.css">
    <title>Altius</title>
</head>
<body>
<div class="container">
    <div class="column">
        <h1>Mes Demandes d'amis</h1>
        <?php
        // Inclure les fichiers nécessaires
        use App\Altius\Modele\Repository\FriendsRepository;

        // Créer une instance de FriendsRepository
        $repository = new FriendsRepository();

        // Récupérer les demandes d'amis
        $demandesAmis = $repository->getAllDemandeAmis();

        if (!empty($demandesAmis)) {
            foreach ($demandesAmis as $demande) {
                echo '<div class="friend-request-card">';
                echo '<div class="user-profile">';
                echo '<div class="profile-picture">';
                echo '<img src="../../assets/images/inconnu-pp.png" alt="">';
                echo '</div>';
                echo '<div class="user-details">';
                echo '<h2>'. htmlspecialchars($demande->getLoginParId($demande->getUserLogin1())) .'</h2>';
                echo '<h2> Vous avez [X] amis en commun</h2>';
                echo '</div>';
                echo '</div>';
                echo '<div class="friend-request-actions">';
                echo '<a href="?controleur=friends&action=accepterDemandesAmis&id_user_1=<?php echo $demande->getUserLogin1();?>" class="button" id="button-primary">Accepter</a>';
                echo '<a href="?controleur=friends&action=refuserDemandesAmis" class="button" id="button-secondary">Refuser</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucune demande d\'amis pour le moment.</p>';
        }
        ?>
    </div>
</div>
</body>
</html>

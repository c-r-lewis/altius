<!doctype html>
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

        <h1>Demandes d'amis</h1>
        <?php /** @var array $listeDemandeAmis */
        foreach ($listeDemandeAmis as $user): ?>
            <div class="friend-request-card">
                <div class="user-profile">
                    <div class="profile-picture">
                        <img src="../../assets/images/inconnu-pp.png" alt="">
                    </div>
                    <div class="user-details">
                        <h2><?= $user->getLogin(); ?></h2>
                        <h2> [X] amis en commun</h2>
                    </div>
                </div>
                <div class="friend-request-actions">
                    <button class="button" id="button-primary">Confirmer</button>
                    <button class="button" id="button-secondary">Supprimer</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
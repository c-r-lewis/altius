<?php
use App\Altius\Modele\Repository\FriendsRepository;

$userRepo = new FriendsRepository();
$users = $userRepo->getAllDemandeAmis();
?>

<body>
<div class="container">
    <div class="column">
        <h1>Demandes d'amis ( <?= count($users); ?> )</h1>
        <?php foreach ($users as $user): ?>
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

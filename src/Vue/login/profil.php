<?php
/** @var array $dataUser */
/** @var array $publications */
?>

<section class="container">
    <!-- Heads -->
    <div class="d-flex align-items-center">
        <img src="../assets/images/profilepicture.png" alt="Profile Picture" style="width: 200px; height: 200px; margin-right: 5%">
        <div>
            <h1><?= htmlspecialchars($dataUser['login'] ?? "") ?></h1>
            <div class="d-flex align-items-center justify-content-evenly">
                <p><?= htmlspecialchars($dataUser['nbEvents'] ?? "") ?> Évènements créés</p>
                <p style="margin-left: 50px;"><?= htmlspecialchars($dataUser['nbAmis'] ?? "") ?> Amis</p>
            </div>
            <p><?= htmlspecialchars($dataUser['statut'] ?? "") ?></p>
            <p><?= htmlspecialchars($dataUser['description'] ?? "") ?></p>
        </div>
    </div>
    <div class="mt-5 mb-5 text-center">
        <h2>Mes publications d'évènement</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
                foreach ($publications as $publication) {
                    $titre = htmlspecialchars($publication['title']);
                    $description = htmlspecialchars($publication['description']);
                    $path = htmlspecialchars($publication['pathToImage'] ?? "");
                    echo <<< HTML
                        <div class="col">
                            <div class="card">
                                <img src="$path" class="card-img-top" alt="Pas d'image">
                                <div class="card-body">
                                    <h5 class="card-title">$titre</h5>
                                    <p class="card-text">$description</p>
                                </div>
                            </div>
                        </div>
                    HTML;
                }
            ?>
        </div>
    </div>
</section>
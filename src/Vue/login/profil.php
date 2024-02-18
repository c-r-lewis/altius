<?php
/** @var array $dataUser */
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
        <h2>Mes publications d'évènements</h2>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card">
                    <img src="../assets/images/logo.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="../assets/images/logo.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="../assets/images/logo.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="../assets/images/logo.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
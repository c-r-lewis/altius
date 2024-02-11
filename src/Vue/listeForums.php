<section class="container">
    <div>
        <form class="d-flex" role="search" method="POST" action="?controleur=forum&action=afficherListeForum">
            <input class="form-control me-2" name="research" type="search" placeholder="Rechercher" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Rechercher</button>
        </form>
    </div>

    <!-- Pour ajouter un nouveau forum -->
    <div class="mt-5 text-center">
        <p>Vous ne trouvez pas la réponse à votre question ? Créez un nouveau Forum !</p>
        <a href="?controleur=forum&action=afficherCreerUnNouveauForum" class="btn btn-primary">Créez un nouveau Forum</a>
    </div>

    <!-- Body -->
    <div class="d-flex flex-column mb-5" style="margin-top: 50px">
        <?php
        /** @var array $forums */
        foreach ($forums as $forum) {
            ?>
            <article class="bg-dark bg-opacity-25 mt-5 p-4 rounded">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <h2 class="text-center"><?= $forum["title"] ?></h2>
                        <p><?= substr($forum["description"], 0, 30) . "..." ?></p>
                    </div>
                    <div class="d-flex flex-column">
                        <p class="text-center">Nombre de messages : <?= $forum["nbMessage"] ?></p>
                        <a href="?controleur=forum&action=afficherForum&id=<?= $forum["forumID"] ?>"
                           class="btn btn-primary">Voir le forum</a>
                    </div>
                </div>
            </article>
            <?php
        }
        ?>
    </div>
</section>

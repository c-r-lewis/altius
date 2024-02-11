<h1 class="text-center mt-5">Créez un nouveau forum</h1>
<div class="bg-light py-3 py-md-4 py-xl-8 background d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                <div class="bg-white p-4 p-md-5 pt-md-4 rounded shadow-sm">
                    <form method="post" action="?controleur=forum&action=createForum">
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <!-- Titre -->
                            <div class="col-12">
                                <label for="title" class="form-label">Titre du forum <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="desc" name="desc" style="height: 100px"></textarea>
                                    <label for="desc">Problématique principale</label>
                                </div>
                            </div>

                            <!-- Évènement associé -->
                            <div class="col-12">
                                <label for="event" class="form-label">Évènement associé</label>
                                <div class="input-group">
                                    <select class="form-select" id="event" name="event">
                                        <option value="noEvent" selected>Pas d'évènement associé</option>
                                        <?php
                                            // Affiche tous les évènements triés par ordre alphabétique après aujourd'hui
                                            /** @var array $events */
                                            foreach ($events as $event) {
                                                ?>
                                                <option value="<?= $event["publicationID"] ?>"><?= $event["title"] ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Le submit -->
                            <div class="col-12 d-flex justify-content-center mt-5">
                                <div class="col-2">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Créer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

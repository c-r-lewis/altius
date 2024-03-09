<?php

use App\Altius\Lib\ConnexionUtilisateur;
if (!isset($pageConnexion)) {
    $pageConnexion = false;
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Altius</title>
        <link rel="icon" type="image/png" href="../assets/images/logo.png"/>
        <link href="../assets/css/bootstrap.css" rel="stylesheet">
        <link href="../assets/css/loader.css" rel="stylesheet">
        <?php
        if (!isset($_GET)) echo '<link href="../assets/css/accueil.css" rel="stylesheet">';
        ?>
        <?= /* @var ?string $css */ $css ?? "" ?>
    </head>
    <body>
        <!-- Loader -->
        <div id="loader-overlay" style="display: none;">
            <img src="../assets/images/logo.png" alt="Veuillez patienter..." class="spinner"/>
        </div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="?" id="navbarBrand">
                    <img src="../assets/images/logo.png" height="40" alt="" loading="lazy"/>
                </a>
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?" id="homeBtn">Accueil</a>
                        </li>
                        <li class="nav-item" id="calendarBtn">
                            <a class="nav-link active" aria-current="page"
                               href="?controleur=calendrier&action=afficherCalendrier" id="calendarBtn">Évènements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="?controleur=forum&action=afficherDefaultPage"
                               id="forumBtn">Forums</a>
                        </li>
                    </ul>
                    <!-- Right links end -->
                    <?php if (ConnexionUtilisateur::estConnecte()): ?>
                        <ul class="ms-auto d-flex flex-lg-row justify-content-end" id="connectedUserMenu">
                            <!-- Logged in user menu -->
                            <li class="nav-item">
                                <a class="nav-link px-1" role="button" href="?controleur=general&action=afficherRechercheAmis">
                                    <img src="../assets/images/ajoutAmi.png" width="25" height="25" alt="image ajout">
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-1" role="button" data-bs-toggle="modal" data-bs-target="#popupCreate">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                         class="bi bi-plus-square" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                </a>
                            </li>
                            <!-- Navbar dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                         class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                        <path fill-rule="evenodd"
                                              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                    </svg>
                                </a>
                                <!-- Dropdown menu -->
                                <ul class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="?controleur=general&action=afficherProfil">Profil</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="?controleur=utilisateur&action=seDeconnecter">Déconnexion</a></li>
                                </ul>
                            </li>
                            <!-- End logged in user menu -->
                        </ul>
                        <!-- Logged out user menu -->
                    <?php elseif (!$pageConnexion): ?>
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-primary" href="?controleur=utilisateur&action=afficherPageLogin">
                                Se connecter
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <!-- Navbar -->

        <div class="container" style="margin-top: 70px">
            <!-- Messages flash -->
            <?php
            /** @var string[][] $messagesFlash */
            foreach ($messagesFlash as $type => $messagesFlashPourUnType) {
                // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
                // $messagesFlashPourUnType est la liste des messages flash d'un type
                foreach ($messagesFlashPourUnType as $messageFlash) {
                    echo <<< HTML
            <div class="alert alert-$type">
               $messageFlash
            </div>
            HTML;
                }
            }
            ?>
        </div>

        <!-- New publication popup -->
        <div class="modal fade" id="popupCreate" tabindex="=-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center" id="newPublicationTitle">
                            <div>
                                Partager un évènement
                            </div>
                            <input class="link-primary btn p-0 ms-5" type="submit" id="submitBtn" value="Créer" style="display: none;">
                            <button class="link-primary btn p-0 ms-5" id="nextBtn" style="display: none;" onclick="addDescriptionToEvent()">Suivant</button>
                        </div>
                        <div id="createContainer">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main>
            <?php
                /** @var ?string $cheminVueBody */
                require __DIR__ . "/$cheminVueBody";
            ?>
        </main>
        <script src="../assets/js/mainCarousel.js"></script>
        <script defer src="../assets/js/createPublicationPopup.js"></script>
        <script src="../assets/js/publicationInfoPopup.js"></script>
        <script src="../assets/js/bootstrap.bundle.js"></script>
        <script src="../assets/js/parametres.js"></script>
        <script src="../assets/js/loader.js"></script>
        <?= /** @var string $js */ $js ?? "" ?>

        <!-- Script pour loader le calendrier -->
        <script>
            <?php
                /* @var array $eventsData */
                if (!isset($eventsData)) $eventsData = array();
            ?>

            const eventsDataNotAdapted = JSON.parse(<?php echo json_encode($eventsData); ?>);

            let eventsCalendar = [];
            for (let i = 0; i < eventsDataNotAdapted.length; i++) {
                eventsCalendar.push({
                    id: eventsDataNotAdapted[i].publicationID,
                    name: eventsDataNotAdapted[i].title,
                    description: eventsDataNotAdapted[i].description,
                    date: new Date(eventsDataNotAdapted[i].eventDate),
                    type: 'event',
                    color: 'red',
                    everyYear: false
                });
            }

            $(document).ready(function() {
                $('#calendar').evoCalendar({
                    'language': 'fr',
                    'theme': 'Royal Navy',
                    'format': 'MM dd, yyyy',
                });

                $('#calendar').evoCalendar('addCalendarEvent', eventsCalendar);
            })
        </script>
    </body>
</html>
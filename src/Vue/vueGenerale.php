<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Altius</title>
        <link rel="icon" type="image/png" href="../assets/images/logo.png"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="../assets/css/login.css">
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="#">
                    <img src="../assets/images/logo.png" height="40" alt="" loading="lazy" />
                </a>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                        </li>
                    </ul>
                </div>

                <!-- Left links -->
                <ul class="navbar-nav mb-0 d-flex flex-row">
                    <li class="nav-item">
                        <a class="nav-link px-1" role="button" data-bs-toggle="modal" data-bs-target="#popupCreate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                        </a>
                    </li>
                    <!-- Navbar dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                            </svg>
                        </a>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="?controleur=general&action=afficherParametres">Paramètres</a></li>
                            <li><a class="dropdown-item" href="?controleur=utilisateur&action=seDeconnecter">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Navbar -->

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

        <!-- New publication popup -->
        <div class="modal fade" id="popupCreate" tabindex="=-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-center" id="newPublicationTitle">
                            <div>
                                Créer une nouvelle publication
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
                /** @var string $cheminVueBody */
                require __DIR__ . "/$cheminVueBody";
            ?>
        </main>

        <script defer src="../assets/js/createPublicationPopup.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="../assets/js/publicationInfoPopup.js"></script>
    </body>
</html>
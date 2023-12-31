<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Altius</title>
        <link rel="icon" type="image/png" href="../assets/images/logo.png"/>
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
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
                        <li class="nav-item">
                            <a class="nav-link" href="#">Covoiturage</a>
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
                            <li><a class="dropdown-item" href="#">Paramètres</a></li>
                            <li><a class="dropdown-item" href="#">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Navbar -->

        <!-- New publication popup -->
        <div class="modal fade" id="popupCreate" tabindex="=-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header" id="newPublicationTitle">
                            Créer une nouvelle publication
                        </div>
                        <div id="createContainer">

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Comments popup -->
        <div class="modal fade" id="popup" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center justify-content-center border-end">
                                <img src="../assets/images/logo.png" class="img-fluid" alt="logo">
                            </div>
                            <div class="col-8 p-0">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="popupLabel">Commentaires</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-text">
                                        Commentaire 1
                                    </div>
                                    <div class="card-text">
                                        Commentaire 2
                                    </div>
                                </div>
                                <div class="justify-content-start border-top">
                                    <button class="btn ms-0 heart-btn" onclick="like()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16" id="heart">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                        </svg>
                                    </button>
                                    <span class="me-3" onclick="focusOnInput('commentInput')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
                                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894m-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                            </svg>
                                        </span>
                                    <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
                                                <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
                                            </svg>
                                        </span>
                                </div>
                                <div class="justify-content-start text-secondary border-top">
                                    <input type="text" id="commentInput" class="form-control rounded-0 border-0 no-outline-focus">
                                </div>
                            </div>
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

        <script src="../assets/js/popup.js"></script>
        <script src="../assets/js/bootstrap.bundle.js"></script>
    </body>
</html>
<!-- Il s'agit d'une vue indépendante de vue générale -->
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Altius</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png"/>
    <link type="text/css" rel="stylesheet" href="../assets/css/login.css">
    <link type="text/css" rel="stylesheet" href="../assets/css/bootstrap.css">
</head>
<body>
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
<div class="bg-light py-3 py-md-4 py-xl-8 background d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                <div class="bg-white p-4 p-md-5 pt-md-4 rounded shadow-sm">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center mb-4">
                                <a href="?">
                                    <img src="../../assets/images/logo.png" alt="" width="100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="?controleur=utilisateur&action=creerUtilisateur">
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <!-- Login -->
                            <div class="col-12">
                                <label for="login" class="form-label">Login <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="login" id="login" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                        </svg>
                                    </span>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>
                            </div>

                            <!-- Statut -->
                            <div class="col-12">
                                <label for="selectionsStatut" class="form-label">Statut <span class="text-danger">*</span></label>
                                <div class="mb-3">
                                    <select id="selectionsStatut" name="statut" class="form-select">
                                        <option>Personne à Mobilité Réduite</option>
                                        <option>Organisateur d'évènement</option>
                                        <option>Autre...</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Ville de résidence -->
                            <div class="col-12">
                                <label for="ville" class="form-label">Ville de résidence <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="ville" id="ville" required>
                                </div>
                            </div>

                            <!-- Région de résidence -->
                            <div class="col-12">
                                <label for="region_id" class="form-label">Région de résidence <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" name="region" id="region_id" required>
                                </div>
                            </div>

                            <!-- Numéro de téléphone -->
                            <div class="col-12">
                                <label for="pnumber" class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="tel" class="form-control" name="numeroTelephone" id="pnumber" required>
                                </div>
                            </div>

                            <!-- Mot de Passe -->
                            <div class="col-12 mt-5">
                                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                            <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                    </span>
                                    <input type="password" class="form-control" name="mdp1" id="password" value="" required>
                                </div>
                            </div>

                            <!-- Mot de Passe Confirmation -->
                            <div class="col-12">
                                <label for="passwordconfirm" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="mdp2" id="passwordconfirm" value="" required>
                                </div>
                            </div>

                            <!-- Le submit -->
                            <div class="col-12 d-flex justify-content-center mt-3">
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
<script src="../../assets/js/bootstrap.bundle.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
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
    <link type="text/css" rel="stylesheet" href="../../assets/css/login.css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
</head>
<body>

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
                    <form method="post" action="../web/controleurFrontal.php?controleur=utilisateur&action=seConnecter">
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-12">
                                <label for="login-id" class="form-label">Login <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" name="login" id="login-id" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                            <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                        </svg>
                                    </span>
                                    <input type="password" class="form-control" name="mdp2" id="password" value="" required>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-5">
                                <div class="col-5">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-md" type="submit">Se connecter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <hr class="mt-4 mb-2 border-secondary-subtle">
                            <div class="d-flex gap-2 flex-column flex-md-row justify-content-md-center">
                                <a href="?controleur=utilisateur&action=afficherPageInscription" class="link-primary text-decoration-none">S'inscrire</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-center">
                    <a href="#!" class="link-primary">Mot de passe oublié ?</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../assets/js/bootstrap.bundle.js"></script>
</body>
</html>


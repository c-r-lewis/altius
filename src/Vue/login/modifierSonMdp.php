<div class="bg-light py-3 py-md-4 py-xl-8 background d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-11 col-lg-8 col-xl-7 col-xxl-6">
                <div class="bg-white p-4 p-md-5 pt-md-4 rounded shadow-sm">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center mb-4">
                                <a href="?">
                                    <img src="../../../assets/images/logo.png" alt="" width="100">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="text-center mb-5">Insérez votre nouveau mot de passe.</p>
                    </div>
                    <form method="post" action="?controleur=utilisateur&action=modifierMdp">
                        <div class="row gy-3 gy-md-4 overflow-hidden">
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

                            <input type="hidden" value="<?= /* @var string $token */ $token ?>" name="token">
                        </div>
                        <!-- Le submit -->
                        <div class="col-12 d-flex justify-content-center mt-3">
                            <div class="col-2">
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Envoyer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
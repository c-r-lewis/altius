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
                        <p class="text-center mb-5">Un email vous sera envoyé pour récupérer votre mot de passe.</p>
                    </div>
                    <form method="post" action="?controleur=utilisateur&action=envoyerMotDePasseOublie">
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <!-- Login -->
                            <div class="col-12">
                                <label for="login" class="form-label">Votre login<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="login" id="login" required>
                                </div>
                            </div>

                            <!-- Le submit -->
                            <div class="col-12 d-flex justify-content-center mt-3">
                                <div class="col-2">
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">Envoyer</button>
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
<?php

$date = "";
$heure = "";
$adresse = "";
$titre = "";
$description = "";
$datePostee = "";
$user = "";

?>

<section class="mt-5">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-10 col-xl-10">
                <div class="card" id="chat1" style="border-radius: 15px;">
                    <div
                        class="d-flex align-items-center p-3 border-bottom-0">
                        <h1 class="mb-0 fw-bold">Titre du salon de discussion</h1>
                    </div>
                    <div
                        class="d-flex align-items-center p-3 border-bottom-0">
                        <sub class="mb-0 fw-bold">Description</sub>
                    </div>
                    <div class="card-body" style="margin-top: 100px">
                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="../assets/images/profilepicture.jpg"
                                 alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">Other people message example</p>
                            </div>
                        </div>

                        <div class="d-flex flex-row justify-content-end mb-4">
                            <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                <p class="small mb-0">My message example</p>
                            </div>
                            <img src="../assets/images/profilepicture.jpg"
                                 alt="avatar 1" style="width: 45px; height: 100%;">
                        </div>

                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="../assets/images/profilepicture.jpg"
                                 alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="ms-3" style="border-radius: 15px;">
                                <div class="bg-image">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp"
                                         style="border-radius: 15px;" alt="video">
                                </div>
                                <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                    <p class="small mb-0">My message with image example</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row justify-content-start mb-4">
                            <img src="../assets/images/profilepicture.jpg"
                                 alt="avatar 1" style="width: 45px; height: 100%;">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                <p class="small mb-0">And here is an example of the last message</p>
                            </div>
                        </div>

                        <form method="post" action="#">
                            <div class="form-outline p-3 rounded">
                                <textarea class="form-control" rows="4" placeholder="Ecrivez votre message ici" required></textarea>
                                <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary btn-sm px-3">Envoyer</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

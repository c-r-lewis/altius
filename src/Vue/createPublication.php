<form method="post" action="../web/controleurFrontal.php" id="createPublicationForm" enctype="multipart/form-data">
    <div class="row gx-0">
        <div class="col-6 d-flex justify-content-center" id="imgContainer">
            <!-- Image will be added here dynamically -->
        </div>
        <div class="col-6 d-flex flex-column">
            <input type="text" placeholder="Ajouter une description..." class="border-0 container-fluid flex-grow no-outline-focus" name="description">
            <input type="text" placeholder="Ajouter un lieu" class="border-0 pb-3 no-outline-focus">
            <input type="date" class="border-0 no-outline-focus pb-3" name="eventDate">
        </div>
        <input type="hidden" name="controleur" value="publication">
        <input type="hidden" name="action" value="createPublication">
        <div id="fileInputContainer"></div>
    </div>
</form>
<form method="post" action="../web/controleurFrontal.php" id="createPublicationForm" enctype="multipart/form-data">
    <div class="row gx-1">
        <div class="col-md-6 col-sm-12 d-flex justify-content-center" id="addCarousel">
            <!-- Add carousel dynamically -->
        </div>
        <div class="col-md-6 col-sm-12 d-flex flex-column p-1">
            <input type="text" placeholder="Ajouter un titre" class="border-0 pb-3 no-outline-focus" name="title"/>
            <input type="text" placeholder="Ajouter une description..." class="pb-3 border-0 flex-grow no-outline-focus" name="description">
            <input type="text" placeholder="Ajouter un lieu" class="border-0 pb-3 no-outline-focus">
            <input type="date" class="border-0 no-outline-focus pb-3" name="eventDate">
            <input type="number" placeholder="heure">
        </div>
        <input type="hidden" name="controleur" value="publication">
        <input type="hidden" name="action" value="createPublication">
        <div id="fileInputContainer"></div>
    </div>
</form>
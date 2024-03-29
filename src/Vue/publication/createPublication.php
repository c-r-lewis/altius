<form method="post" action="../web/controleurFrontal.php" id="createPublicationForm" enctype="multipart/form-data">
    <div class="row gx-1">
        <div class="col-md-6 col-sm-12 d-flex justify-content-center" id="addCarousel">
            <!-- Add carousel dynamically -->
        </div>
        <div class="col-md-6 col-sm-12 d-flex flex-column p-1">
            <input type="text" placeholder="Ajouter un titre *" class="border-0 pb-3 no-outline-focus" name="title" required/>
            <input type="text" placeholder="Ajouter une description..." class="pb-3 border-0 flex-grow no-outline-focus" name="description">
            <input type="text" placeholder="Adresse *" class="border-0 pb-3 no-outline-focus" name="address" required>
            <input type="text" placeholder="Ville *" class="border-0 pb-3 no-outline-focus" name="town" required>
            <input type="text" placeholder="Code postale *" pattern="\d{5}" class="border-0 pb-3 no-outline-focus" name="zip" title="Le code postal doit être un nombre de 5 chiffres sans espaces" required>
            <input type="text" id="date" placeholder="jj/mm/aaaa *" pattern="\d{2}/\d{2}/\d{4}" class="border-0 no-outline-focus pb-3" name="eventDate" oninput="validateDate(this)" required>
            <input type="text" placeholder="HH:MM *" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]" title="Veuillez donner une heure dans le format HH:MM" class="border-0 pb-3 no-outline-focus" name="eventTime" required>
        </div>
        <input type="hidden" name="controleur" value="publication">
        <input type="hidden" name="action" value="createPublication">
        <div id="fileInputContainer"></div>
    </div>
</form>
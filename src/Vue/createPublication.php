<form method="get" action="../../web/controleurFrontal.php">
    <div class="row gx-0">
        <div class="col-6 d-flex justify-content-center">
            <!-- Image container will be added here dynamically -->
        </div>
        <div class="col-6 d-flex flex-column">
            <input type="text" placeholder="Ajouter une description..." class="border-0 container-fluid flex-grow no-outline-focus">
            <input type="text" placeholder="Ajouter un lieu" class="border-0 pb-3 no-outline-focus">
            <input type="date" class="border-0 no-outline-focus pb-3">
        </div>
        <input type="hidden" name="action" value="createPublication">
        <input type="hidden" name="controller" value="publication">
    </div>
</form>
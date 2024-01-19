
<div class="container-fluid">
    <div class="row position-relative">
        <!-- Go left button -->
        <div class="col-1 d-flex align-items-center pe-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
            </svg>
        </div>
        <div class="col-10 justify-content-center d-flex position-relative my-3" id="imgContainer">
            <!-- Images will be added here dynamically -->
            <div class="carousel-image" id="firstImage">

            </div>
        </div>
        <!-- Go right button -->
        <div class="col-1 ps-0 d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
            </svg>
        </div>
        <!-- Bottom icons -->
        <div class="position-absolute bottom-0 end-0 bg-transparent">
            <!-- Files popup -->
            <div class="d-flex justify-content-end">
                <div id="addImagePopup" class="d-none justify-content-start p-2
                    add-image-popup align-items-center flex-row-reverse">
                    <label for="newExtraImage" class="d-flex align-items-center mx-2" id="addImageBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                    </label>
                    <input type="file" name="newExtraImage" accept="image/*" id="newExtraImage" style="display: none">
                </div>
            </div>
            <!-- Show files button -->
            <div class="d-flex justify-content-end">
                <div id="showAddImagePopupBtn" class="rounded-2 p-2 m-2 add-image-icon" style="width: fit-content">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-images" viewBox="0 0 16 16">
                        <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                        <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2M14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1M2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fileInputContainer"></div>
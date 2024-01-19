// Listener on create event popup
document.getElementById('popupCreate').addEventListener('show.bs.modal', function () {
    loadCreatePublicationContent();
});

let fileInput;

function loadCreatePublicationContent() {
    const container = document.getElementById("createContainer");
    document.getElementById("submitBtn").style.display = 'none';
    const title = document.getElementById("newPublicationTitle");
    title.classList.remove('justify-content-between');
    title.classList.add('justify-content-center');

    // Fetch the content of the PHP file
    fetch('../../src/Vue/publication/uploadImage.php')
        .then(response => response.text())
        .then(htmlContent => {
            // Replace the content of the container with the fetched HTML
            container.innerHTML = htmlContent;
            fileInput = document.getElementById("newImage");
            fileInput.addEventListener('change',loadMultipleImageChoice);
        })
        .catch(error => {
            console.error('Error fetching PHP file:', error);
        });
}

let nbImages = 0
function loadMultipleImageChoice() {
    if (fileInput.files.length > 0) {
        const container = document.getElementById("createContainer");

        const title = document.getElementById("newPublicationTitle");
        title.classList.remove('justify-content-center');
        title.classList.add('justify-content-between');

        const nextBtn = document.getElementById('nextBtn');
        nextBtn.style.display = 'inline-block';

        // Fetch the content of the PHP file
        fetch('../src/Vue/publication/addOtherImages.php')
            .then(response => response.text())
            .then(htmlContent => {
                // Replace the content of the container with the fetched HTML
                container.innerHTML = htmlContent;

                // Display the selected image
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result.toString();
                    img.alt = 'Image sélectionnée';
                    img.classList.add("img-fluid");

                    // Add the image to the image container
                    const imgContainer = document.getElementById("firstImage");
                    imgContainer.innerHTML = '';
                    imgContainer.appendChild(img);

                    // Add loaded image to popup
                    const img2 = img.cloneNode(true);
                    img2.style.maxHeight = '3rem'
                    document.getElementById('addImagePopup').appendChild(img2);

                    // Add on click listeners
                    document.getElementById("showAddImagePopupBtn").addEventListener('click', showFilesAdded)
                    // Handle file input changes
                    document.getElementById('newExtraImage').addEventListener('change', function(event) {
                        const files = event.target.files;
                        for (let file of files) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const slide = document.createElement('div');
                                slide.className = 'd-none';
                                slide.innerHTML = `<img src="${e.target.result}" alt="Slide Image">`;
                                document.getElementById('imgContainer').appendChild(slide);
                                nbImages+=1
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                    document.querySelector('.bi-chevron-right').addEventListener('click', goToNextSlide);
                    document.querySelector('.bi-chevron-left').addEventListener('click', goToPrevSlide);


                    const fileInputContainer = document.getElementById("fileInputContainer");
                    fileInputContainer.appendChild(fileInput);
                };
                reader.readAsDataURL(fileInput.files[0]);
            })
            .catch(error => {
                console.error('Error fetching PHP file:', error);
            });

    }
}

function showFilesAdded() {
    console.log("show files")
    const addImagePopup = document.getElementById('addImagePopup');
    addImagePopup.style.display = 'flex';
    addImagePopup.classList.remove('d-none');
    const showBtn = document.getElementById('showAddImagePopupBtn')
    showBtn.removeEventListener('click',showFilesAdded);
    showBtn.addEventListener('click', hideFilesAdded);}

function hideFilesAdded() {
    console.log("hide files")
    const addImagePopup = document.getElementById('addImagePopup');
    addImagePopup.classList.add('d-none')
    const showBtn = document.getElementById('showAddImagePopupBtn')
        showBtn.removeEventListener('click', hideFilesAdded);
    showBtn.addEventListener('click', showFilesAdded);
}




function addDescriptionToEvent() {
    if (fileInput.files.length > 0) {
        const container = document.getElementById("createContainer");

        const title = document.getElementById("newPublicationTitle");
        title.classList.remove('justify-content-center');
        title.classList.add('justify-content-between');

        const submitButton = document.getElementById("submitBtn");
        submitButton.style.display = 'inline-block';
        submitButton.addEventListener('click', function() {
            const form = document.getElementById("createPublicationForm");
            form.submit();
        });

        // Fetch the content of the PHP file
        fetch('../src/Vue/publication/createPublication.php')
            .then(response => response.text())
            .then(htmlContent => {
                // Replace the content of the container with the fetched HTML
                container.innerHTML = htmlContent;

                // Display the selected image
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result.toString();
                    img.alt = 'Image sélectionnée';
                    img.width = 200;
                    img.height = 200;
                    img.classList.add("img-fluid");

                    // Add the image to the image container
                    const imgContainer = document.getElementById("imgContainer");
                    imgContainer.innerHTML = '';
                    imgContainer.appendChild(img);

                    const fileInputContainer = document.getElementById("fileInputContainer");
                    fileInputContainer.appendChild(fileInput);

                };
                reader.readAsDataURL(fileInput.files[0]);
            })
            .catch(error => {
                console.error('Error fetching PHP file:', error);
            });
    }
}

// Carousel logic
let currentSlideIndex = 0;

function goToSlide(slideIndex) {
    const slides = document.querySelectorAll('.carousel-image');
    const totalWidth = imgContainer.offsetWidth * slideIndex;
    slides.forEach((slide) => {
        slide.style.transform = `translateX(-${totalWidth}px)`;
    });
    currentSlideIndex = slideIndex;
}

function goToNextSlide() {
    const slides = document.querySelectorAll('.carousel-slide');
    if (currentSlideIndex < slides.length - 1) {
        goToSlide(currentSlideIndex + 1);
    }
}

function goToPrevSlide() {
    if (currentSlideIndex > 0) {
        goToSlide(currentSlideIndex - 1);
    }
}



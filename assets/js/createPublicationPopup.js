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

let nbImages = 1
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
                    const imgContainer = document.getElementById("slide1");
                    imgContainer.innerHTML = '';
                    imgContainer.appendChild(img);

                    // Add loaded image to popup
                    const img2 = img.cloneNode(true);
                    document.getElementById('addImagePopup').appendChild(img2);

                    // Add on click listeners
                    document.getElementById("showAddImagePopupBtn").addEventListener('click', showFilesAdded)
                    const rightBtn = document.querySelector('.bi-chevron-right')
                    rightBtn.addEventListener('click', goToNextSlide);
                    const leftBtn = document.querySelector('.bi-chevron-left')
                    leftBtn.addEventListener('click', goToPrevSlide);

                    const fileInputContainer = document.getElementById("fileInputContainer");

                    // Handle file input changes
                    document.getElementById('newExtraImage').addEventListener('change', function(event) {
                        const files = event.target.files;
                        for (let file of files) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const slide = document.createElement('div');
                                slide.id = 'slide'+(nbImages+1)
                                slide.innerHTML = `<img src="${e.target.result}" alt="Slide Image">`;

                                // Add to popup
                                const popupImage = slide.cloneNode(true)
                                popupImage.classList.add('me-1')
                                document.getElementById('addImagePopup').appendChild(popupImage)

                                // Add to list of files
                                slide.style.display = 'none';
                                fileInputContainer.appendChild(slide.cloneNode(true))

                                // Add to carousel
                                slide.classList.add('carousel-image')
                                document.getElementById('imgContainer').appendChild(slide);

                                nbImages++

                                rightBtn.classList.remove('d-none')
                                rightBtn.style.display = 'block'

                                // 3 images max
                                if (nbImages >= 3) {
                                    const btn = document.getElementById('addImageBtn')
                                    btn.classList.remove('d-flex')
                                    btn.classList.add('d-none')
                                }
                            };
                            reader.readAsDataURL(file);
                        }
                    });

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
    const addImagePopup = document.getElementById('addImagePopup');
    addImagePopup.style.display = 'flex';
    addImagePopup.classList.remove('d-none');
    const showBtn = document.getElementById('showAddImagePopupBtn')
    showBtn.removeEventListener('click',showFilesAdded);
    showBtn.addEventListener('click', hideFilesAdded);}

function hideFilesAdded() {
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

        // Show submit button
        const submitButton = document.getElementById("submitBtn");
        submitButton.style.display = 'inline-block';
        submitButton.addEventListener('click', function() {
            const form = document.getElementById("createPublicationForm");
            form.submit();
        });

        // Hide next button
        document.getElementById('nextBtn').style.display = 'none'

        const images = document.getElementById('imgContainer')
        const carousel = document.getElementById('carouselDiv')
        const children = images.children;

        for (let i = 0; i < children.length; i++) {
            // Set the display of the first child to 'block' and the rest to 'none'
            children[i].style.display = i === 0 ? 'flex' : 'none';
        }

        if (children.length === 1) {
            document.querySelector('.bi-chevron-right').style.display = 'none'
        }
        document.querySelector('.bi-chevron-left').style.display = 'none'


        // Fetch the content of the PHP file
        fetch('../src/Vue/publication/createPublication.php')
            .then(response => response.text())
            .then(htmlContent => {
                // Replace the content of the container with the fetched HTML
                container.innerHTML = htmlContent;
                const addCarousel = document.getElementById('addCarousel')

                // Add the previous images to the carousel
                Array.from(carousel.children).forEach(child => {
                    const clone = child.cloneNode(true); // deep clone the child
                    addCarousel.append(clone);
                });

                const rightBtn = document.querySelector('.bi-chevron-right')
                rightBtn.addEventListener('click', goToNextSlide);
                const leftBtn = document.querySelector('.bi-chevron-left')
                leftBtn.addEventListener('click', goToPrevSlide);

            })
            .catch(error => {
                console.error('Error fetching PHP file:', error);
            });


    }
}

// Carousel logic
let currentSlideIndex = 1;

function goToSlide(nextSlide) {
    console.log('current slide : '+currentSlideIndex)
    console.log('next slide : '+nextSlide)
    document.getElementById('slide'+currentSlideIndex).style.display = 'none'
    document.getElementById('slide'+nextSlide).style.display = 'flex'
    currentSlideIndex = nextSlide
}

function showArrow(type) {
    const btn = document.querySelector('.bi-chevron-'+type)
    btn.style.display = 'block'
    btn.classList.remove('d-none')
}

function hideArrow(type) {
    const btn = document.querySelector('.bi-chevron-'+type)
    btn.style.display = 'none'
}

const types = ['left', 'right']

function goToNextSlide() {
    console.log('next slide')
    const slides = document.querySelectorAll('.carousel-image');
    if (currentSlideIndex+1 === slides.length) {
        hideArrow('right')
    }
    showArrow('left')
    goToSlide(currentSlideIndex+1);
}

function goToPrevSlide() {
    if (currentSlideIndex - 1 === 1) {
        hideArrow('left')
    }
    showArrow('right')
    goToSlide(currentSlideIndex-1)
}



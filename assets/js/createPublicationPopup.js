// Listener on create event popup
document.getElementById('popupCreate').addEventListener('show.bs.modal', function () {
    loadCreatePublicationContent();
});

let fileInput;

function loadCreatePublicationContent() {
    const container = document.getElementById("createContainer");

    // Fetch the content of the PHP file
    fetch('../src/Vue/uploadImage.php')
        .then(response => response.text())
        .then(htmlContent => {
            // Replace the content of the container with the fetched HTML
            container.innerHTML = htmlContent;
            fileInput = document.getElementById("newImage");
            fileInput.addEventListener('change', addDescriptionToEvent);
        })
        .catch(error => {
            console.error('Error fetching PHP file:', error);
        });
}

function addDescriptionToEvent() {
    if (fileInput.files.length > 0) {
        const container = document.getElementById("createContainer");

        const title = document.getElementById("newPublicationTitle");

        const submitButton = document.getElementById("submitBtn");
        submitButton.style.display = 'inline-block';
        submitButton.addEventListener('click', function() {
            const form = document.getElementById("createPublicationForm");
            form.submit();
        });

        title.appendChild(submitButton);
        // Fetch the content of the PHP file
        fetch('../src/Vue/createPublication.php')
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



const fileInput = document.getElementById("newImage");
fileInput.addEventListener('change', addDescriptionToEvent);

function like() {
    document.querySelectorAll(".heart-btn").forEach(heartBtn => {
        if (heartBtn.children[0].getAttribute("class") === "bi bi-heart-fill") {
            clearHeart(heartBtn.children[0]);
        }
        else {
            fillHeart(heartBtn.children[0]);
        }
    });
}

function fillHeart(heartSVG) {

    heartSVG.setAttribute("class", "bi bi-heart-fill");

    const path = heartSVG.querySelector("path");

    path.setAttribute("fill-rule", "evenodd");
    path.setAttribute("d", "M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314");
}

function clearHeart(heartSVG) {
    heartSVG.setAttribute("class", "bi bi-heart");
    const path = heartSVG.querySelector("path");
    path.removeAttribute("fill-rule");

    path.setAttribute("d", "m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15");
}

function focusOnInput(inputID) {
    document.getElementById(inputID).focus();
}

function addDescriptionToEvent() {
    if (fileInput.files.length > 0) {
        const container = document.getElementById("createContainer");

        const row = document.createElement('div');
        row.classList.add('row');
        row.classList.add('gx-0');

        const imgContainer = document.createElement("div");
        imgContainer.classList.add("col-6");
        imgContainer.classList.add("d-flex");
        imgContainer.classList.add("justify-content-center");

        const textContainer = document.createElement("div");
        textContainer.classList.add("col-6");
        textContainer.classList.add("d-flex");
        textContainer.classList.add("flex-column");


        const text = document.createElement('input');
        text.placeholder = 'Ajouter une description...';
        text.type = 'text';
        text.classList.add("border-0");
        text.classList.add("container-fluid");
        text.classList.add("flex-grow");
        text.classList.add("no-outline-focus");

        const location = document.createElement('input');
        location.placeholder = "Ajouter un lieu";
        location.classList.add("border-0");
        location.classList.add("pb-3");
        location.classList.add("no-outline-focus");

        textContainer.append(text, location);

        row.append(imgContainer, textContainer);

        // Display the selected image
        const reader = new FileReader();

        reader.onload = function (e) {

            const img = document.createElement('img');
            img.src = e.target.result.toString();

            img.alt = 'Image sélectionnée';
            img.width = 200;
            img.height = 200;
            img.classList.add("img-fluid");

            imgContainer.appendChild(img);

            container.innerHTML = '';
            container.appendChild(row);
        };

        reader.readAsDataURL(fileInput.files[0]);
    }


}
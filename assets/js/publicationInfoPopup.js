// Listener on heart buttons for publications
document.getElementById('publicationsContainer').addEventListener('click', event => onHeartButtonClicked(event));
// Listener on heart buttons for publication popups
document.getElementById('commentsContainer').addEventListener('click', event=> onHeartButtonClicked(event));

// Listener on show info popup
document.querySelectorAll('.comment-popup').forEach(commentPopup => {
    commentPopup.addEventListener('show.bs.modal', function () {
        loadPopup();
    });
});
function onHeartButtonClicked(event) {
    // Check if the clicked element is a div with data-publication-id attribute
    const svgPath = event.target.closest('div[data-publication-id]');

    if (svgPath) {
        // Pass the clicked button directly to the like function
        const heartBtn = svgPath.closest('div[data-publication-id]');
        const publicationID = heartBtn.getAttribute('data-publication-id');

        like(heartBtn, publicationID);
    }
}

// Dynamically load comments
document.addEventListener('DOMContentLoaded', updateComments);

// Update interface on comment creation
document.getElementById('commentForm').addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    fetch('controleurFrontal.php', {
        method: 'POST',
        body: formData
    }).then(result => result.text())
        .then(htmlContent => {
            const commentsContainer = document.getElementById("commentsContainer");
            commentsContainer.innerHTML += htmlContent;
        });
    const input = document.getElementById("commentInput");
    input.value = '';
})


function like(publicationID) {

    let content = "publicationID=" + encodeURIComponent(publicationID.dataset.publicationId) + "&controleur=like&action=";

    // Find the svg element inside the clicked button
    const svgElement = document.querySelector('.heart'+publicationID.dataset.publicationId);

    if (svgElement.classList.contains("bi-heart-fill")) {
        clearHeart(publicationID.dataset.publicationId);
        updateLikeCounter(-1, publicationID.dataset.publicationId);
        content += "unlike";
    } else {
        fillHeart(publicationID.dataset.publicationId);
        content += "like";
        updateLikeCounter(1, publicationID.dataset.publicationId);
    }

    // Update database
    fetch('controleurFrontal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: content,
    });
}


function fillHeart(publicationID) {
    document.querySelectorAll('.heart'+publicationID).forEach(heartSVG=>{
        heartSVG.setAttribute("class", "bi bi-heart-fill heart"+publicationID);

        const path = heartSVG.querySelector("path");

        path.setAttribute("fill-rule", "evenodd");
        path.setAttribute("d", "M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314");
    });
}

function updateLikeCounter(nb, publicationID) {
    document.querySelectorAll(".nbLikes" + publicationID).forEach(likeCounter => {
        likeCounter.textContent = (parseInt(likeCounter.textContent, 10) + nb).toString() + " J'aime";
    });
}

function clearHeart(publicationID) {
    document.querySelectorAll('.heart'+publicationID).forEach(heartSVG=>{
        heartSVG.setAttribute("class", "bi bi-heart heart"+publicationID);
        const path = heartSVG.querySelector("path");
        path.removeAttribute("fill-rule");
        path.setAttribute("d", "m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15");
    });
}

function focusOnInput(inputID) {
    document.getElementById(inputID).focus();
}

function updateComments() {
    const commentElements = document.querySelectorAll('.comment');

    // Fetch and update each comment
    commentElements.forEach(commentElement => {
        const commentData = JSON.parse(commentElement.getAttribute('data-comment'));

        // Convert commentData into set  of key-value pairs
        const queryParams = new URLSearchParams(commentData);


        fetch('controleurFrontal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: queryParams.toString(),
        }).then(response => response.text())
            .then(data => {
                // Update the content of the comment element with the fetched HTML
                commentElement.innerHTML = data;
            });
    });
}

function replyToComment(replyToUser, commentID) {
    const input = document.getElementById("commentInput");
    input.value = '@'+replyToUser;
    const form = document.getElementById("commentForm");
    const replyToCommentID = document.createElement('input');
    replyToCommentID.type = 'hidden';
    replyToCommentID.name = 'replyToCommentID';
    replyToCommentID.value = commentID;
    form.appendChild(replyToCommentID);
}

function showAnswers(commentID) {
    const answersContainer = document.getElementById("answersForComment"+commentID);
    answersContainer.style.display = 'block';
    const btn = document.getElementById("showAnswersBtn"+commentID);
    btn.textContent = 'Masquer les réponses';
    btn.addEventListener('click', event => hideAnswers(commentID));
}

function hideAnswers(commentID) {
    const answersContainer = document.getElementById("answersForComment"+commentID);
    answersContainer.style.display = 'none';
    const btn = document.getElementById("showAnswersBtn"+commentID);
    btn.textContent = 'Afficher les réponses';
    btn.addEventListener('click', event => showAnswers(commentID));
}

function loadPopup() {
    const input = document.getElementById('commentInput');
    input.value = '';
}
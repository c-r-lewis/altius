const homePagePublicationsBtn = document.getElementById('publications');

function showLoader(event) {
    // Prevent the default link behavior
    event.preventDefault();

    document.getElementById('loader-overlay').style.display = 'block';

    // Load the page
    if (event.target.tagName === "IMG") {
        window.location.href = event.target.parentNode.href;
    }
    else if(event.target.tagName !== "A") {
        window.location.href = this.querySelector('a').getAttribute('href');
    }
    else {
        window.location.href = event.target.href;
    }
}


// Home page
if (homePagePublicationsBtn) {
    homePagePublicationsBtn.addEventListener('click', function(event) {
        showLoader(event);
    });
    document.getElementById('forums').addEventListener('click', function(event) {
        showLoader(event);
    });
}

// Menu
document.getElementById('calendarBtn').addEventListener('click', function(event) {
    showLoader(event);
});
document.getElementById('forumBtn').addEventListener('click', function(event) {
    showLoader(event);
});

document.getElementById('homeBtn').addEventListener('click', function(event) {
    showLoader(event);
});

document.getElementById('navbarBrand').addEventListener('click', function(event) {
    showLoader(event);
});

// Hide the loader when the page has finished loading
window.addEventListener('load', function() {
    hideLoader();
});

function hideLoader() {
    document.getElementById('loader-overlay').style.display = 'none';
}
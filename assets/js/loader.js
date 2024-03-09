
function showLoader(event) {
    // Prevent the default link behavior
    event.preventDefault();

    document.getElementById('loader-overlay').style.display = 'block';

    // Load the page
    if (event.target.tagName !== "A") {
        console.log(event);
        window.location.href = this.querySelector('a').getAttribute('href');
    }
    else {
        window.location.href = event.target.href;
    }
}

document.getElementById('publications').addEventListener('click', function(event) {
    showLoader(event);
});

document.getElementById('calendarBtn').addEventListener('click', function(event) {
    showLoader(event);
});

// Hide the loader when the page has finished loading
window.addEventListener('load', function() {
    document.getElementById('loader-overlay').style.display = 'none';
});

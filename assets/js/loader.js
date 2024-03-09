function showLoader() {
    document.getElementById('loader-overlay').style.display = 'block';
}

document.getElementById('publications').addEventListener('click', function(event) {
    // Prevent the default link behavior
    event.preventDefault();

    showLoader();

    // Load the page
    window.location.href = this.querySelector('a').getAttribute('href');
});

// Hide the loader when the page has finished loading
window.addEventListener('load', function() {
    document.getElementById('loader-overlay').style.display = 'none';
});

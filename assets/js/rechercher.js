const searchBar = document.getElementById('searchBar');
const researchResults = document.getElementById('researchResults');
searchBar.addEventListener('input', getResults);

function emptyResults() {
    researchResults.innerHTML = '';
}
function getResults(event) {
    event.preventDefault();
    const data = new FormData();
    data.append('action', 'rechercherAmis');
    data.append('controleur', 'Friends');
    data.append('typed', searchBar.value);

    fetch('../web/controleurFrontal.php', {
        method: 'POST',
        body: data
    })
        .then(response => response.json())
        .then(results =>
        {
            emptyResults();
            results.forEach(result => {
                const node = document.createElement('li');
                node.classList.add('list-group-item');
                node.textContent = result.login;
                researchResults.appendChild(node);
            });
        })
}

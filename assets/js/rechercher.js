const searchBar = document.getElementById('searchBar');
const researchResults = document.getElementById('researchResults');
const findContent = document.getElementById('findContent');
const sendBtn = document.getElementById('sendBtn');
const results = document.getElementById('results');

searchBar.addEventListener('input', getResults);
searchBar.addEventListener('blur', emptyResults);

sendBtn.addEventListener('click', (event) => {
    event.preventDefault();
    chooseUser(searchBar.value);
})

function emptyResults() {
    // Delay clearing the results to allow for click events to be processed
    setTimeout(() => {
        // Check if the search bar is no longer focused
        if (document.activeElement !== searchBar) {
            researchResults.innerHTML = '';
        }
    }, 100);
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
            researchResults.innerHTML = '';
            results.forEach(result => {
                const node = document.createElement('li');
                node.classList.add('list-group-item');
                node.textContent = result.login;
                node.addEventListener('click', ()=> {
                    console.log('node clicked');
                    chooseUser(result.login);
                });
                researchResults.appendChild(node);
            });
        })
}

function chooseUser(login) {
    const form = new FormData();
    form.append('action', 'selectionParRecherche');
    form.append('controleur', 'utilisateur');
    form.append('recherche', login);
    fetch('../web/controleurFrontal.php', {
        method: 'POST',
        body: form
    })
        .then(result => result.text())
        .then(htmlContent => {
            emptyResults();
            searchBar.value = login;
            findContent.innerHTML = htmlContent;
        })
}


// Search bar
document.querySelector('.search').addEventListener('click', function (e) {
    e.preventDefault();
    const searchContainer = this.closest('.search-container');
    searchContainer.classList.toggle('active');
    document.querySelectorAll('nav ul li').forEach(function (li) {
        if (!(li.classList.contains('search-container'))) {
            li.classList.toggle('hide-item');
        }
    });
});

document.querySelector('.close-search').addEventListener('click', function (e) {
    e.preventDefault();
    const searchContainer = this.closest('.search-container');
    searchContainer.classList.remove('active');

    document.querySelectorAll('nav ul li').forEach(function (li) {
        if (!li.classList.contains('search-container')) {
            li.classList.toggle('hide-item');
        }
    });
});

// Funzione per aggiornare i risultati nel DOM
function updateResults(results) {
    const resultsList = document.getElementById('search-content');
    clear();
    fetch('views/components/cards/vinyls.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`Errore nel caricamento del template: ${response.status}`);
        }
        return response.text();
    })
    .then(templateHTML => {
        // Inserire il contenuto del template direttamente nel DOM nascosto
        document.body.insertAdjacentHTML("beforeend", templateHTML);

        // Recuperare il template appena aggiunto
        const template = document.getElementById("search-vinyl");

        Array.prototype.forEach.call(results.message, result => {
            const clone = template.content.cloneNode(true);
            clone.querySelector(".vinyl-cover").src = "/resources/img/albums/" + result.cover_img;
            clone.querySelector(".vinyl-title").textContent = result.title;
            clone.querySelector(".vinyl-artist").textContent = result.artist;
            clone.querySelector(".vinyl-genre").textContent = result.genre;
            clone.querySelector(".vinyl-cost").textContent = result.cost;
            resultsList.appendChild(clone);
        }
    );
    })
}

function clear() {
    document.getElementById('search-content').innerHTML = ''; // Svuota i risultati precedenti
}

document.getElementById('search-input').addEventListener('input', function() {
    const filter = document.getElementById('search-select');
    if (document.getElementById('search-input').value !== '') {
        fetch(`/search?${filter.value}=${encodeURIComponent(document.getElementById('search-input').value)}`)
        .then(async (response) => {
            if (response.ok) {
                return await response.json();
            } else {
                throw new Error("Server response was not ok");
            }
        })
        .then(async (data) => {
            await updateResults(data);
        });
    } else {
        clear();
    }
});
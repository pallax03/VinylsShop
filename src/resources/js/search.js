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
    window.scrollTo(0, 0);
    setTimeout(function() {document.getElementById('input-search').focus();}, 500);
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
    const resultsList = document.getElementById('sec-search_content');
    if (results.message.length !== 0) {
        clear();
        Object.values(results.message).forEach(result =>{
            resultsList.appendChild(createCard(result));
        })
    }
}

function clear() {
    document.getElementById('sec-search_content').innerHTML = ''; // Svuota i risultati precedenti
}

document.getElementById('btn-search_close').addEventListener('click', function() {
    document.getElementById('main-content').ariaHidden = 'false';
    document.getElementById('sec-search_content').ariaHidden = 'true';
    document.getElementById('input-search').value = "";
    document.getElementById('sec-search_content').style = 'display: none';
    document.getElementById('main-content').style = 'display: flex';
});

function search() {
    const filter = document.getElementById('select-search_filter');
    if (document.getElementById('input-search').value !== '') {
        fetch(`/search?${filter.value}=${encodeURIComponent(document.getElementById('input-search').value)}`)
        .then(async (response) => {
            if (response.ok) {
                return await response.json();
            } else {
                throw new Error("Server response was not ok");
            }
        })
        .then(async (data) => {
            document.getElementById('main-content').ariaHidden = 'true';
            document.getElementById('sec-search_content').ariaHidden = 'false';
            document.getElementById('main-content').style = 'display: none';
            document.getElementById('sec-search_content').style = 'display: flex';
            await updateResults(data);
        });
    } else {
        clear();
    }
}

function createCard(result) {
        const itemElement = document.createElement('div');
        itemElement.innerHTML = `<div class="search-card">
            <a class="vinyl-preview" href="/vinyl?id=${result.id_vinyl}">
                <p class="vinyl-title" title="${result.title}">${result.title}</p>
                <div class="cover-container">
                    <img class="vinyl-cover" src="/resources/img/albums/${result.cover}"/>
                </div>
                <div class="vinyl-info">
                    <p class="vinyl-artist">${result.artist}</p>
                    <p class="vinyl-genre">#${result.genre}</p>
                </div>
                <a class="add-cart" onclick="addToCart(${result.id_vinyl}, 1)">Add to cart - €${result.cost}</a>
            </a>
        </div>
        `;
        return itemElement.firstElementChild;
}

document.getElementById('select-search_filter').addEventListener('change', search);
document.getElementById('input-search').addEventListener('input', search);
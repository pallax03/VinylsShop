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

// variable to handle notification timeout overlapping
let timeout;
// Funzione per aggiornare i risultati nel DOM
function updateResults(results) {
    const resultsList = document.getElementById('sec-search_content');
    fetch('views/components/cards/vinyl.php')
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

        // Se non ci sono risultati
        if (results.message.length !== 0) {
            clear();
            Array.prototype.forEach.call(results.message, result => {
                const clone = template.content.cloneNode(true);
                clone.querySelector(".vinyl-cover").src = "/resources/img/albums/" + result.cover;
                clone.querySelector(".vinyl-preview").href = "/vinyl?id=" + result.id_vinyl;
                clone.querySelector(".vinyl-title").textContent = result.title;
                clone.querySelector(".vinyl-title").title = result.title;
                clone.querySelector(".vinyl-artist").textContent = result.artist;
                clone.querySelector(".vinyl-genre").textContent = "#" + result.genre;
                clone.querySelector(".add-cart").textContent = "Add to cart - €" + result.cost;
                clone.querySelector(".add-cart").onclick = function() {
                    const modal = document.querySelector(".modal");
                        fetch('views/components/cards/notification.php')
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
                            const notify_template = document.getElementById("notification-card");
                            const notify_clone = notify_template.content.cloneNode(true);
                            const div = notify_clone.querySelector(".notification");
                            if (addToCart(result.id_vinyl, 1)) {
                                notify_clone.querySelector(".message").textContent = "Succesfully added to cart!";
                                notify_clone.querySelector(".icon").src = "/resources/img/icons/tick.png";
                            } else {
                                notify_clone.querySelector(".message").textContent = "Cannot add to cart";
                                notify_clone.querySelector(".icon").src = "/resources/img/icons/error.png";
                            }
                            modal.appendChild(notify_clone);
                            modal.classList.add("modal-in");
                            if (!timeout) {
                                timeout = true;
                                setTimeout(() => {
                                    modal.classList.add("modal-out");
                                    modal.classList.remove("modal-in");
                                    setTimeout(() => {
                                        modal.innerHTML = "";
                                        modal.classList.remove("modal-out");
                                        timeout = false;
                                    }, 1000);
                                }, 2000);
                            }
                        });
                };
                resultsList.appendChild(clone);
            });
        }
    })
}

function clear() {
    document.getElementById('sec-search_content').innerHTML = ''; // Svuota i risultati precedenti
}

document.getElementById('btn-search_close').addEventListener('click', function() {
    document.getElementById('main-content').ariaHidden = 'false';
    document.getElementById('sec-search_content').ariaHidden = 'true';
    document.getElementById('main-content').style = 'display: block';
    document.getElementById('input-search').value = "";
    document.getElementById('sec-search_content').style = 'display: none';
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

document.getElementById('select-search_filter').addEventListener('change', search);
document.getElementById('input-search').addEventListener('input', search);
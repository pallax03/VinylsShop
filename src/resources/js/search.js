// Funzione per aggiornare i risultati nel DOM
function updateResults(results) {
    const resultsList = document.getElementById('search-content');
    resultsList.innerHTML = ''; // Svuota i risultati precedenti
    console.log(results);
    Array.prototype.forEach.call(results, result => {
            const li = document.createElement('li');
            li.textContent = result.title; // Supponiamo che ogni risultato abbia un campo "name"
            resultsList.appendChild(li);
        }
    );
}

document.getElementById('search-input').addEventListener('input', function() {
        const filter = document.getElementById('search-select');
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
        }
    );
});
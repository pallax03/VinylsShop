section = document.getElementById("sec-dynamic_content");

function loadUsers() {
    fetch('/users').then(response => {
        return response.json();
    }
    ).then(json => {
        section.innerHTML = "";
        json.forEach(user => {
            
        });
    });
}
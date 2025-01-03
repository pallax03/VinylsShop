section = document.getElementById("sec-dynamic_content");

function loadUsers() {
    fetch('/users/table').then(response => {
        return response;
    }
    ).then(html => {
        section.innerHTML = html;
    });
}
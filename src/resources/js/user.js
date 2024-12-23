document.getElementById('delete-account').addEventListener('click', function() {
    fetch('/user', {
        method: 'DELETE',
        headers: {}
    }).then((response) => {
        if (!response.ok) {
            throw new Error("Server response was not ok");
        }
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.href = '/logout';
    });
});



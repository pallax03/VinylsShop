document.getElementById("btn-admin_submit").addEventListener("click", function (event) {
    event.preventDefault();
    const mail = document.getElementById("input-admin_mail");
    const password = document.getElementById("input-admin_password");

    if(validateData(mail)) {
        addAdmin(mail, password);
    }
});

function addAdmin(mail, password) {
    makeRequest(fetch('/superuser', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({mail: mail.value, password: password.value})
    })).then((data) => {
        createNotification(data, true, '/dashboard/users', 'bi bi-person');
        setTimeout(() => { window.location.href = "/dashboard/users"; }, 2000);
    })
    .catch((error) => {
        createNotification(error, false);
    });
}
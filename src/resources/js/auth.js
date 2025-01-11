document.querySelectorAll(".checkbox").forEach((checkbox) => {
    checkbox.addEventListener("click", function (event) {
        const input = this.querySelector("input");
        input.checked = !input.checked;
    });
});

document.getElementById("btn-login_submit").addEventListener("click", function (event) {
    event.preventDefault();
    const mail = document.getElementById("input-login_mail");
    const password = document.getElementById("input-login_password");
    mail.parse = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    validateData(mail);

    const params = new URLSearchParams();
    params.append("mail", mail.value);
    params.append("password", password.value);
    params.append(
        "remember",
        document.getElementById("input-login_remember").checked
    );

    makeRequest(fetch("/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params.toString(),
    }))
    .then((data) => {
        document.getElementById("btn-login_submit").disabled = true;
        createNotification(data, true, "/user", "bi bi-person");
        setTimeout(() => { redirect('/'); }, 2000);
    })
    .catch((error) => {
        createNotification(error, false);
    });
});

function register(mail, password, notifications) {
    const params = new URLSearchParams();
    params.append("mail", mail.value);
    params.append("password", password.value);
    params.append("notifications", notifications.checked);

    makeRequest(fetch("/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params.toString(),
    })).then((data) => {
        document.getElementById("btn-register_submit").disabled = true;
        createNotification(data, true, '/user', 'bi bi-person');        
        setTimeout(() => { redirect('/'); }, 2000);
    })
        .catch((error) => {
            createNotification(error, false);
        });
}

document.getElementById("btn-register_submit").addEventListener("click", function (event) {
    event.preventDefault();
    const mail = document.getElementById("input-register_mail");
    const password = document.getElementById("input-register_password");
    const notifications = document.getElementById("input-register_notifications");
    mail.parse = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (validateData(mail)) {
        register(mail, password, notifications);
    }
});

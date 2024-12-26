document.querySelector(".checkbox").addEventListener("click", function () {
    document.getElementById("input-login_remember").checked =
        !document.getElementById("input-login_remember").checked;
});

document.getElementById("btn-login_submit").addEventListener("click", function (event) {
    event.preventDefault();
    const mail = document.getElementById("input-login_mail");
    const password = document.getElementById("input-login_password");
    
    validateData(mail);

    const params = new URLSearchParams();
    params.append("mail", mail.value);
    params.append("password", password.value);
    params.append("remember",
        document.getElementById("input-login_remember").checked
    );

    fetch("/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: params.toString(),
    })
        .then((response) => {
            return response.json().then((data) => {
                if (!response.ok) {
                    throw new Error(data.error || "Unknown error");
                }
                return data;
            });
        })
        .then((data) => {
            document.getElementById("btn-login_submit").disabled = true;
            document.getElementById("div-login_response").innerHTML = "<p>" + data.message + "</p>";

            setTimeout(() => {
                window.location.href = "/";
            }, 2000);
        })
        .catch((error) => {
            document.getElementById("div-login_response").innerHTML = '<p class="error">' + error.message + "</p>";
        });
});

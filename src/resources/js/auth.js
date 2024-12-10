document.getElementById("btn-login_submit").addEventListener("click", function (event) {
  event.preventDefault();

  const mail = document.getElementById("input-login_mail").value;
  const password = document.getElementById("input-login_password").value;

  const params = new URLSearchParams();
  params.append("mail", mail);
  params.append("password", password);

  fetch('/login', {
    method: 'POST',
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
      document.getElementById("div-login_response").innerHTML =
        '<p style="color: limegreen;">' + data.message + "</p>";

      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    })
    .catch((error) => {
      document.getElementById("div-login_response").innerHTML =
        '<p style="color: red;">' + error.message + "</p>";
    });
});

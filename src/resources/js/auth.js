document.getElementById("login_submit").addEventListener("click", function () {
  url = document.getElementById("login_form").getAttribute("action");
  method = document.getElementById("login_form").getAttribute("method");

  const mail = document.getElementById("mail").value;
  const password = document.getElementById("password").value;

  const params = new URLSearchParams();
  params.append("mail", mail);
  params.append("password", password);
  fetch(url, {
    method: method,
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
      document.getElementById("login_submit").disabled = true;
      document.getElementById("login_submit").style.visibility = "hidden";
      document.getElementById("login_response").innerHTML =
        '<p style="color: limegreen;">' + data.message + "</p>";

      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    })
    .catch((error) => {
      document.getElementById("login_response").innerHTML =
        '<p style="color: red;">' + error.message + "</p>";
    });
});

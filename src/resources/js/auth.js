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
      if (!response.ok) {
        throw new Error("Server response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      document.getElementById("login_submit").disabled = true;
      document.getElementById("login_submit").style.visibility = false;
      document.getElementById("login_response").innerHTML =
        '<p style="color: limegreen;">' + data["message"] + "</p>";

      setTimeout(() => {
        window.location.href = "/";
      }, 2000);
    })
    .catch((error) => {
      console.error("Error logging in:", error);
      // Handle login error
      document.getElementById("login_response").innerHTML =
        '<p style="color: red;">Error!</p>';
    });
});

document.querySelectorAll(".edit").forEach(btn =>{
    btn.onclick = function () {
        const form = document.getElementById("form-vinyl");
        const addForm = document.getElementById("form-album");
        /* if form isn't already shown, show it */
        if (form.classList.contains("hidden")) {
            form.classList.add("shown");
            form.classList.remove("hidden");
            if (addForm.classList.contains("shown")) {
                addForm.classList.add("hidden");
                addForm.classList.remove("shown");
            }
        }
        const tr = this.parentElement.parentElement;
        /* auto compiling the form */
        document.getElementById("input-cost").value = parseFloat(tr.querySelectorAll("td")[2].textContent.slice(1));
        document.getElementById("input-stock").value = parseInt(tr.querySelector("td").textContent.slice(0, -1), 10);
        document.getElementById("input-cost").focus();
        document.getElementById("input-cost").blur();
    }
});

document.getElementById("li-form_reset").onclick = function () {
    const form = document.getElementById("form-vinyl");
    form.classList.add("hidden");
    form.classList.remove("shown");
    /* auto compiling the form */
    document.getElementById("input-cost").value = "";
    document.getElementById("input-stock").value = "";
}

document.querySelector(".add").onclick = function () {
    const form = document.getElementById("form-vinyl");
    const addForm = document.getElementById("form-album");
    /* if form isn't already shown, show it */
    if (addForm.classList.contains("hidden")) {
        if (form.classList.contains("shown")) {
            form.classList.remove("shown");
            form.classList.add("hidden");
        }
        addForm.classList.add("shown");
        addForm.classList.remove("hidden");
    }
}

document.getElementById("input-cost").addEventListener("blur", function () {
    const input = document.getElementById("input-cost");
    let value = input.value;
    if (value === "") {
        return;
    }
    value = parseFloat(value).toFixed(2);
    input.value = value;
});
/*
    document.querySelectorAll(".edit").forEach(btn =>{
        btn.onclick = function () {
            const form = document.getElementById("form-vinyl");
            const addForm = document.getElementById("form-album");
            if form isn't already shown, show it
            if (form.classList.contains("hidden")) {
                form.classList.add("shown");
                form.classList.remove("hidden");
                if (addForm.classList.contains("shown")) {
                    addForm.classList.add("hidden");
                    addForm.classList.remove("shown");
                }
            }
            const tr = this.parentElement.parentElement;
            auto compiling the form
            document.getElementById("input-cost").value = parseFloat(tr.querySelectorAll("td")[2].textContent.slice(1));
            document.getElementById("input-stock").value = parseInt(tr.querySelector("td").textContent.slice(0, -1), 10);
            document.getElementById("input-cost").focus();
            document.getElementById("input-cost").blur();
        }
    });
*/

function loadVinyl(id) {
    let vinyl = document.getElementById('tr-vinyl_' + id);
    document.getElementById('input-cost').value = vinyl.getAttribute('data-cost');
    document.getElementById('input-stock').value = vinyl.getAttribute('data-stock');
    var form = document.getElementById('form-vinyl'); 
    form.setAttribute('data-id_vinyl', id);
    form.scrollIntoView({ behavior: 'smooth' });
    form.classList.remove("hidden");
}


document.getElementById('btn-vinyl_reset').addEventListener('click', function () {
    document.getElementById('form-vinyl').reset();
    document.getElementById('form-vinyl').classList.add("hidden");
});

document.getElementById("input-cost").addEventListener("blur", function () {
    const input = document.getElementById("input-cost");
    let value = input.value;
    if (value === "") {
        return;
    }
    value = parseFloat(value).toFixed(2);
    input.value = value;
});


document.getElementById("btn-vinyl_submit").addEventListener("click", function (event) {
    let form = document.getElementById('form-vinyl');
    let formData = new FormData(form);
    let id_vinyl = form.getAttribute('data-id_vinyl');
    if (id_vinyl !== '' || id_vinyl !== null) {
        formData.append('id_vinyl', id_vinyl);
    }
    makeRequest(fetch('/vinyl', {
        method: 'POST',
        body: formData
    })).then(data => { createNotification(data, true); setTimeout(() => { autoRefresh(); }, 2000); }).catch(error => { createNotification(error, false); });
});

document.querySelector(".add").onclick = function () {
    redirect('/dashboard/add');
}

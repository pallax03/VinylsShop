function deleteVinyl(id) {
    makeRequest(fetch('/vinyl?id_vinyl' + id, {
        method: 'DELETE'
    })).then(data => { createNotification(data, true); setTimeout(() => { autoRefresh(); }, 2000); }).catch(error => { createNotification(error, false); });
}

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

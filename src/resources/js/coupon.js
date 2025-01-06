
function setDefaultAddress(id = '') {
    fetch('/user/defaults', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_address: id
        })
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    });
}

function deleteAddress(id) {
    fetch('/user/address?id_address=' + id, {
        method: 'DELETE',
        headers: {}
    }).then((response) => {
        return response.json();
    }).then((data) => {
        console.log(data);
        window.location.reload();
    });
}

document.getElementById('btn-address_submit').addEventListener('click', function() {
    street_and_number = document.getElementById('input-address_street');
    city = document.getElementById('input-address_city');
    cap = document.getElementById('input-address_cap');
    cap.parse = /^\d{5}$/;
    if(validateData(street_and_number, city, cap)) {
        document.getElementById('form-address').submit();
    }
});



